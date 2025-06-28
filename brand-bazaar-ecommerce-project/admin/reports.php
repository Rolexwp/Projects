<?php
// Database configuration
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'brand_bazaar';

// Create connection
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

/**
 * Function to fetch a single statistic from the database.
 * @param mysqli $conn The database connection object.
 * @param string $query The SQL query to execute.
 * @param mixed $default The default value to return if no result is found.
 * @return mixed The fetched statistic value or the default value.
 */
function getStatistic($conn, $query, $default = 0) {
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        return $row[0];
    }
    return $default;
}

/**
 * Function to fetch multiple rows from the database.
 * @param mysqli $conn The database connection object.
 * @param string $query The SQL query to execute.
 * @return array An array of associative arrays, each representing a row.
 */
function getRows($conn, $query) {
    $rows = [];
    $result = mysqli_query($conn, $query);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
    }
    return $rows;
}

/**
 * Function to get customer orders with detailed items for a specific customer.
 * Used for fetching a customer's entire order history.
 * @param mysqli $conn The database connection object.
 * @param string $customer_id The ID of the customer.
 * @return array An array of detailed order information.
 */
function getCustomerOrdersDetailed($conn, $customer_id) {
    $orders = [];
    // Main query to get order details for a specific customer
    $query = "SELECT
                o.order_id as id,
                o.order_date as time,
                o.total_amount as total,
                o.order_status as status,
                o.payment_method,
                o.shipping_address,
                c.name as customer_name,
                c.email as customer_email,
                c.phone as customer_phone
              FROM customer_orders o
              JOIN site_customers c ON o.customer_id = c.customer_id
              WHERE o.customer_id = ?
              ORDER BY o.order_date DESC";

    $stmt = mysqli_prepare($conn, $query);
    if (!$stmt) {
        error_log("Prepare statement failed in getCustomerOrdersDetailed: " . mysqli_error($conn));
        return [];
    }
    // 's' for string, assuming customer_id is a string/varchar
    mysqli_stmt_bind_param($stmt, "s", $customer_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Query to get order items for each order
            $itemsQuery = "SELECT
                            aop.order_product_id,
                            aop.name,
                            aop.description,
                            aop.price,
                            aop.image_url as img,
                            oi.quantity
                          FROM customer_order_items oi
                          JOIN archived_order_products aop ON oi.order_product_id = aop.order_product_id
                          WHERE oi.order_id = ?";

            $stmtItems = mysqli_prepare($conn, $itemsQuery);
            if (!$stmtItems) {
                error_log("Prepare items statement failed in getCustomerOrdersDetailed: " . mysqli_error($conn));
                continue; // Skip to next order if item query fails
            }
            // 's' for string, assuming order_id is a string/varchar
            mysqli_stmt_bind_param($stmtItems, "s", $row['id']);
            mysqli_stmt_execute($stmtItems);
            $itemsResult = mysqli_stmt_get_result($stmtItems);

            $cart = [];
            if ($itemsResult) {
                while ($item = mysqli_fetch_assoc($itemsResult)) {
                    $cart[] = [
                        'name' => $item['name'],
                        'price' => $item['price'],
                        'img' => $item['img'],
                        'qty' => $item['quantity']
                    ];
                }
            }
            mysqli_stmt_close($stmtItems);

            // Attempt to parse shipping address as JSON, fallback to raw string if not valid JSON
            $address = json_decode($row['shipping_address'], true);
            if (!is_array($address)) { // If decoding fails or it's not an array
                $address = [
                    'name' => $row['customer_name'], // Use customer name as default if address not structured
                    'address' => $row['shipping_address'], // Use raw address string
                    'phone' => $row['customer_phone']
                ];
            }

            $row['cart'] = $cart;
            $row['address_parsed'] = $address;
            $orders[] = $row;
        }
    }
    mysqli_stmt_close($stmt);
    return $orders;
}

/**
 * Function to get a single order's detailed items by order_id.
 * Used for fetching details of a specific order.
 * @param mysqli $conn The database connection object.
 * @param string $order_id The ID of the order.
 * @return array|null An associative array of the single order's details, or null if not found.
 */
