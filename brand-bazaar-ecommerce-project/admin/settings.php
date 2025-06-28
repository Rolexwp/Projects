<?php
// settings.php

// In a real application, you would include your database connection file here.
// For demonstration, we'll simulate data persistence using a simple array
// which will be updated on POST. For real persistence, integrate a database.

// You might fetch current settings from a database here
function get_site_settings() {
    // For demonstration, we'll use a static array.
    // In a real application, you would fetch these from a database.
    $settings = [
        'general' => [
            'site_name' => 'Brand Bazaar',
            'site_tagline' => 'Your one-stop shop for everything digital!',
            'contact_email' => 'support@brandbazaar.com',
            'admin_email' => 'admin@brandbazaar.com',
            'items_per_page' => 10,
            'currency_symbol' => '$',
        ],
        'security' => [
            'two_factor_auth_enabled' => true,
            'password_strength_policy' => 'strong', // weak, medium, strong
            'admin_login_attempts_limit' => 5,
        ],
        'notifications' => [
            'new_order_email' => true,
            'low_stock_alert' => true,
            'new_customer_email' => false,
            'product_review_email' => true,
        ],
        'appearance' => [
            'theme' => 'light', // light, dark
            'logo_url' => '/images/logo.png', // Placeholder or actual URL
            'favicon_url' => '/icons/favicon.ico',
        ],
    ];

    // Simple simulation for retaining data across requests if it was just posted.
    // This is NOT true persistence (e.g., if page is reloaded without a POST).
    // A database or file storage (e.g., settings.json) would be needed for that.
    return $settings;
}

// Initialize settings
$currentSettings = get_site_settings();
$showSuccessMessage = false;

