<?php
// Include database configuration
require_once 'config.php'; // Ensure this path is correct relative to all-products.php

// Define the absolute server path to your 'brand-bazaar-ecommerce-project' folder.
// This is needed for the PHP file_exists check for image paths.
// IMPORTANT: You MUST adjust this path to match your actual server setup, same as in add-product.php.
// Example: If your XAMPP htdocs is C:\xampp\htdocs\
// and your project is in C:\xampp\htdocs\brand-bazaar-ecommerce-project\
// then it should be: $_SERVER['DOCUMENT_ROOT'] . '/brand-bazaar-ecommerce-project/';
// If your project is directly in C:\xampp\htdocs\ (e.g., accessed as http://localhost/all-products.php),
// use: $project_absolute_base_path = $_SERVER['DOCUMENT_ROOT'] . '/';
$project_absolute_base_path = $_SERVER['DOCUMENT_ROOT'] . '/brand-bazaar-ecommerce-project/'; // Adjust this!

$message = '';
$messageType = '';

// Handle Product Deletion (logic duplicated from add-product.php for self-contained page)
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $product_id_to_delete = intval($_GET['id']);
    
    // Start transaction for atomic operation
    $conn->begin_transaction();

    try {
        // First, get the image path (web-relative) from the database
        $stmt = $conn->prepare("SELECT image_path FROM products WHERE id = ?");
        $stmt->bind_param("i", $product_id_to_delete);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $image_path_from_db_to_delete = $row['image_path'];
            
            // Delete product from database
            $stmt_del = $conn->prepare("DELETE FROM products WHERE id = ?");
            $stmt_del->bind_param("i", $product_id_to_delete);
            
            if ($stmt_del->execute()) {
                // Delete the physical image file if it exists
                if (!empty($image_path_from_db_to_delete)) {
                    // Convert web-relative path to absolute file system path for unlink
                    $abs_path_to_delete_file = $project_absolute_base_path . $image_path_from_db_to_delete;
                    if (file_exists($abs_path_to_delete_file) && is_file($abs_path_to_delete_file)) {
                        if (!unlink($abs_path_to_delete_file)) {
                            error_log("Failed to delete product image file: " . $abs_path_to_delete_file);
                        }
                    }
                }
                $conn->commit();
                $message = "Product deleted successfully!";
                $messageType = "success";
            } else {
                throw new Exception("Database delete failed: " . $stmt_del->error);
            }
            $stmt_del->close();
        } else {
            throw new Exception("Product not found for deletion.");
        }
        $stmt->close();
    } catch (Exception $e) {
        $conn->rollback();
        $message = "Error deleting product: " . $e->getMessage();
        $messageType = "error";
    }
    // Redirect to self to clear GET parameters and display message
    header("Location: all-products.php?message=" . urlencode($message) . "&type=" . urlencode($messageType));
    exit();
}

// Fetch message from redirect if any
if (isset($_GET['message']) && isset($_GET['type'])) {
    $message = htmlspecialchars($_GET['message']);
    $messageType = htmlspecialchars($_GET['type']);
}

// Fetch all products for display
$products_result = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
if (!$products_result) {
    $message = "Error fetching products: " . mysqli_error($conn);
    $messageType = "error";
}

