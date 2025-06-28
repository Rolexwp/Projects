<?php
require_once 'config.php';

// Function to get dashboard stats
function getDashboardStats($conn) {
    $stats = array();

    // Total Orders
    $result = mysqli_query($conn, "SELECT COUNT(*) as total_orders FROM orders");
    $row = mysqli_fetch_assoc($result);
    $stats['total_orders'] = $row['total_orders'];

    // Total Revenue
    $result = mysqli_query($conn, "SELECT SUM(total_amount) as total_revenue FROM orders WHERE status = 'completed'");
    $row = mysqli_fetch_assoc($result);
    $stats['total_revenue'] = $row['total_revenue'] ? number_format($row['total_revenue'], 2) : '0.00';

    // Total Customers
    $result = mysqli_query($conn, "SELECT COUNT(*) as total_customers FROM customers");
    $row = mysqli_fetch_assoc($result);
    $stats['total_customers'] = $row['total_customers'];

    // Total Products
    $result = mysqli_query($conn, "SELECT COUNT(*) as total_products FROM products");
    $row = mysqli_fetch_assoc($result);
    $stats['total_products'] = $row['total_products'];

    // Out of stock products
    $result = mysqli_query($conn, "SELECT COUNT(*) as out_of_stock FROM products WHERE stock_quantity <= 0");
    $row = mysqli_fetch_assoc($result);
    $stats['out_of_stock'] = $row['out_of_stock'];

    return $stats;
}

// Function to get recent orders
function getRecentOrders($conn, $limit = 5) {
    $orders = array();
    $query = "SELECT o.id, CONCAT(c.first_name, ' ', c.last_name) as customer, o.order_date, o.total_amount, o.status
              FROM app_orders o
              JOIN app_customers c ON o.customer_id = c.id
              ORDER BY o.order_date DESC LIMIT ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $limit);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        $orders[] = $row;
    }
    return $orders;
}

$stats = getDashboardStats($conn);
$recentOrders = getRecentOrders($conn, 5);