// Handle form submissions if this file is also processing updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process General Settings
    if (isset($_POST['site_name'])) {
        $currentSettings['general']['site_name'] = htmlspecialchars($_POST['site_name']);
    }
    if (isset($_POST['site_tagline'])) {
        $currentSettings['general']['site_tagline'] = htmlspecialchars($_POST['site_tagline']);
    }
    if (isset($_POST['contact_email'])) {
        $currentSettings['general']['contact_email'] = htmlspecialchars($_POST['contact_email']);
    }
    if (isset($_POST['admin_email'])) {
        $currentSettings['general']['admin_email'] = htmlspecialchars($_POST['admin_email']);
    }
    if (isset($_POST['items_per_page'])) {
        $currentSettings['general']['items_per_page'] = (int)$_POST['items_per_page'];
    }
    if (isset($_POST['currency_symbol'])) {
        $currentSettings['general']['currency_symbol'] = htmlspecialchars($_POST['currency_symbol']);
    }

    // Process Security Settings
    // Checkboxes are only present in $_POST if they are checked
    $currentSettings['security']['two_factor_auth_enabled'] = isset($_POST['two_factor_auth_enabled']);
    if (isset($_POST['password_strength_policy'])) {
        $currentSettings['security']['password_strength_policy'] = htmlspecialchars($_POST['password_strength_policy']);
    }
    if (isset($_POST['admin_login_attempts_limit'])) {
        $currentSettings['security']['admin_login_attempts_limit'] = (int)$_POST['admin_login_attempts_limit'];
    }

    // Process Notification Settings
    $currentSettings['notifications']['new_order_email'] = isset($_POST['new_order_email']);
    $currentSettings['notifications']['low_stock_alert'] = isset($_POST['low_stock_alert']);
    $currentSettings['notifications']['new_customer_email'] = isset($_POST['new_customer_email']);
    $currentSettings['notifications']['product_review_email'] = isset($_POST['product_review_email']);

    // Process Appearance Settings
    if (isset($_POST['theme'])) {
        $currentSettings['appearance']['theme'] = htmlspecialchars($_POST['theme']);
    }
    if (isset($_POST['logo_url'])) {
        $currentSettings['appearance']['logo_url'] = htmlspecialchars($_POST['logo_url']);
    }
    if (isset($_POST['favicon_url'])) {
        $currentSettings['appearance']['favicon_url'] = htmlspecialchars($_POST['favicon_url']);
    }

    // In a real application, you would save these updated settings to your database.
    // For this simulation, the updates are now in $currentSettings and will be rendered.

    // Set a flag for JavaScript to show a success message
    $showSuccessMessage = true;

    // IMPORTANT: In a real application, after saving to the database, you would usually
    // redirect to prevent form re-submission on refresh:
    // header("Location: settings.php?status=success");
    // exit();
    // For this immediate update view in Canvas, we omit the redirect.
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Brand Bazaar - Admin Settings</title>
    <link rel="icon" type="image/x-icon" href="/icons/favicon.ico" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />
    <!-- Link to the admin.css for styling the admin panel -->
    <link rel="stylesheet" href="../admin/css/admin.css" />
    <style>
        /* Specific styles for the settings page if needed */
        .settings-form .form-group {
            margin-bottom: 20px;
        }
        .settings-form .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--admin-text-dark);
        }
        .settings-form .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--admin-border);
            border-radius: 5px;
            background-color: var(--admin-input-bg);
            color: var(--admin-text);
            transition: border-color 0.3s;
        }
        .settings-form .form-control:focus {
            border-color: var(--admin-primary);
            outline: none;
        }
        .settings-form .form-control[type="checkbox"] {
            width: auto;
            margin-right: 10px;
        }
        .settings-form .checkbox-group label {
            display: inline-block;
            margin-bottom: 0;
            font-weight: normal;
        }
        .settings-form .btn-group {
            margin-top: 30px;
            display: flex;
            gap: 10px;
        }
        .settings-form h4 {
            margin-top: 30px;
            margin-bottom: 15px;
            color: var(--admin-text-dark);
            border-bottom: 1px solid var(--admin-border-light);
            padding-bottom: 10px;
        }
        .settings-form .form-row {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        .settings-form .form-row > .form-group {
            flex: 1;
            min-width: 250px;
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
      <!-- Settings Section -->
      <section class="content-section" id="settings-section">
        <h1>Settings Management</h1>

        <div class="admin-card">
          <div class="admin-card-header">
            <span>System Settings</span>
          </div>
          <div class="admin-card-body">
            <form class="settings-form" method="POST" action="settings.php">
              <h4>General Settings</h4>
              <div class="form-group">
                <label for="site_name">Site Name</label>
                <input
                  type="text"
                  class="form-control"
                  id="site_name"
                  name="site_name"
                  value="<?php echo htmlspecialchars($currentSettings['general']['site_name']); ?>"
                  required
                />
              </div>
              <div class="form-group">
                <label for="site_tagline">Site Tagline</label>
                <input
                  type="text"
                  class="form-control"
                  id="site_tagline"
                  name="site_tagline"
                  value="<?php echo htmlspecialchars($currentSettings['general']['site_tagline']); ?>"
                />
              </div>
              <div class="form-row">
                <div class="form-group">
                  <label for="contact_email">Contact Email</label>
                  <input
                    type="email"
                    class="form-control"
                    id="contact_email"
                    name="contact_email"
                    value="<?php echo htmlspecialchars($currentSettings['general']['contact_email']); ?>"
                    required
                  />
                </div>
                <div class="form-group">
                  <label for="admin_email">Admin Email</label>
                  <input
                    type="email"
                    class="form-control"
                    id="admin_email"
                    name="admin_email"
                    value="<?php echo htmlspecialchars($currentSettings['general']['admin_email']); ?>"
                    required
                  />
                </div>
              </div>
              <div class="form-row">
                <div class="form-group">
                  <label for="items_per_page">Items Per Page (Frontend)</label>
                  <input
                    type="number"
                    class="form-control"
                    id="items_per_page"
                    name="items_per_page"
                    value="<?php echo htmlspecialchars($currentSettings['general']['items_per_page']); ?>"
                    min="1"
                    required
                  />
                </div>
                <div class="form-group">
                  <label for="currency_symbol">Currency Symbol</label>
                  <input
                    type="text"
                    class="form-control"
                    id="currency_symbol"
                    name="currency_symbol"
                    value="<?php echo htmlspecialchars($currentSettings['general']['currency_symbol']); ?>"
                    maxlength="5"
                    required
                  />
                </div>
              </div>

              <h4>Security Settings</h4>
              <div class="form-group checkbox-group">
                <input
                  type="checkbox"
                  id="two_factor_auth_enabled"
                  name="two_factor_auth_enabled"
                  <?php echo $currentSettings['security']['two_factor_auth_enabled'] ? 'checked' : ''; ?>
                />
                <label for="two_factor_auth_enabled">Enable Two-Factor Authentication for Admin</label>
              </div>
              <div class="form-group">
                <label for="password_strength_policy">Password Strength Policy</label>
                <select
                  class="form-control"
                  id="password_strength_policy"
                  name="password_strength_policy"
                >
                  <option value="weak" <?php echo ($currentSettings['security']['password_strength_policy'] == 'weak') ? 'selected' : ''; ?>>Weak</option>
                  <option value="medium" <?php echo ($currentSettings['security']['password_strength_policy'] == 'medium') ? 'selected' : ''; ?>>Medium</option>
                  <option value="strong" <?php echo ($currentSettings['security']['password_strength_policy'] == 'strong') ? 'selected' : ''; ?>>Strong</option>
                </select>
              </div>
              <div class="form-group">
                <label for="admin_login_attempts_limit">Admin Login Attempts Limit</label>
                <input
                  type="number"
                  class="form-control"
                  id="admin_login_attempts_limit"
                  name="admin_login_attempts_limit"
                  value="<?php echo htmlspecialchars($currentSettings['security']['admin_login_attempts_limit']); ?>"
                  min="1"
                />
              </div>

              <h4>Notification Settings</h4>
              <div class="form-group checkbox-group">
                <input
                  type="checkbox"
                  id="new_order_email"
                  name="new_order_email"
                  <?php echo $currentSettings['notifications']['new_order_email'] ? 'checked' : ''; ?>
                />
                <label for="new_order_email">Receive Email for New Orders</label>
              </div>
              <div class="form-group checkbox-group">
                <input
                  type="checkbox"
                  id="low_stock_alert"
                  name="low_stock_alert"
                  <?php echo $currentSettings['notifications']['low_stock_alert'] ? 'checked' : ''; ?>
                />
                <label for="low_stock_alert">Receive Low Stock Alerts</label>
              </div>
              <div class="form-group checkbox-group">
                <input
                  type="checkbox"
                  id="new_customer_email"
                  name="new_customer_email"
                  <?php echo $currentSettings['notifications']['new_customer_email'] ? 'checked' : ''; ?>
                />
                <label for="new_customer_email">Receive Email for New Customer Registrations</label>
              </div>
              <div class="form-group checkbox-group">
                <input
                  type="checkbox"
                  id="product_review_email"
                  name="product_review_email"
                  <?php echo $currentSettings['notifications']['product_review_email'] ? 'checked' : ''; ?>
                />
                <label for="product_review_email">Receive Email for New Product Reviews</label>
              </div>

              <h4>Appearance Settings</h4>
              <div class="form-group">
                <label for="theme">Admin Panel Theme</label>
                <select
                  class="form-control"
                  id="theme"
                  name="theme"
                >
                  <option value="light" <?php echo ($currentSettings['appearance']['theme'] == 'light') ? 'selected' : ''; ?>>Light</option>
                  <option value="dark" <?php echo ($currentSettings['appearance']['theme'] == 'dark') ? 'selected' : ''; ?>>Dark</option>
                </select>
              </div>
              <div class="form-group">
                <label for="logo_url">Website Logo URL</label>
                <input
                  type="text"
                  class="form-control"
                  id="logo_url"
                  name="logo_url"
                  value="<?php echo htmlspecialchars($currentSettings['appearance']['logo_url']); ?>"
                />
                <small class="text-muted">Enter URL for your website's main logo.</small>
              </div>
              <div class="form-group">
                <label for="favicon_url">Favicon URL</label>
                <input
                  type="text"
                  class="form-control"
                  id="favicon_url"
                  name="favicon_url"
                  value="<?php echo htmlspecialchars($currentSettings['appearance']['favicon_url']); ?>"
                />
                <small class="text-muted">Enter URL for your website's favicon (e.g., .ico, .png).</small>
              </div>

              <div class="btn-group">
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-save"></i> Save Settings
                </button>
                <button type="reset" class="btn btn-secondary">
                  <i class="fas fa-redo"></i> Reset
                </button>
              </div>
            </form>
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
            // In settings.php, we assume only one main section is visible
            contentSections.forEach((section) => {
                section.style.display = "none";
            });
            const activeSection = document.getElementById(sectionId);
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
                // For settings.php, we just need to ensure the 'settings-section' is visible
                // This page is dedicated to settings, so it will always show its section.
                // If you add internal navigation within settings, you'd extend this.
                 if (section === 'settings') {
                    showSection('settings-section');
                 }
            }
          });
        });

        // Ensure the settings section is shown on load
        showSection("settings-section");


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

        // Check for success message from PHP
        const showSuccess = <?php echo json_encode($showSuccessMessage); ?>;
        if (showSuccess) {
            showCustomModal('Settings Saved!', 'Your settings have been updated successfully.', false);
        }

      });
    </script>
  </body>
</html>