// Close the database connection (will be re-opened if needed for includes later)
if (isset($conn)) {
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products - Brand Bazaar Admin</title>
    <link rel="icon" type="image/x-icon" href="/icons/favicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <!-- Link to your admin.css, assuming it's in a parent directory "admin/css" or adjust path -->
    <link rel="stylesheet" href="../admin/css/admin.css" /> 
    <style>
        /* Specific styles for all-products.php */
        .product-img-thumb {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
            vertical-align: middle;
        }
        
        /* Message box styles from admin panel theme */
        .message-box {
            padding: 10px 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .message-box.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message-box.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Custom Modal styles from admin panel theme */
        .custom-modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1000; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            align-items: center;
            justify-content: center;
        }
        .custom-modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            border-radius: 8px;
            width: 80%;
            max-width: 500px;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
            animation-name: animatetop;
            animation-duration: 0.4s
        }
        /* Add Animation */
        @keyframes animatetop {
            from {top: -300px; opacity: 0}
            to {top: 0; opacity: 1}
        }
        .custom-modal-header {
            padding: 10px 16px;
            background-color: var(--primary);
            color: white;
            border-radius: 8px 8px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: -20px -20px 20px -20px; /* Adjust to cover padding */
        }
        .custom-modal-header h3 {
            margin: 0;
            color: white; /* Ensure heading text is white */
        }
        .custom-modal-close-btn {
            color: #fff;
            float: right;
            font-size: 28px;
            font-weight: bold;
            background: none;
            border: none;
            cursor: pointer;
        }
        .custom-modal-close-btn:hover,
        .custom-modal-close-btn:focus {
            color: #ccc;
            text-decoration: none;
            cursor: pointer;
        }
        .custom-modal-footer {
            padding: 10px 0 0 0;
            text-align: right;
            margin-top: 20px;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
        .custom-modal-footer button {
            margin-left: 10px;
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
                <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Admin" />
                <div class="user-dropdown">
                    <a href="#"><i class="fas fa-user-circle"></i> My Profile</a>
                    <a href="#"><i class="fas fa-cog"></i> Account Settings</a>
                    <a href="#"><i class="fas fa-question-circle"></i> Help Center</a>
                    <a href="#" id="logoutBtn"><i class="fas fa-sign-out-alt"></i> Logout</a>
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

    <main class="admin-main">
        <section class="content-section" id="all-products-section">
            <h1>All Products</h1>

            <?php if (!empty($message)): ?>
                <div class="message-box <?php echo $messageType; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <div class="admin-card product-list-card">
                <div class="admin-card-header">
                    <span>Product List</span>
                    <a href="add-product.php?action=add" class="btn btn-sm btn-success">
                        <i class="fas fa-plus"></i> Add New Product
                    </a>
                </div>
                <div class="admin-card-body">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Featured</th>
                                <th>Deal</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // Re-open connection if it was closed by previous delete handler and necessary for display
                            // This is a safety check; ideally, you manage connection globally or pass it.
                            if (!isset($conn) || !$conn) {
                                require_once 'config.php';
                                $products_result = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
                            }

                            if ($products_result && mysqli_num_rows($products_result) > 0): ?>
                                <?php while($product = mysqli_fetch_assoc($products_result)): ?>
                                    <tr>
                                        <td><?php echo $product['id']; ?></td>
                                        <td>
                                            <?php if (!empty($product['image_path'])): ?>
                                                <img src="<?php echo htmlspecialchars($product['image_path']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-img-thumb">
                                            <?php else: ?>
                                                <img src="https://placehold.co/80x80/f0f0f0/cccccc?text=No+Image" alt="No Image" class="product-img-thumb" />
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                                        <td>$<?php echo htmlspecialchars(number_format($product['current_price'], 2)); ?></td>
                                        <td><?php echo $product['is_featured'] ? 'Yes' : 'No'; ?></td>
                                        <td><?php echo $product['is_best_deal'] ? 'Yes' : 'No'; ?></td>
                                        <td>
                                            <a href="add-product.php?action=edit&id=<?php echo $product['id']; ?>" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <button 
                                                class="btn btn-sm btn-danger delete-product-btn"
                                                data-id="<?php echo htmlspecialchars($product['id']); ?>"
                                                data-name="<?php echo htmlspecialchars($product['name']); ?>"
                                            >
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7">No products found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>

    <!-- Logout Confirmation Modal -->
    <div class="custom-modal" id="logoutConfirmationModal">
      <div class="custom-modal-content" style="max-width: 500px">
        <div class="custom-modal-header">
          <h3>Confirm Logout</h3>
          <button class="custom-modal-close-btn" id="closeLogoutModal">&times;</button>
        </div>
        <div class="custom-modal-body">
          <p>Are you sure you want to logout?</p>
        </div>
        <div class="custom-modal-footer">
          <button class="btn btn-danger" id="confirmLogoutBtn">Logout</button>
          <button class="btn btn-secondary" id="cancelLogoutBtn">Cancel</button>
        </div>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="custom-modal" id="deleteConfirmationModal">
      <div class="custom-modal-content" style="max-width: 500px">
        <div class="custom-modal-header">
          <h3>Confirm Deletion</h3>
          <button class="custom-modal-close-btn" id="closeDeleteModal">&times;</button>
        </div>
        <div class="custom-modal-body">
          <p id="deleteConfirmationMessage">
            Are you sure you want to delete this product?
          </p>
        </div>
        <div class="custom-modal-footer">
          <button class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
          <button class="btn btn-secondary" id="cancelDeleteBtn">Cancel</button>
        </div>
      </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // General admin panel JS (copied/adapted from admin.php and sliders.php)
            const menuToggle = document.getElementById("menuToggle");
            const sidebar = document.querySelector(".admin-sidebar");
            if (menuToggle && sidebar) {
                menuToggle.addEventListener("click", function () {
                    sidebar.classList.toggle("show");
                });
            }

            const productsMenu = document.getElementById("productsMenu");
            const productsSubmenu = document.getElementById("productsSubmenu");
            if (productsMenu && productsSubmenu) {
                productsMenu.addEventListener("click", function (e) {
                    e.preventDefault();
                    productsSubmenu.classList.toggle("show");
                    this.querySelector(".menu-arrow")?.classList.toggle("rotated");
                });
            }

            // Dark Mode Toggle
            const darkModeToggle = document.getElementById("darkModeToggle");
            const body = document.body;

            if (darkModeToggle) {
                darkModeToggle.addEventListener("click", () => {
                    body.classList.toggle("dark-mode");
                    // Save preference
                    if (body.classList.contains("dark-mode")) {
                        localStorage.setItem("darkMode", "enabled");
                    } else {
                        localStorage.setItem("darkMode", "disabled");
                    }
                });
                // Apply saved preference
                if (localStorage.getItem("darkMode") === "enabled") {
                    body.classList.add("dark-mode");
                }
            }

            // User Dropdown Toggle
            const userDropdownToggle = document.getElementById("userDropdownToggle");
            const userDropdown = userDropdownToggle?.querySelector(".user-dropdown");
            if (userDropdownToggle && userDropdown) {
                userDropdownToggle.addEventListener("click", function (e) {
                    userDropdown.classList.toggle("show");
                    e.stopPropagation(); // Prevent click from closing immediately
                });
                document.addEventListener("click", function (e) {
                    if (!userDropdownToggle.contains(e.target) && userDropdown.classList.contains("show")) {
                        userDropdown.classList.remove("show");
                    }
                });
            }

            // Logout Confirmation Modal
            const logoutBtn = document.getElementById("logoutBtn");
            const logoutConfirmationModal = document.getElementById("logoutConfirmationModal");
            const confirmLogoutBtn = document.getElementById("confirmLogoutBtn");
            const cancelLogoutBtn = document.getElementById("cancelLogoutBtn");
            const closeLogoutModal = document.getElementById("closeLogoutModal");

            if (logoutBtn) {
                logoutBtn.addEventListener("click", function (e) {
                    e.preventDefault();
                    logoutConfirmationModal.style.display = "flex";
                });
            }

            if (confirmLogoutBtn) {
                confirmLogoutBtn.addEventListener("click", function () {
                    window.location.href = "logout.php"; // Assuming you have a logout.php
                });
            }

            if (cancelLogoutBtn) {
                cancelLogoutBtn.addEventListener("click", function () {
                    logoutConfirmationModal.style.display = "none";
                });
            }

            if (closeLogoutModal) {
                closeLogoutModal.addEventListener("click", function () {
                    logoutConfirmationModal.style.display = "none";
                });
            }
            window.addEventListener("click", function (event) {
                if (event.target == logoutConfirmationModal) {
                    logoutConfirmationModal.style.display = "none";
                }
            });


            // Delete Product functionality (specific to this page)
            const deleteConfirmationModal = document.getElementById("deleteConfirmationModal");
            const confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
            const cancelDeleteBtn = document.getElementById("cancelDeleteBtn");
            const closeDeleteModal = document.getElementById("closeDeleteModal");
            let currentProductToDelete = null;

            document.querySelectorAll(".delete-product-btn").forEach(button => {
                button.addEventListener("click", function () {
                    currentProductToDelete = this.dataset.id;
                    const productName = this.dataset.name;
                    document.getElementById("deleteConfirmationMessage").textContent = `Are you sure you want to delete product "${productName}"? This action cannot be undone.`;
                    deleteConfirmationModal.style.display = "flex";
                });
            });

            confirmDeleteBtn.addEventListener("click", function () {
                if (currentProductToDelete) {
                    window.location.href = `all-products.php?action=delete&id=${currentProductToDelete}`;
                }
            });

            cancelDeleteBtn.addEventListener("click", function () {
                deleteConfirmationModal.style.display = "none";
                currentProductToDelete = null;
            });

            closeDeleteModal.addEventListener("click", function () {
                deleteConfirmationModal.style.display = "none";
                currentProductToDelete = null;
            });

            window.addEventListener("click", function (event) {
                if (event.target == deleteConfirmationModal) {
                    deleteConfirmationModal.style.display = "none";
                }
            });
        });
    </script>
</body>
</html>