// Close database connection
// mysqli_close($conn); // Close connection after all data is fetched. Will move to the end of the file.
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Brand Bazaar - Dashboard</title>
    <link rel="icon" type="image/x-icon" href="/icons/favicon.ico" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />
    <link rel="stylesheet" href="../admin/css/admin.css" />
  </head>
  <body class="admin-panel">
    <!-- Admin Header -->
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

   
    <!-- Admin Sidebar -->
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

    <!-- Admin Main Content -->
    <main class="admin-main">
      <!-- Dashboard Section - Content from original dashboard.php -->
      <section class="content-section" id="dashboard-section">
        <h1>Dashboard</h1>

        <!-- Stats Cards -->
        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-icon">
              <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-info">
              <h3 id="totalOrders"><?php echo htmlspecialchars($stats['total_orders']); ?></h3>
              <p>Total Orders</p>
              <small class="text-success">+12% from last month</small>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-icon">
              <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-info">
              <h3 id="totalRevenue">$<?php echo htmlspecialchars($stats['total_revenue']); ?></h3>
              <p>Total Revenue</p>
              <small class="text-success">+8% from last month</small>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-icon">
              <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
              <h3 id="totalCustomers"><?php echo htmlspecialchars($stats['total_customers']); ?></h3>
              <p>Total Customers</p>
              <small class="text-success">+5.2% from last month</small>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-icon">
              <i class="fas fa-box-open"></i>
            </div>
            <div class="stat-info">
              <h3 id="totalProducts"><?php echo htmlspecialchars($stats['total_products']); ?></h3>
              <p>Total Products</p>
              <small class="text-danger"><?php echo htmlspecialchars($stats['out_of_stock']); ?> out of stock</small>
            </div>
          </div>
        </div>

        <!-- Charts (placeholders as charts are JS-driven) -->
        <div class="charts-container">
          <div class="chart-card">
            <div class="chart-header">
              <div class="chart-title">Revenue Overview</div>
              <div class="chart-actions">
                <select id="revenueTimeRange">
                  <option>Last 7 days</option>
                  <option selected>Last 30 days</option>
                  <option>Last 90 days</option>
                </select>
              </div>
            </div>
            <div class="chart-placeholder" id="revenueChart">
              Revenue chart visualization would appear here
            </div>
          </div>

          <div class="chart-card">
            <div class="chart-header">
              <div class="chart-title">Top Categories</div>
              <div class="chart-actions">
                <select id="categorySortBy">
                  <option>By Revenue</option>
                  <option selected>By Units Sold</option>
                </select>
              </div>
            </div>
            <div class="chart-placeholder" id="categoryChart">
              Category performance chart would appear here
            </div>
          </div>
        </div>

        <!-- Recent Orders -->
        <div class="admin-card">
          <div class="admin-card-header">
            <span>Recent Orders</span>
            <a href="orders.php" class="btn btn-sm btn-primary">View All</a>
          </div>
          <div class="admin-card-body">
            <table class="admin-table" id="recentOrdersTable">
              <thead>
                <tr>
                  <th>Order ID</th>
                  <th>Customer</th>
                  <th>Date</th>
                  <th>Amount</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($recentOrders as $order): ?>
                <?php
                  $order_date = new DateTime($order['order_date']);
                  $formatted_date = $order_date->format('M j, Y');

                  $status_class = 'badge-primary';
                  if ($order['status'] === 'completed') $status_class = 'badge-success';
                  elseif ($order['status'] === 'cancelled') $status_class = 'badge-danger';
                  elseif ($order['status'] === 'pending') $status_class = 'badge-warning';

                  $status_text = ucfirst($order['status']);
                ?>
                <tr>
                  <td>#ORD-<?php echo str_pad($order['id'], 4, '0', STR_PAD_LEFT); ?></td>
                  <td><?php echo htmlspecialchars($order['customer']); ?></td>
                  <td><?php echo $formatted_date; ?></td>
                  <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                  <td><span class="badge <?php echo $status_class; ?>"><?php echo $status_text; ?></span></td>
                  <td>
                    <a href="orders.php?order_id=<?php echo $order['id']; ?>" class="btn btn-sm btn-primary">
                      <i class="fas fa-eye"></i> View
                    </a>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </section>
    </main>

    <!-- Modals (can be reused across pages) -->
    <!-- Delete Confirmation Modal -->
    <div class="modal" id="deleteConfirmationModal">
      <div class="modal-content" style="max-width: 500px">
        <div class="modal-header">
          <h3>Confirm Deletion</h3>
          <button class="close-modal" id="closeDeleteModal">&times;</button>
        </div>
        <div class="modal-body">
          <p id="deleteConfirmationMessage">
            Are you sure you want to delete this item?
          </p>
        </div>
        <div class="modal-footer">
          <button class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
          <button class="btn btn-secondary" id="cancelDeleteBtn">Cancel</button>
        </div>
      </div>
    </div>

    <!-- Logout Confirmation Modal -->
    <div class="modal" id="logoutConfirmationModal">
      <div class="modal-content" style="max-width: 500px">
        <div class="modal-header">
          <h3>Confirm Logout</h3>
          <button class="close-modal" id="closeLogoutModal">&times;</button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to logout?</p>
        </div>
        <div class="modal-footer">
          <button class="btn btn-danger" id="confirmLogoutBtn">Logout</button>
          <button class="btn btn-secondary" id="cancelLogoutBtn">Cancel</button>
        </div>
      </div>
    </div>

    <script>
      document.addEventListener("DOMContentLoaded", function () {
        // --- Sidebar Toggle ---
        const menuToggle = document.getElementById("menuToggle");
        const adminSidebar = document.querySelector(".admin-sidebar");
        const adminMain = document.querySelector(".admin-main");

        if (menuToggle) {
          menuToggle.addEventListener("click", function () {
            adminSidebar.classList.toggle("collapsed");
            adminMain.classList.toggle("shifted");
          });
        }

        // --- Submenu Toggle (for Products) ---
        const productsMenu = document.getElementById("productsMenu");
        const productsSubmenu = document.getElementById("productsSubmenu");
        const productsMenuArrow = productsMenu ? productsMenu.querySelector(".menu-arrow") : null;

        if (productsMenu && productsSubmenu) {
          productsMenu.addEventListener("click", function (e) {
            e.preventDefault(); // Prevent default link behavior
            productsSubmenu.classList.toggle("show");
            if (productsMenuArrow) {
                productsMenuArrow.classList.toggle("rotated");
            }
          });
        }

        // --- Active Menu Item on Sidebar ---
        const currentPath = window.location.pathname.split('/').pop();
        const menuLinks = document.querySelectorAll(".admin-menu a, .admin-submenu a");
        menuLinks.forEach(link => {
            // Remove 'active' class from all links first
            link.classList.remove("active");

            // Add 'active' to the current page's link
            if (link.getAttribute("href") === currentPath) {
                link.classList.add("active");
                // If it's a submenu item, also activate its parent menu
                let parentSubmenu = link.closest(".admin-submenu");
                if (parentSubmenu) {
                    parentSubmenu.classList.add("show"); // Ensure submenu is open
                    let parentMenuLink = parentSubmenu.previousElementSibling;
                    if (parentMenuLink && parentMenuLink.tagName === 'A' && parentMenuLink.id === 'productsMenu') {
                         parentMenuLink.classList.add("active");
                         parentMenuLink.querySelector(".menu-arrow").classList.add("rotated");
                    }
                }
            }
        });


        // --- User Dropdown Toggle ---
        const userDropdownToggle = document.getElementById("userDropdownToggle");
        const userDropdown = document.querySelector(".user-dropdown");

        if (userDropdownToggle && userDropdown) {
          userDropdownToggle.addEventListener("click", function (event) {
            event.stopPropagation(); // Prevent document click from immediately closing
            userDropdown.classList.toggle("show");
          });
        }

        // --- Notifications Dropdown Toggle ---
        const notificationIcon = document.querySelector(".notification-icon");
        const notificationDropdown = document.querySelector(".notification-dropdown");

        if (notificationIcon && notificationDropdown) {
          notificationIcon.addEventListener("click", function (event) {
            event.stopPropagation(); // Prevent document click from immediately closing
            notificationDropdown.classList.toggle("show");
          });
        }

        // --- Dark Mode Toggle ---
        const darkModeToggle = document.getElementById("darkModeToggle");

        if (darkModeToggle) {
          darkModeToggle.addEventListener("click", function () {
            document.body.classList.toggle("dark-mode");
            const icon = darkModeToggle.querySelector("i");
            if (document.body.classList.contains("dark-mode")) {
              icon.classList.remove("fa-moon");
              icon.classList.add("fa-sun");
            } else {
              icon.classList.remove("fa-sun");
              icon.classList.add("fa-moon");
            }
            localStorage.setItem("darkMode", document.body.classList.contains("dark-mode"));
          });

          // Check for saved dark mode preference on load
          if (localStorage.getItem("darkMode") === "true") {
            document.body.classList.add("dark-mode");
            darkModeToggle.querySelector("i").classList.remove("fa-moon");
            darkModeToggle.querySelector("i").classList.add("fa-sun");
          }
        }

        // --- Close dropdowns and sidebar when clicking outside ---
        document.addEventListener("click", function (e) {
          // Close user dropdown
          if (userDropdown && !userDropdownToggle.contains(e.target) && !userDropdown.contains(e.target)) {
            userDropdown.classList.remove("show");
          }
          // Close notification dropdown
          if (notificationDropdown && !notificationIcon.contains(e.target) && !notificationDropdown.contains(e.target)) {
            notificationDropdown.classList.remove("show");
          }
          // Close sidebar on mobile if clicked outside
          if (window.innerWidth < 992 && adminSidebar && !adminSidebar.contains(e.target) && !menuToggle.contains(e.target)) {
            adminSidebar.classList.remove("collapsed");
            adminMain.classList.remove("shifted");
          }
        });

        // --- Logout functionality with custom modal ---
        const logoutBtn = document.getElementById("logoutBtn");
        const logoutConfirmationModal = document.getElementById("logoutConfirmationModal");
        const confirmLogoutBtn = document.getElementById("confirmLogoutBtn");
        const cancelLogoutBtn = document.getElementById("cancelLogoutBtn");
        const closeLogoutModal = document.getElementById("closeLogoutModal");

        if (logoutBtn && logoutConfirmationModal) {
            logoutBtn.addEventListener("click", function (e) {
                e.preventDefault();
                logoutConfirmationModal.style.display = "flex"; // Show the modal
            });
            confirmLogoutBtn.addEventListener("click", function () {
                // In a real app, you would send a logout request to the server
                console.log("You have been logged out successfully.");
                logoutConfirmationModal.style.display = "none";
                window.location.href = "/login"; // Redirect to login page
            });
            cancelLogoutBtn.addEventListener("click", function () {
                logoutConfirmationModal.style.display = "none"; // Hide the modal
            });
            closeLogoutModal.addEventListener("click", function () {
                logoutConfirmationModal.style.display = "none"; // Hide the modal
            });
            // Close modal if clicking outside
            window.addEventListener("click", function(event) {
                if (event.target == logoutConfirmationModal) {
                    logoutConfirmationModal.style.display = "none";
                }
            });
        }
      });
    </script>
  </body>
</html>
<?php
// Close the database connection if it was opened
if (isset($conn)) {
    mysqli_close($conn);
}
?>
