<?php
require_once 'config.php';
session_start();

<<<<<<< HEAD

=======
// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit;
}
>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a

$order = null;
$order_items = [];

if (isset($_GET['id'])) {
    $order_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Fetch order details
    $order_query = "SELECT * FROM orders WHERE id = '$order_id'";
    $order_result = mysqli_query($conn, $order_query);

    if ($order_result && mysqli_num_rows($order_result) > 0) {
        $order = mysqli_fetch_assoc($order_result);

        // Fetch order items
        $items_query = "SELECT oi.*, p.image_path
                        FROM order_items oi
                        LEFT JOIN products p ON oi.product_id = p.id
                        WHERE oi.order_id = '$order_id'";
        $items_result = mysqli_query($conn, $items_query);

        if ($items_result && mysqli_num_rows($items_result) > 0) {
            while ($item = mysqli_fetch_assoc($items_result)) {
                $order_items[] = $item;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - Admin</title>
    <link rel="icon" type="image/x-icon" href="/icons/favicon.ico">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .order-detail-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            padding: 25px;
            margin-bottom: 20px;
        }
        .order-detail-card h3 {
            color: #333;
            margin-top: 0;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .order-detail-card p {
            margin-bottom: 8px;
            color: #555;
        }
        .order-detail-card p strong {
            color: #222;
        }
        .order-items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .order-items-table th, .order-items-table td {
            border: 1px solid #eee;
            padding: 10px;
            text-align: left;
        }
        .order-items-table th {
            background-color: #f8f8f8;
            font-weight: 600;
        }
        .order-items-table .product-image {
            width: 50px;
            height: 50px;
            object-fit: contain;
            margin-right: 10px;
            border-radius: 5px;
            vertical-align: middle;
        }
        .total-summary {
            text-align: right;
            margin-top: 20px;
            font-size: 1.1em;
            font-weight: 600;
        }
        .total-summary span {
            font-size: 1.2em;
            color: #0a45a6;
        }
        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #0a45a6;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .back-button:hover {
            background-color: #083c92;
        }
    </style>
</head>
<body class="admin-panel">
    <header class="admin-header">
        <div class="admin-brand">
            <i class="fas fa-gem"></i>
            <span>Brand Bazaar Admin</span>
        </div>
        <div class="admin-header-controls">
            <div class="search-container">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search..." id="globalSearch">
            </div>
            <div class="notification-icon">
                <i class="fas fa-bell"></i>
                <span class="notification-badge">5</span>
            </div>
            <button class="dark-mode-toggle" id="darkModeToggle">
                <i class="fas fa-moon"></i>
            </button>
            <div class="admin-user">
                <span>Admin User</span>
                <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Admin">
            </div>
        </div>
    </header>

    <aside class="admin-sidebar">
        <button class="menu-toggle" id="menuToggle">
            <i class="fas fa-bars"></i>
        </button>
        <ul class="admin-menu">
            <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="all-products.php"><i class="fas fa-box-open"></i> Products</a></li>
            <li><a href="orders.php" class="active"><i class="fas fa-shopping-cart"></i> Orders</a></li>
            <li><a href="customers.php"><i class="fas fa-users"></i> Customers</a></li>
            <li><a href="sliders.php"><i class="fas fa-percentage"></i> Sliders</a></li>
            <li><a href="reports.php"><i class="fas fa-chart-bar"></i> Reports</a></li>
            <li><a href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
        </ul>
    </aside>

    <main class="admin-main">
        <section class="content-section">
            <h1>Order Details</h1>

            <?php if ($order): ?>
                <div class="order-detail-card">
                    <h3>Order Information</h3>
                    <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order['id']); ?></p>
                    <p><strong>Order Date:</strong> <?php echo htmlspecialchars(date('Y-m-d H:i:s', strtotime($order['order_date']))); ?></p>
                    <p><strong>Status:</strong> <span class="badge badge-<?php
                        switch ($order['status']) {
                            case 'pending': echo 'warning'; break;
                            case 'processing': echo 'info'; break;
                            case 'completed': echo 'success'; break;
                            case 'cancelled': echo 'danger'; break;
                            default: echo 'secondary'; break;
                        }
                    ?>"><?php echo ucfirst(htmlspecialchars($order['status'])); ?></span></p>
                    <p><strong>Total Amount:</strong> ₹<?php echo htmlspecialchars(number_format($order['total_amount'], 2)); ?></p>
                </div>

                <div class="order-detail-card">
                    <h3>Customer Information</h3>
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($order['customer_name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($order['customer_email']); ?></p>
                    <p><strong>Phone:</strong> <?php echo htmlspecialchars($order['customer_phone']); ?></p>
                    <p><strong>Shipping Address:</strong> <?php echo nl2br(htmlspecialchars($order['shipping_address'])); ?></p>
                </div>

                <div class="order-detail-card">
                    <h3>Order Items</h3>
                    <?php if (!empty($order_items)): ?>
                        <table class="order-items-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($order_items as $item): ?>
                                    <tr>
                                        <td>
                                            <?php if ($item['image_path']): ?>
                                                <img src="../<?php echo htmlspecialchars($item['image_path']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>" class="product-image">
                                            <?php endif; ?>
                                            <?php echo htmlspecialchars($item['product_name']); ?>
                                        </td>
                                        <td>₹<?php echo htmlspecialchars(number_format($item['price'], 2)); ?></td>
                                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                        <td>₹<?php echo htmlspecialchars(number_format($item['price'] * $item['quantity'], 2)); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div class="total-summary">
                            Subtotal: ₹<?php echo htmlspecialchars(number_format($order['subtotal'], 2)); ?><br>
                            Shipping: ₹<?php echo htmlspecialchars(number_format($order['shipping_cost'], 2)); ?><br>
                            Tax: ₹<?php echo htmlspecialchars(number_format($order['tax_amount'], 2)); ?><br>
                            Discount: ₹<?php echo htmlspecialchars(number_format($order['discount_amount'], 2)); ?><br>
                            Grand Total: <span>₹<?php echo htmlspecialchars(number_format($order['total_amount'], 2)); ?></span>
                        </div>
                    <?php else: ?>
                        <p>No items found for this order.</p>
                    <?php endif; ?>
                </div>
                <a href="orders.php" class="back-button"><i class="fas fa-arrow-left"></i> Back to Orders</a>
            <?php else: ?>
                <p>Order not found or invalid ID.</p>
                <a href="orders.php" class="back-button"><i class="fas fa-arrow-left"></i> Back to Orders</a>
            <?php endif; ?>
        </section>
    </main>
    <script src="js/admin.js"></script>
</body>
</html>