<?php
// customers.php

// In a real application, you would include your database connection file here.
// For demonstration, we'll simulate data.
// include 'config.php'; // Assuming you have a database configuration file

// --- Simulated Database Connection and Data Fetching ---
function get_all_customers_from_db() {
    // --- START: Database Simulation ---
    // This array mimics data you might fetch from a database for customer management.
    $customers = [
        [
            'id' => 'CUST-001',
            'name' => 'Alice Wonderland',
            'email' => 'alice@example.com',
            'phone' => '111-222-3333',
            'address' => '123 Rabbit Hole, Fantasyland',
            'registered_date' => '2024-01-15 10:00:00',
            'total_orders' => 5,
            'total_spent' => 750.50,
            'status' => 'active'
        ],
        [
            'id' => 'CUST-002',
            'name' => 'Bob The Builder',
            'email' => 'bob@example.com',
            'phone' => '444-555-6666',
            'address' => '456 Construction Site, Builderton',
            'registered_date' => '2024-02-20 11:30:00',
            'total_orders' => 2,
            'total_spent' => 150.00,
            'status' => 'active'
        ],
        [
            'id' => 'CUST-003',
            'name' => 'Charlie Chaplin',
            'email' => 'charlie@example.com',
            'phone' => '777-888-9999',
            'address' => '789 Silent Movie St, Old Hollywood',
            'registered_date' => '2024-03-01 09:00:00',
            'total_orders' => 1,
            'total_spent' => 697.99,
            'status' => 'active'
        ],
        [
            'id' => 'CUST-004',
            'name' => 'Diana Prince',
            'email' => 'diana@example.com',
            'phone' => '000-111-2222',
            'address' => '101 Themyscira Blvd, Justice City',
            'registered_date' => '2024-04-05 14:00:00',
            'total_orders' => 3,
            'total_spent' => 899.99,
            'status' => 'active'
        ],
        [
            'id' => 'CUST-005',
            'name' => 'Eve Green',
            'email' => 'eve@example.com',
            'phone' => '999-888-7777',
            'address' => '500 Forest Lane, Woodland',
            'registered_date' => '2024-05-10 16:00:00',
            'total_orders' => 0,
            'total_spent' => 0.00,
            'status' => 'inactive'
        ],
    ];
    // --- END: Database Simulation ---

    // In a real database scenario, you would perform SQL queries here:
    /*
    global $conn; // Assuming $conn is your mysqli connection object from config.php
    $sql = "SELECT id, name, email, phone, address, registered_date, total_orders, total_spent, status FROM customers ORDER BY registered_date DESC";
    $result = mysqli_query($conn, $sql);
    $customers = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $customers[] = $row;
        }
        mysqli_free_result($result);
    } else {
        error_log("Error fetching customers: " . mysqli_error($conn));
    }
    */

    return $customers;
}