function getSingleOrderDetailed($conn, $order_id) {
    $order = null;

    $query = "SELECT
                o.order_id as id,
                o.order_date as time,
                o.total_amount as total,
                o.order_status as status,
                o.payment_method,
                o.shipping_address,
                c.name as customer_name,
                c.email as customer_email,
                c.phone as customer_phone,
                o.customer_id as customer_id_fk -- Get FK for potential customer lookup
              FROM customer_orders o
              JOIN site_customers c ON o.customer_id = c.customer_id
              WHERE o.order_id = ?";

    $stmt = mysqli_prepare($conn, $query);
    if (!$stmt) {
        error_log("Prepare single order statement failed in getSingleOrderDetailed: " . mysqli_error($conn));
        return null;
    }
    mysqli_stmt_bind_param($stmt, "s", $order_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $order = mysqli_fetch_assoc($result);

        $itemsQuery = "SELECT
                        aop.order_product_id,
                        aop.name,
                        aop.description,
                        aop.price,
                        aop.image_url as img,
                        oi.quantity
                      FROM customer_order_items oi
                      JOIN archived_order_products aop ON oi.order_product_id = aop.order_product_id
                      WHERE oi.order_id = ?";

        $stmtItems = mysqli_prepare($conn, $itemsQuery);
        if (!$stmtItems) {
            error_log("Prepare single order items statement failed in getSingleOrderDetailed: " . mysqli_error($conn));
            $order['cart'] = []; // Ensure cart is empty if query fails
        } else {
            mysqli_stmt_bind_param($stmtItems, "s", $order['id']);
            mysqli_stmt_execute($stmtItems);
            $itemsResult = mysqli_stmt_get_result($stmtItems);

            $cart = [];
            if ($itemsResult) {
                while ($item = mysqli_fetch_assoc($itemsResult)) {
                    $cart[] = [
                        'name' => $item['name'],
                        'price' => $item['price'],
                        'img' => $item['img'],
                        'qty' => $item['quantity']
                    ];
                }
            }
            mysqli_stmt_close($stmtItems);
            $order['cart'] = $cart;
        }

        $address = json_decode($order['shipping_address'], true);
        if (!is_array($address)) {
            $address = [
                'name' => $order['customer_name'],
                'address' => $order['shipping_address'],
                'phone' => $order['customer_phone']
            ];
        }
        $order['address_parsed'] = $address;
    }
    mysqli_stmt_close($stmt);
    return $order;
}


// --- Fetch General Report Data ---

// Total Sales: Sum of total_amount from completed orders
$totalSales = getStatistic($conn, "SELECT SUM(total_amount) FROM customer_orders WHERE order_status = 'completed'", 0);
// Total Orders: Count of all orders
$totalOrders = getStatistic($conn, "SELECT COUNT(*) FROM customer_orders", 0);
// Average Order Value: Average of total_amount from completed orders
$avgOrderValue = getStatistic($conn, "SELECT AVG(total_amount) FROM customer_orders WHERE order_status = 'completed'", 0);
// Total Customers: Count of all registered customers
$totalCustomers = getStatistic($conn, "SELECT COUNT(*) FROM site_customers", 0);

// Top 5 Selling Products: Joins order_items with products to sum quantities and revenues
$topProductsQuery = "
    SELECT
        sp.product_name,
        SUM(coi.quantity) AS units_sold,
        SUM(aop.price * coi.quantity) AS total_revenue
    FROM customer_order_items coi
    JOIN archived_order_products aop ON coi.order_product_id = aop.order_product_id
    JOIN store_products sp ON coi.product_id = sp.product_id
    GROUP BY sp.product_name
    ORDER BY units_sold DESC
    LIMIT 5
";
$topProducts = getRows($conn, $topProductsQuery);

// Recent Orders: Fetches the last 5 orders for a quick glance
$recentOrdersQuery = "
    SELECT
        order_id,
        customer_name,
        order_date,
        total_amount,
        order_status
    FROM customer_orders
    ORDER BY order_date DESC
    LIMIT 5
";
$recentOrders = getRows($conn, $recentOrdersQuery);

// --- Fetch Specific Customer Orders or Single Order (for reports page) ---
$customerOrders = [];
$customer_id_for_report = '';
$singleOrderDetails = null;
$fetchBy = ''; // 'customer' or 'order'