$allCustomers = get_all_customers_from_db();

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Brand Bazaar - Customer Management</title>
    <link rel="icon" type="image/x-icon" href="/icons/favicon.ico" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />
    <!-- Link to the admin.css for styling the admin panel -->
    <link rel="stylesheet" href="../admin/css/admin.css" />
    <style>
        /* Specific styles for the customers page if needed */
        .customer-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .customer-stat-card {
            background: var(--admin-bg-card);
            padding: 20px;
            border-radius: 8px;
            box-shadow: var(--admin-shadow);
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .customer-stat-card .icon {
            font-size: 2.5rem;
            color: var(--admin-primary);
        }
        .customer-stat-card .info h3 {
            margin: 0 0 5px 0;
            font-size: 1.8rem;
            color: var(--admin-text-dark);
        }
        .customer-stat-card .info p {
            margin: 0;
            color: #777;
            font-size: 0.9rem;
        }
        .customer-status-badge {
            padding: 4px 10px;
            border-radius: 5px;
            font-size: 0.85em;
            font-weight: 600;
            color: white;
            text-transform: capitalize;
        }
        .customer-status-active { background-color: #28a745; } /* Green */
        .customer-status-inactive { background-color: #6c757d; } /* Gray */
        .customer-status-suspended { background-color: #dc3545; } /* Red */

        /* Override admin.css filter styling if necessary */
        .customer-filters {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
        }
    </style>
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
      <!-- Customers Section -->
      <section class="content-section" id="customers-section">
        <h1>Customer Management</h1>

        <div class="customer-stats-grid">
            <div class="customer-stat-card">
                <div class="icon"><i class="fas fa-users"></i></div>
                <div class="info">
                    <h3><?php echo count($allCustomers); ?></h3>
                    <p>Total Customers</p>
                </div>
            </div>
            <div class="customer-stat-card">
                <div class="icon"><i class="fas fa-user-check"></i></div>
                <div class="info">
                    <h3><?php echo count(array_filter($allCustomers, fn($c) => $c['status'] === 'active')); ?></h3>
                    <p>Active Customers</p>
                </div>
            </div>
            <div class="customer-stat-card">
                <div class="icon"><i class="fas fa-shopping-basket"></i></div>
                <div class="info">
                    <h3><?php echo array_sum(array_column($allCustomers, 'total_orders')); ?></h3>
                    <p>Total Orders Placed</p>
                </div>
            </div>
            <div class="customer-stat-card">
                <div class="icon"><i class="fas fa-money-bill-wave"></i></div>
                <div class="info">
                    <h3>$<?php echo number_format(array_sum(array_column($allCustomers, 'total_spent')), 2); ?></h3>
                    <p>Total Customer Spend</p>
                </div>
            </div>
        </div>

        <div class="admin-card">
          <div class="admin-card-header">
            <span>All Customers</span>
            <div class="customer-actions">
                <button class="btn btn-primary"><i class="fas fa-user-plus"></i> Add New Customer</button>
            </div>
          </div>
          <div class="admin-card-body">
             <div class="form-group">
                  <input
                    type="text"
                    class="form-control"
                    id="customerSearch"
                    placeholder="Search customers by name, email, or phone..."
                  />
                </div>
              <div class="customer-filters">
              <select
                id="customerStatusFilter"
                class="form-control"
                style="width: auto; display: inline-block"
              >
                <option value="all">All Statuses</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="suspended">Suspended</option>
              </select>
            </div>
            <table class="admin-table" id="customerTable">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Address</th>
                  <th>Registered Date</th>
                  <th>Total Orders</th>
                  <th>Total Spent</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($allCustomers)): ?>
                    <?php foreach ($allCustomers as $customer): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($customer['id']); ?></td>
                            <td><?php echo htmlspecialchars($customer['name']); ?></td>
                            <td><?php echo htmlspecialchars($customer['email']); ?></td>
                            <td><?php echo htmlspecialchars($customer['phone']); ?></td>
                            <td><?php echo htmlspecialchars($customer['address']); ?></td>
                            <td><?php echo htmlspecialchars(date('M d, Y', strtotime($customer['registered_date']))); ?></td>
                            <td><?php echo htmlspecialchars($customer['total_orders']); ?></td>
                            <td>$<?php echo number_format($customer['total_spent'], 2); ?></td>
                            <td><span class="customer-status-badge customer-status-<?php echo htmlspecialchars($customer['status']); ?>"><?php echo htmlspecialchars($customer['status']); ?></span></td>
                            <td>
                                <button class="btn btn-primary btn-sm" onclick="showCustomModal('Edit Customer', 'Edit customer <?php echo htmlspecialchars($customer['name']); ?> functionality goes here.', false)"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-danger btn-sm" onclick="showCustomModal('Delete Customer', 'Are you sure you want to delete customer <?php echo htmlspecialchars($customer['name']); ?>?', true, () => console.log('Customer deleted'), () => console.log('Delete cancelled'))"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10" style="text-align: center;">No customer records found.</td>
                    </tr>
                <?php endif; ?>
              </tbody>
            </table>
             <div class="pagination">
              <button disabled><i class="fas fa-chevron-left"></i></button>
              <button class="active">1</button>
              <!-- Add more pages dynamically if needed -->
              <button><i class="fas fa-chevron-right"></i></button>
            </div>
          </div>
        </div>
      </section>
    </main>

    <!-- Generic Message Modal (replaces alert/confirm for logout and other messages) -->
    <div class="modal" id="messageModal">
        <div class="modal-content" style="max-width: 400px;">
            <div class="modal-header">
                <h3 id="messageModalTitle">Message</h3>
                <button class="close-modal" id="closeMessageModal">&times;</button>
            </div>
            <div class="modal-body">
                <p id="messageModalText"></p>
            </div>
            <div class="modal-footer" id="messageModalFooter">
                <button class="btn btn-primary" id="messageModalConfirmBtn" style="display: none;">OK</button>
                <button class="btn btn-secondary" id="messageModalCancelBtn" style="display: none;">Cancel</button>
            </div>
        </div>
    </div>

    <script>
      // Function to show custom message modal (copied for independent file)
      function showCustomModal(title, message, isConfirm = false, onConfirm = null, onCancel = null) {
          const modal = document.getElementById('messageModal');
          const modalTitle = document.getElementById('messageModalTitle');
          const modalText = document.getElementById('messageModalText');
          const confirmBtn = document.getElementById('messageModalConfirmBtn');
          const cancelBtn = document.getElementById('messageModalCancelBtn');
          const closeBtn = document.getElementById('closeMessageModal');

          modalTitle.textContent = title;
          modalText.textContent = message;

          confirmBtn.style.display = isConfirm ? 'inline-block' : 'none';
          cancelBtn.style.display = isConfirm ? 'inline-block' : 'none';

          // Clear previous listeners
          confirmBtn.onclick = null;
          cancelBtn.onclick = null;
          closeBtn.onclick = null;

          if (isConfirm) {
              confirmBtn.onclick = () => {
                  modal.style.display = 'none';
                  if (onConfirm) onConfirm();
              };
              cancelBtn.onclick = () => {
                  modal.style.display = 'none';
                  if (onCancel) onCancel();
              };
          } else { // Alert-like behavior
              confirmBtn.style.display = 'inline-block';
              confirmBtn.textContent = 'OK';
              confirmBtn.onclick = () => {
                  modal.style.display = 'none';
                  if (onConfirm) onConfirm(); // Use onConfirm for the 'OK' action
              };
          }
          closeBtn.onclick = () => {
              modal.style.display = 'none';
              if (onCancel && isConfirm) onCancel(); // Call onCancel if it's a confirm dialog and closed
          };

          modal.style.display = 'flex'; // Show the modal
      }

      document.addEventListener("DOMContentLoaded", function () {
        // Toggle sidebar on mobile
        const menuToggle = document.getElementById("menuToggle");
        const sidebar = document.querySelector(".admin-sidebar");

        menuToggle.addEventListener("click", function () {
          sidebar.classList.toggle("show");
        });

        // Toggle submenus (assuming these IDs exist in your admin.php template)
        const productsMenu = document.getElementById("productsMenu");
        const productsSubmenu = document.getElementById("productsSubmenu");

        if (productsMenu) {
            productsMenu.addEventListener("click", function (e) {
                e.preventDefault();
                productsSubmenu.classList.toggle("show");
                this.querySelector(".menu-arrow").classList.toggle("rotated");
            });
        }

        // Toggle user dropdown
        const userDropdownToggle = document.getElementById("userDropdownToggle");
        const userDropdown = document.querySelector(".user-dropdown");

        if (userDropdownToggle) {
            userDropdownToggle.addEventListener("click", function () {
                userDropdown.classList.toggle("show");
            });
        }

        // Toggle notifications dropdown
        const notificationIcon = document.querySelector(".notification-icon");
        const notificationDropdown = document.querySelector(".notification-dropdown");

        if (notificationIcon) {
            notificationIcon.addEventListener("click", function () {
                notificationDropdown.classList.toggle("show");
            });
        }

        // Dark mode toggle
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
        }

        // Check for saved dark mode preference
        if (localStorage.getItem("darkMode") === "true") {
          document.body.classList.add("dark-mode");
          if (darkModeToggle) {
            darkModeToggle.querySelector('i').classList.remove("fa-moon");
            darkModeToggle.querySelector('i').classList.add("fa-sun");
          }
        }

        // Close dropdowns when clicking outside
        document.addEventListener("click", function (e) {
          if (userDropdownToggle && !userDropdownToggle.contains(e.target)) {
            userDropdown.classList.remove("show");
          }
          if (notificationIcon && !notificationIcon.contains(e.target)) {
            notificationDropdown.classList.remove("show");
          }
          // Close sidebar on mobile if clicked outside
          if (window.innerWidth < 992 && sidebar && !sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
            sidebar.classList.remove("show");
          }
        });

        // Add active state to menu items and handle section display
        const menuLinks = document.querySelectorAll(".admin-menu a[data-section], .admin-submenu a[data-subsection]");
        const contentSections = document.querySelectorAll(".content-section");

        function showSection(sectionId) {
            contentSections.forEach((section) => {
                section.style.display = "none";
            });
            const activeSection = document.getElementById(sectionId); // Use ID directly
            if (activeSection) {
                activeSection.style.display = "block";
            }
        }

        menuLinks.forEach((link) => {
          link.addEventListener("click", function (e) {
            // Only prevent default if it's a data-section or data-subsection link
            if (this.hasAttribute('data-section') || this.hasAttribute('data-subsection')) {
                 //e.preventDefault(); // Commented out to allow direct page navigation if needed
            }

            // Remove active class from all main menu items
            document.querySelectorAll(".admin-menu li a").forEach((i) => {
                if (!i.querySelector(".menu-arrow")) {
                    i.classList.remove("active");
                }
            });
            // Remove active class from all submenu items
            document.querySelectorAll(".admin-submenu li a").forEach((i) => i.classList.remove("active"));

            // Add active class to clicked item
            this.classList.add("active");

            // Handle parent active state for submenus
            let parentMenu = this.closest('li');
            while(parentMenu && !parentMenu.classList.contains('admin-menu')) {
                if (parentMenu.querySelector('a[data-section]')) {
                    parentMenu.querySelector('a[data-section]').classList.add('active');
                }
                parentMenu = parentMenu.parentElement;
            }

            const section = this.getAttribute("data-section") || this.getAttribute("data-subsection");
            if (section) {
                // For customers.php, we just need to show the 'customers-section'
                showSection("customers-section");
            }
          });
        });

        // Initially show the customers section if this is customers.php
        showSection("customers-section");


        // Logout functionality (Updated to use custom modal)
        const logoutBtn = document.getElementById("logoutBtn");
        if (logoutBtn) {
          logoutBtn.addEventListener("click", function (e) {
            e.preventDefault();
            showCustomModal(
                "Confirm Logout",
                "Are you sure you want to logout? You will be redirected to the login page.",
                true, // isConfirm
                () => { // onConfirm
                    // In a real app, you would send a logout request to the server
                    showCustomModal("Logged Out", "You have been logged out successfully.", false, () => {
                         window.location.href = "/login"; // Redirect to login page
                    });
                },
                () => { // onCancel
                    console.log("Logout cancelled.");
                }
            );
          });
        }


        // --- Customer Specific Filters and Search ---
        const customerStatusFilter = document.getElementById("customerStatusFilter");
        const customerSearch = document.getElementById("customerSearch");
        const customerTable = document.getElementById("customerTable");

        function applyCustomerFilters() {
            const statusFilter = customerStatusFilter ? customerStatusFilter.value.toLowerCase() : 'all';
            const searchTerm = customerSearch ? customerSearch.value.toLowerCase() : '';
            const rows = customerTable ? customerTable.querySelectorAll("tbody tr") : [];

            rows.forEach((row) => {
                const customerId = row.cells[0].textContent.toLowerCase();
                const customerName = row.cells[1].textContent.toLowerCase();
                const customerEmail = row.cells[2].textContent.toLowerCase();
                const customerPhone = row.cells[3].textContent.toLowerCase();
                const status = row.cells[8].querySelector('.customer-status-badge').textContent.toLowerCase(); // Assuming status is in the 9th cell (index 8)

                const statusMatch = statusFilter === "all" || status.includes(statusFilter);
                const searchMatch = customerId.includes(searchTerm) ||
                                    customerName.includes(searchTerm) ||
                                    customerEmail.includes(searchTerm) ||
                                    customerPhone.includes(searchTerm);

                row.style.display = statusMatch && searchMatch ? "" : "none";
            });
        }

        if (customerStatusFilter) {
            customerStatusFilter.addEventListener("change", applyCustomerFilters);
        }
        if (customerSearch) {
            customerSearch.addEventListener("input", applyCustomerFilters);
        }

        // Initial application of filters
        applyCustomerFilters();
      });
    </script>
  </body>
</html>