if (isset($_GET['customer_id']) && !empty($_GET['customer_id'])) {
    $customer_id_for_report = htmlspecialchars($_GET['customer_id']);
    $customerOrders = getCustomerOrdersDetailed($conn, $customer_id_for_report);
    $fetchBy = 'customer';
} elseif (isset($_GET['order_id']) && !empty($_GET['order_id'])) {
    $order_id_for_report = htmlspecialchars($_GET['order_id']);
    $singleOrderDetails = getSingleOrderDetailed($conn, $order_id_for_report);
    if ($singleOrderDetails) {
        // If a single order is found, we display it as a list of one order
        $customerOrders = [$singleOrderDetails];
        // Set the customer_id_for_report so the heading makes sense
        $customer_id_for_report = $singleOrderDetails['customer_id_fk'] ?? 'N/A';
    }
    $fetchBy = 'order';
}

// Close database connection
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Brand Bazaar - Admin Reports</title>
    <link rel="icon" type="image/x-icon" href="/icons/favicon.ico" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />
    <!-- Assuming admin.css contains the shared styles -->
    <link rel="stylesheet" href="../admin/css/admin.css" />
    <style>
      /* Additional specific styles for reports page if needed */
      .report-card {
        background-color: var(--admin-card-bg);
        border-radius: 8px;
        box-shadow: var(--admin-box-shadow);
        padding: 20px;
        margin-bottom: 20px;
      }
      .report-card h3 {
        margin-top: 0;
        color: var(--admin-text-color-light);
        font-size: 1.2em;
        margin-bottom: 10px;
      }
      .report-card .report-value {
        font-size: 2em;
        font-weight: bold;
        color: var(--admin-primary);
      }
      .report-section .stats-grid {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      }

      /* Styles for customer order details section */
      .customer-order-detail-card .product-row {
          display: flex;
          align-items: center;
          gap: 15px;
          padding: 10px;
          border-bottom: 1px dashed var(--admin-border);
      }
      .customer-order-detail-card .product-row:last-child {
          border-bottom: none;
      }
      .customer-order-detail-card .product-img {
          width: 50px;
          height: 50px;
          object-fit: cover;
          border-radius: 4px;
      }
      .customer-order-detail-card .product-info {
          flex-grow: 1;
      }
      .customer-order-detail-card .product-info strong {
          display: block;
          margin-bottom: 5px;
      }
      .customer-order-detail-card .product-qty-price {
          white-space: nowrap;
      }
      .customer-order-detail-card .order-summary {
          margin-top: 15px;
          padding-top: 15px;
          border-top: 1px solid var(--admin-border);
          text-align: right;
      }
      .customer-order-detail-card .order-summary div {
          margin-bottom: 5px;
      }
      .customer-order-detail-card .order-summary strong {
          font-size: 1.1em;
          color: var(--admin-primary);
      }
      .customer-order-detail-card .address-info,
      .customer-order-detail-card .payment-info {
          margin-top: 15px;
          padding-top: 15px;
          border-top: 1px dashed var(--admin-border);
      }
      .customer-order-detail-card .address-info p,
      .customer-order-detail-card .payment-info p {
          margin-bottom: 5px;
      }
      .customer-order-detail-card .status-badge {
          padding: 4px 10px;
          border-radius: 5px;
          font-weight: bold;
          font-size: 0.9em;
      }
      .customer-order-detail-card .badge-completed { background-color: #d4edda; color: #155724; }
      .customer-order-detail-card .badge-processing { background-color: #cfe2ff; color: #084298; }
      .customer-order-detail-card .badge-pending { background-color: #fff3cd; color: #664d03; }
      .customer-order-detail-card .badge-cancelled { background-color: #f8d7da; color: #842029; }
      .form-inline {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        .form-inline .form-group {
            flex-grow: 1;
        }
    </style>
  </head>
  <body class="admin-panel">
    <!-- Admin Header (Copied from admin.php) -->
    <header class="admin-header">
      <div class="admin-brand">
        <i class="fas fa-gem"></i>
        <span>Brand Bazaar Admin</span>
      </div>

      <div class="admin-header-controls">
        <div class="search-container">
          <i class="fas fa-search"></i>
          <input type="text" placeholder="Search..." id="globalSearch" />
        </div>

        <div class="notification-icon">
          <i class="fas fa-bell"></i>
          <span class="notification-badge">5</span>
          <div class="notification-dropdown">
            <div class="notification-item unread">
              <div class="notification-icon">
                <i class="fas fa-shopping-cart text-primary"></i>
              </div>
              <div class="notification-content">
                <h5>New Order Received</h5>
                <p>Order #ORD-2025-105 from John Smith</p>
                <div class="notification-time">10 min ago</div>
              </div>
            </div>
            <div class="notification-item">
              <div class="notification-icon">
                <i class="fas fa-user-plus text-success"></i>
              </div>
              <div class="notification-content">
                <h5>New Customer Registration</h5>
                <p>Robert Johnson joined the platform</p>
                <div class="notification-time">1 hour ago</div>
              </div>
            </div>
            <div class="notification-item unread">
              <div class="notification-icon">
                <i class="fas fa-exclamation-triangle text-warning"></i>
              </div>
              <div class="notification-content">
                <h5>Low Stock Alert</h5>
                <p>Wireless Earbuds 2 is out of stock</p>
                <div class="notification-time">3 hours ago</div>
              </div>
            </div>
            <div class="notification-item">
              <div class="notification-icon">
                <i class="fas fa-star text-warning"></i>
              </div>
              <div class="notification-content">
                <h5>Product Review</h5>
                <p>Emily Davis reviewed Flagship Ultrabook 2025</p>
                <div class="notification-time">Yesterday</div>
              </div>
            </div>
          </div>
        </div>

        <button class="dark-mode-toggle" id="darkModeToggle">
          <i class="fas fa-moon"></i>
        </button>

        <div class="admin-user" id="userDropdownToggle">
          <span>Admin User</span>
          <img
            src="https://randomuser.me/api/portraits/men/32.jpg"
            alt="Admin"
          />
          <div class="user-dropdown">
            <a href="#"><i class="fas fa-user-circle"></i> My Profile</a>
            <a href="#"><i class="fas fa-cog"></i> Account Settings</a>
            <a href="#"><i class="fas fa-question-circle"></i> Help Center</a>
            <a href="#" id="logoutBtn"
              ><i class="fas fa-sign-out-alt"></i> Logout</a
            >
          </div>
        </div>
      </div>
    </header>

    <!-- Admin Sidebar (Copied from admin.php) -->
    <aside class="admin-sidebar">
      <button class="menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i>
      </button>
      <ul class="admin-menu">
        <li>
          <a href="dashboard.php" class="active" data-section="dashboard">
            <i class="fas fa-tachometer-alt"></i>
            Dashboard
          </a>
        </li>
        <li>
          <a href="#products" id="productsMenu" data-section="products">
            <i class="fas fa-box-open"></i>
            Products
            <i class="fas fa-angle-down menu-arrow"></i>
          </a>
          <ul class="admin-submenu" id="productsSubmenu">
            <li>
              <a
                href="all-products.php"
                class="active"
                data-subsection="all-products.php"
                >All Products</a
              >
            </li>
            <li>
              <a href="add-product.php" data-subsection="add-product">Add New</a>
            </li>
            
          
          </ul>
        </li>
        <li>
          <a href="orders.php" data-section="orders">
            <i class="fas fa-shopping-cart"></i>
            Orders
          </a>
        </li>
        <li>
          <a href="customers.php" data-section="customers">
            <i class="fas fa-users"></i>
            Customers
          </a>
        </li>
        <li>
          <a href="sliders.php" data-section="Sliders">
            <i class="fas fa-percentage"></i>
           Sliders
          </a>
        </li>
        
       
        <li>
          <a href="reports.php" data-section="Reports">
            <i class="fas fa-chart-bar"></i>
            Reports
          </a>
        </li>
        <li>
          <a href="settings.php" data-section="settings">
            <i class="fas fa-cog"></i>
            Settings
          </a>
        </li>
      </ul>
    </aside>

    <!-- Admin Main Content - Reports Section -->
    <main class="admin-main">
      <section class="content-section" id="reports-section">
        <h1>Reports</h1>

        <!-- Sales and Order Statistics -->
        <div class="admin-card report-section">
            <div class="admin-card-header">
                <span>Overall Statistics</span>
            </div>
            <div class="admin-card-body">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Total Revenue</h3>
                            <p class="report-value">$<?php echo number_format($totalSales, 2); ?></p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Total Orders</h3>
                            <p class="report-value"><?php echo number_format($totalOrders); ?></p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Avg. Order Value</h3>
                            <p class="report-value">$<?php echo number_format($avgOrderValue, 2); ?></p>
                        </div>
                    </div>
                     <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Total Customers</h3>
                            <p class="report-value"><?php echo number_format($totalCustomers); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Selling Products Report -->
        <div class="admin-card report-section">
          <div class="admin-card-header">
            <span>Top 5 Selling Products</span>
            <!-- Could add filters like time range here -->
          </div>
          <div class="admin-card-body">
            <table class="admin-table">
              <thead>
                <tr>
                  <th>Product Name</th>
                  <th>Units Sold</th>
                  <th>Total Revenue</th>
                </tr>
              </thead>
              <tbody>
                <?php if (count($topProducts) > 0): ?>
                    <?php foreach ($topProducts as $product): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                        <td><?php echo number_format($product['units_sold']); ?></td>
                        <td>$<?php echo number_format($product['total_revenue'], 2); ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="3" class="text-center">No top selling products data available.</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Recent Orders (for a quick glance on reports page) -->
        <div class="admin-card report-section">
          <div class="admin-card-header">
            <span>Recent Orders (Last 5)</span>
          </div>
          <div class="admin-card-body">
            <table class="admin-table">
              <thead>
                <tr>
                  <th>Order ID</th>
                  <th>Customer</th>
                  <th>Date</th>
                  <th>Amount</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php if (count($recentOrders) > 0): ?>
                    <?php foreach ($recentOrders as $order): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                        <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                        <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                        <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                        <td>
                            <?php
                                $badgeClass = '';
                                switch ($order['order_status']) {
                                    case 'completed':
                                        $badgeClass = 'badge-success';
                                        break;
                                    case 'processing':
                                        $badgeClass = 'badge-primary';
                                        break;
                                    case 'pending':
                                        $badgeClass = 'badge-warning';
                                        break;
                                    case 'cancelled':
                                        $badgeClass = 'badge-danger';
                                        break;
                                    default:
                                        $badgeClass = 'badge-secondary';
                                }
                            ?>
                            <span class="badge <?php echo $badgeClass; ?>"><?php echo htmlspecialchars(ucfirst($order['order_status'])); ?></span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center">No recent orders data available.</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Customer Order Details by ID Section -->
        <div class="admin-card report-section">
            <div class="admin-card-header">
                <span>Customer/Order Details Lookup</span>
            </div>
            <div class="admin-card-body">
                <form method="GET" action="reports.php" class="form-inline">
                    <div class="form-group">
                        <label for="customer_id_input" class="form-label sr-only">Enter Customer ID:</label>
                        <input type="text" id="customer_id_input" name="customer_id" class="form-control" placeholder="Enter Customer ID (e.g., CUST-001)" value="<?php echo htmlspecialchars($customer_id_for_report); ?>">
                    </div>
                    <div class="form-group">
                         <label for="order_id_input" class="form-label sr-only">Enter Order ID:</label>
                        <input type="text" id="order_id_input" name="order_id" class="form-control" placeholder="Enter Order ID (e.g., ORD-001)" value="<?php echo htmlspecialchars($_GET['order_id'] ?? ''); ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Fetch Details</button>
                </form>

                <?php if ($fetchBy === 'customer' && empty($customerOrders) && !empty($customer_id_for_report)): ?>
                    <p class="text-center mt-4">No orders found for customer ID: <strong><?php echo htmlspecialchars($customer_id_for_report); ?></strong>.</p>
                <?php elseif ($fetchBy === 'order' && empty($singleOrderDetails) && !empty($_GET['order_id'])): ?>
                    <p class="text-center mt-4">No order found for order ID: <strong><?php echo htmlspecialchars($_GET['order_id']); ?></strong>.</p>
                <?php elseif (!empty($customerOrders)): // This now handles both customer_id and order_id fetches ?>
                    <h4 class="mt-4">
                        <?php if ($fetchBy === 'customer'): ?>
                            Orders for Customer: <?php echo htmlspecialchars($customerOrders[0]['customer_name']); ?> (ID: <?php echo htmlspecialchars($customer_id_for_report); ?>)
                        <?php elseif ($fetchBy === 'order'): ?>
                            Details for Order: <?php echo htmlspecialchars($customerOrders[0]['id']); ?> (Customer: <?php echo htmlspecialchars($customerOrders[0]['customer_name']); ?>)
                        <?php endif; ?>
                    </h4>
                    <div class="order-list mt-3">
                        <?php foreach ($customerOrders as $order): ?>
                        <div class="admin-card customer-order-detail-card mb-3">
                            <div class="admin-card-header" style="justify-content: space-between; align-items: center;">
                                <h5>Order #<?php echo htmlspecialchars($order['id']); ?></h5>
                                <div>
                                    <span class="status-badge badge-<?php echo strtolower($order['status']); ?>">
                                        <?php echo ucfirst(htmlspecialchars($order['status'])); ?>
                                    </span>
                                    <small class="text-muted ml-2"><?php echo date('d M Y', strtotime($order['time'])); ?></small>
                                </div>
                            </div>
                            <div class="admin-card-body">
                                <h6>Products:</h6>
                                <?php if (!empty($order['cart'])): ?>
                                    <?php foreach ($order['cart'] as $product): ?>
                                        <div class="product-row">
                                            <img src="<?php echo htmlspecialchars($product['img'] ?: 'https://placehold.co/50x50/cccccc/333333?text=N/A'); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" loading="lazy" onerror="this.onerror=null; this.src='https://placehold.co/50x50/cccccc/333333?text=No+Image';">
                                            <div class="product-info">
                                                <strong><?php echo htmlspecialchars($product['name']); ?></strong>
                                            </div>
                                            <div class="product-qty-price">
                                                Qty: <?php echo htmlspecialchars($product['qty']); ?> x $<?php echo number_format($product['price'], 2); ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>No products found for this order.</p>
                                <?php endif; ?>

                                <div class="order-summary">
                                    <div>Subtotal: $<?php echo number_format($order['total'] / 1.1, 2); /* Assuming 10% tax for display, adjust as per your logic */ ?></div>
                                    <div>Shipping: $0.00</div>
                                    <div>Tax: $<?php echo number_format($order['total'] * 0.1, 2); /* Assuming 10% tax for display, adjust as per your logic */ ?></div>
                                    <div><strong>Total: $<?php echo number_format($order['total'], 2); ?></strong></div>
                                </div>

                                <div class="address-info">
                                    <h6>Shipping Address:</h6>
                                    <p><strong><?php echo htmlspecialchars($order['address_parsed']['name']); ?></strong></p>
                                    <p><?php echo htmlspecialchars($order['address_parsed']['address']); ?></p>
                                    <p>Phone: <?php echo htmlspecialchars($order['address_parsed']['phone']); ?></p>
                                </div>

                                <div class="payment-info">
                                    <h6>Payment Method:</h6>
                                    <p>
                                        <?php
                                            $paymentMethod = $order['payment_method'];
                                            switch($paymentMethod) {
                                                case 'cod':
                                                    echo 'Cash on Delivery (COD)';
                                                    break;
                                                case 'upi': // Added for consistency
                                                    echo 'UPI / Wallet / Net Banking';
                                                    break;
                                                case 'card': // Added for consistency
                                                    echo 'Debit / Credit Card';
                                                    break;
                                                case 'credit_card':
                                                    echo 'Credit/Debit Card';
                                                    break;
                                                case 'paypal':
                                                    echo 'PayPal';
                                                    break;
                                                case 'bank_transfer':
                                                    echo 'Bank Transfer';
                                                    break;
                                                default:
                                                    echo 'Unknown Payment Method';
                                            }
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>


        <!-- Placeholder for Charts (e.g., Sales Trend, Customer Demographics) -->
        <div class="charts-container">
            <div class="chart-card">
                <div class="chart-header">
                    <div class="chart-title">Sales Trend Over Time</div>
                    <div class="chart-actions">
                        <select id="salesTimeRange">
                            <option>Last 7 days</option>
                            <option>Last 30 days</option>
                            <option selected>Last 90 days</option>
                            <option>Last 6 Months</option>
                            <option>Last Year</option>
                        </select>
                    </div>
                </div>
                <div class="chart-placeholder" id="salesChart">
                    Sales trend chart visualization would appear here (requires charting library like Chart.js or D3.js)
                </div>
            </div>
            <div class="chart-card">
                <div class="chart-header">
                    <div class="chart-title">Customer Acquisition</div>
                    <div class="chart-actions">
                        <select id="customerAcquisitionRange">
                            <option>Monthly</option>
                            <option selected>Quarterly</option>
                            <option>Annually</option>
                        </select>
                    </div>
                </div>
                <div class="chart-placeholder" id="customerAcquisitionChart">
                    New customer acquisition chart would appear here
                </div>
            </div>
        </div>

      </section>
    </main>

    <!-- Logout Confirmation Modal - Custom Modal Example (Replaces confirm/alert) -->
    <div class="modal" id="logoutConfirmationModal">
        <div class="modal-content" style="max-width: 500px">
            <div class="modal-header">
                <h3>Confirm Logout</h3>
                <button class="close-modal" id="closeLogoutModal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to log out?</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" id="confirmLogoutBtn">Logout</button>
                <button class="btn btn-secondary" id="cancelLogoutBtn">Cancel</button>
            </div>
        </div>
    </div>


    <script>
      document.addEventListener("DOMContentLoaded", function () {
        // Toggle sidebar on mobile
        const menuToggle = document.getElementById("menuToggle");
        const sidebar = document.querySelector(".admin-sidebar");

        if (menuToggle && sidebar) {
            menuToggle.addEventListener("click", function () {
                sidebar.classList.toggle("show");
            });
        }

        // Toggle user dropdown
        const userDropdownToggle =
          document.getElementById("userDropdownToggle");
        const userDropdown = document.querySelector(".user-dropdown");

        if (userDropdownToggle && userDropdown) {
          userDropdownToggle.addEventListener("click", function () {
            userDropdown.classList.toggle("show");
          });
        }

        // Toggle notifications dropdown
        const notificationIcon = document.querySelector(".notification-icon");
        const notificationDropdown = document.querySelector(
          ".notification-dropdown"
        );

        if (notificationIcon && notificationDropdown) {
          notificationIcon.addEventListener("click", function () {
            notificationDropdown.classList.toggle("show");
          });
        }

        // Dark mode toggle
        const darkModeToggle = document.getElementById("darkModeToggle");

        if (darkModeToggle) {
          darkModeToggle.addEventListener("click", function () {
            document.body.classList.toggle("dark-mode");

            // Toggle icon
            const icon = darkModeToggle.querySelector("i");
            if (document.body.classList.contains("dark-mode")) {
              icon.classList.remove("fa-moon");
              icon.classList.add("fa-sun");
            } else {
              icon.classList.remove("fa-sun");
              icon.classList.add("fa-moon");
            }

            // Save preference to localStorage
            localStorage.setItem(
              "darkMode",
              document.body.classList.contains("dark-mode")
            );
          });
        }

        // Check for saved dark mode preference
        if (localStorage.getItem("darkMode") === "true") {
          document.body.classList.add("dark-mode");
          if (darkModeToggle) {
            darkModeToggle.querySelector("i").classList.remove("fa-moon");
            darkModeToggle.querySelector("i").classList.add("fa-sun");
          }
        }

        // Close dropdowns when clicking outside
        document.addEventListener("click", function (e) {
          if (userDropdownToggle && userDropdown && !userDropdownToggle.contains(e.target)) {
            userDropdown.classList.remove("show");
          }

          if (notificationIcon && notificationDropdown && !notificationIcon.contains(e.target)) {
            notificationDropdown.classList.remove("show");
          }

          // Close sidebar when clicking outside on mobile
          if (window.innerWidth < 992 && sidebar && menuToggle && !sidebar.contains(e.target)) {
            if (!menuToggle.contains(e.target)) {
              sidebar.classList.remove("show");
            }
          }
        });

        // Logout functionality using custom modal
        const logoutBtn = document.getElementById("logoutBtn");
        const logoutConfirmationModal = document.getElementById("logoutConfirmationModal");
        const closeLogoutModal = document.getElementById("closeLogoutModal");
        const confirmLogoutBtn = document.getElementById("confirmLogoutBtn");
        const cancelLogoutBtn = document.getElementById("cancelLogoutBtn");

        if (logoutBtn && logoutConfirmationModal && closeLogoutModal && confirmLogoutBtn && cancelLogoutBtn) {
            logoutBtn.addEventListener("click", function (e) {
                e.preventDefault();
                logoutConfirmationModal.style.display = "flex"; // Show the modal
            });

            closeLogoutModal.addEventListener("click", function () {
                logoutConfirmationModal.style.display = "none"; // Hide the modal
            });

            cancelLogoutBtn.addEventListener("click", function () {
                logoutConfirmationModal.style.display = "none"; // Hide the modal
            });

            confirmLogoutBtn.addEventListener("click", function () {
                // In a real app, you would send a logout request to the server
                // Simulate logout success
                console.log("You have been logged out successfully.");
                // Redirect to login page
                window.location.href = "/login"; // This will navigate away from the page
            });
        }

        // No need for content section switching JS here as this is a standalone report page
        // If this were part of a single-page admin panel with JS navigation, this would be handled differently.
        // For this file, we assume it's loaded as reports.php.
      });
    </script>
  </body>
</html>
