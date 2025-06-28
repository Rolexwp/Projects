<?php
// Include database configuration
require_once 'config.php'; // Ensure this path is correct

// Define the web-relative path where product images are stored and accessed by the browser
// This is the path that will be saved in the database
const PRODUCT_UPLOAD_WEB_DIR = 'uploads/products/';

// Define the absolute server path to your 'brand-bazaar-ecommerce-project' folder
// IMPORTANT: You MUST adjust this path to match your actual server setup.
// Example: If your XAMPP htdocs is C:\xampp\htdocs\
// and your project is in C:\xampp\htdocs\brand-bazaar-ecommerce-project\
// then it should be: $_SERVER['DOCUMENT_ROOT'] . '/brand-bazaar-ecommerce-project/';
// If your project is directly in C:\xampp\htdocs\ (e.g., accessed as http://localhost/add-product.php),
// use: $project_absolute_base_path = $_SERVER['DOCUMENT_ROOT'] . '/';
$project_absolute_base_path = $_SERVER['DOCUMENT_ROOT'] . '/brand-bazaar-ecommerce-project/';

// Define the absolute server path for the product upload directory for PHP file operations
$product_upload_abs_dir = $project_absolute_base_path . PRODUCT_UPLOAD_WEB_DIR;

// Ensure the upload directory exists (using the absolute path for mkdir)
if (!is_dir($product_upload_abs_dir)) {
    if (!mkdir($product_upload_abs_dir, 0777, true)) {
        // Log an error if directory creation fails (for debugging)
        error_log("Failed to create product upload directory: " . $product_upload_abs_dir);
        $message = "Error: Could not create product upload directory. Check server permissions.";
        $messageType = "error";
    }
}

$message = '';
$messageType = ''; // To distinguish success/error messages

// --- Handle Product Addition/Editing ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_product'])) { // Added check for submit_product button
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $current_price = floatval($_POST['current_price']);
    $original_price = isset($_POST['original_price']) && $_POST['original_price'] !== '' ? floatval($_POST['original_price']) : NULL;
    $discount = mysqli_real_escape_string($conn, $_POST['discount']);
    $rating = isset($_POST['rating']) ? floatval($_POST['rating']) : 0.0;
    $reviews_count = isset($_POST['reviews_count']) ? intval($_POST['reviews_count']) : 0;
    $badge = mysqli_real_escape_string($conn, $_POST['badge']);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $is_best_deal = isset($_POST['is_best_deal']) ? 1 : 0;

    $image_path = ''; // This will store the web-relative path that goes into the DB
    $existing_image_path_from_db = isset($_POST['existing_image_path']) ? mysqli_real_escape_string($conn, $_POST['existing_image_path']) : '';

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_name = uniqid('product_') . '_' . basename($_FILES['image']['name']);
        
        // Destination for moving the uploaded file (absolute path on server)
        $destination_abs_path = $product_upload_abs_dir . $file_name;
        
        // Path to store in the database (web-relative path)
        $image_path_for_db = PRODUCT_UPLOAD_WEB_DIR . $file_name;

        if (move_uploaded_file($file_tmp, $destination_abs_path)) {
            // If editing and a new image is uploaded, delete the old one
            if ($product_id > 0 && !empty($existing_image_path_from_db)) {
                $abs_old_image_path = $project_absolute_base_path . $existing_image_path_from_db;
                if (file_exists($abs_old_image_path) && is_file($abs_old_image_path)) {
                    if (!unlink($abs_old_image_path)) {
                        error_log("Failed to delete old product image file: " . $abs_old_image_path);
                    }
                }
            }
            $image_path = $image_path_for_db; // This is the value that goes into the DB
        } else {
            $message = "Failed to upload image. Error code: " . $_FILES['image']['error'];
            $messageType = "error";
        }
    } else {
        // If no new image is uploaded, retain the existing one from the database
        $image_path = $existing_image_path_from_db;
        if ($product_id == 0 && empty($image_path)) { // If adding a new product and no image is uploaded
            $message = "Image is required for new products!";
            $messageType = "error";
        }
    }

    if (empty($name) || empty($current_price)) {
        $message = "Product name and current price are required.";
        $messageType = "error";
    }

    if ($messageType !== "error") { // Proceed only if no input or file upload errors
        if ($product_id > 0) {
            // Update existing product
            $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, image_path = ?, current_price = ?, original_price = ?, discount = ?, rating = ?, reviews_count = ?, badge = ?, is_featured = ?, is_best_deal = ? WHERE id = ?");
            $stmt->bind_param("sssdssdisiii", $name, $description, $image_path, $current_price, $original_price, $discount, $rating, $reviews_count, $badge, $is_featured, $is_best_deal, $product_id);

            if ($stmt->execute()) {
                $message = "Product updated successfully!";
                $messageType = "success";
            } else {
                $message = "Error updating product: " . $stmt->error;
                $messageType = "error";
            }
            $stmt->close();
        } else {
            // Add new product
            $stmt = $conn->prepare("INSERT INTO products (name, description, image_path, current_price, original_price, discount, rating, reviews_count, badge, is_featured, is_best_deal) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssdssdisii", $name, $description, $image_path, $current_price, $original_price, $discount, $rating, $reviews_count, $badge, $is_featured, $is_best_deal);

            if ($stmt->execute()) {
                $message = "Product added successfully!";
                $messageType = "success";
            } else {
                $message = "Error adding product: " . $stmt->error;
                $messageType = "error";
                // Delete the uploaded file if database insert failed
                if (isset($destination_abs_path) && file_exists($destination_abs_path)) {
                    unlink($destination_abs_path);
                }
            }
            $stmt->close();
        }
    }
}

// --- Handle Product Deletion ---
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
}


// --- Fetch Product for Editing ---
$edit_product = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $product_id_to_edit = intval($_GET['id']);
    $result = mysqli_query($conn, "SELECT * FROM products WHERE id = $product_id_to_edit");
    if ($result && mysqli_num_rows($result) > 0) {
        $edit_product = mysqli_fetch_assoc($result);
    } else {
        $message = "Product not found for editing.";
        $messageType = "error";
    }
}

// Fetch all products for display
$products_result = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
if (!$products_result) {
    $message = "Error fetching products: " . mysqli_error($conn);
    $messageType = "error";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products - Brand Bazaar Admin</title>
    <link rel="icon" type="image/x-icon" href="/icons/favicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <!-- Link to your admin.css, assuming it's in a parent directory "admin/css" or adjust path -->
    <link rel="stylesheet" href="../admin/css/admin.css" /> 
    <style>
        /* Specific styles for add-product.php */
        .product-img-thumb {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
            vertical-align: middle;
        }
        .form-group.image-preview img {
            max-width: 150px;
            max-height: 100px;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        /* Message box styles from sliders.php */
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

        /* Custom Modal styles from sliders.php */
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
        <section class="content-section" id="product-management-section">
            <h1>Manage Products</h1>

            <?php if (!empty($message)): ?>
                <div class="message-box <?php echo $messageType; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <div class="admin-card">
                <div class="admin-card-header">
                    <span id="productFormTitle"><?php echo $edit_product ? 'Edit Product' : 'Add New Product'; ?></span>
                    <button class="btn btn-sm btn-success" id="showAddProductForm">
                        <i class="fas fa-plus"></i> Add New Product
                    </button>
                </div>
                <div class="admin-card-body">
                    <form id="productForm" action="add-product.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="product_id" id="productId" value="<?php echo $edit_product ? $edit_product['id'] : ''; ?>">
                        <input type="hidden" name="existing_image_path" id="existingImagePath" value="<?php echo $edit_product ? htmlspecialchars($edit_product['image_path']) : ''; ?>">

                        <div class="form-group">
                            <label class="form-label" for="name">Product Name:</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $edit_product ? htmlspecialchars($edit_product['name']) : ''; ?>" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="description">Description:</label>
                            <textarea class="form-control" id="description" name="description" rows="3"><?php echo $edit_product ? htmlspecialchars($edit_product['description']) : ''; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="current_price">Current Price ($):</label>
                            <input type="number" class="form-control" id="current_price" name="current_price" step="0.01" value="<?php echo $edit_product ? htmlspecialchars($edit_product['current_price']) : ''; ?>" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="original_price">Original Price ($) (Optional):</label>
                            <input type="number" class="form-control" id="original_price" name="original_price" step="0.01" value="<?php echo $edit_product && $edit_product['original_price'] !== null ? htmlspecialchars($edit_product['original_price']) : ''; ?>">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="discount">Discount (% or text) (Optional):</label>
                            <input type="text" class="form-control" id="discount" name="discount" value="<?php echo $edit_product ? htmlspecialchars($edit_product['discount']) : ''; ?>">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="rating">Rating (0.0 - 5.0):</label>
                            <input type="number" class="form-control" id="rating" name="rating" step="0.1" min="0" max="5" value="<?php echo $edit_product ? htmlspecialchars($edit_product['rating']) : '0.0'; ?>">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="reviews_count">Reviews Count:</label>
                            <input type="number" class="form-control" id="reviews_count" name="reviews_count" value="<?php echo $edit_product ? htmlspecialchars($edit_product['reviews_count']) : '0'; ?>">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="badge">Badge (e.g., Featured, Bestseller, Hot Deal):</label>
                            <input type="text" class="form-control" id="badge" name="badge" value="<?php echo $edit_product ? htmlspecialchars($edit_product['badge']) : ''; ?>">
                        </div>

                        <div class="form-group image-preview">
                            <label class="form-label" for="image">Product Image:</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <small class="text-muted" id="imageHint">Upload a new image (will replace existing if editing).</small>
                            <div id="imagePreviewContainer">
                                <?php if ($edit_product && !empty($edit_product['image_path'])): ?>
                                    <img src="<?php echo htmlspecialchars($edit_product['image_path']); ?>" alt="Current Product Image">
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group checkbox-group">
                            <label class="form-label">
                                <input type="checkbox" name="is_featured" id="isFeatured" <?php echo $edit_product && $edit_product['is_featured'] ? 'checked' : ''; ?>>
                                Featured Product
                            </label>
                            <label class="form-label">
                                <input type="checkbox" name="is_best_deal" id="isBestDeal" <?php echo $edit_product && $edit_product['is_best_deal'] ? 'checked' : ''; ?>>
                                Best Deal
                            </label>
                        </div>

                        <div class="form-group">
                            <button type="submit" name="submit_product" class="btn btn-success"><i class="fas fa-save"></i> <?php echo $edit_product ? 'Update Product' : 'Add Product'; ?></button>
                            <?php if ($edit_product): ?>
                                <a href="add-product.php" class="btn btn-danger"><i class="fas fa-times"></i> Cancel Edit</a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>

            <div class="admin-card product-list-card">
                <div class="admin-card-header">
                    <span>Existing Products</span>
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
                            <?php if ($products_result && mysqli_num_rows($products_result) > 0): ?>
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
                                            <button 
                                                class="btn btn-sm btn-primary edit-product-btn"
                                                data-id="<?php echo htmlspecialchars($product['id']); ?>"
                                                data-name="<?php echo htmlspecialchars($product['name']); ?>"
                                                data-description="<?php echo htmlspecialchars($product['description']); ?>"
                                                data-current-price="<?php echo htmlspecialchars($product['current_price']); ?>"
                                                data-original-price="<?php echo htmlspecialchars($product['original_price']); ?>"
                                                data-discount="<?php echo htmlspecialchars($product['discount']); ?>"
                                                data-rating="<?php echo htmlspecialchars($product['rating']); ?>"
                                                data-reviews-count="<?php echo htmlspecialchars($product['reviews_count']); ?>"
                                                data-badge="<?php echo htmlspecialchars($product['badge']); ?>"
                                                data-is-featured="<?php echo htmlspecialchars($product['is_featured']); ?>"
                                                data-is-best-deal="<?php echo htmlspecialchars($product['is_best_deal']); ?>"
                                                data-image-path="<?php echo htmlspecialchars($product['image_path']); ?>"
                                            >
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button 
                                                class="btn btn-sm btn-danger delete-product-btn"
                                                data-id="<?php echo htmlspecialchars($product['id']); ?>"
                                            >
                                                <i class="fas fa-trash"></i>
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

    <!-- Logout Confirmation Modal (from sliders.php) -->
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

    <!-- Delete Confirmation Modal (from sliders.php) -->
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


            // Product Management Specific JS
            const showAddProductFormBtn = document.getElementById("showAddProductForm");
            const productFormContainer = document.querySelector(".admin-card #productForm");
            const productFormTitle = document.getElementById("productFormTitle");
            const productIdInput = document.getElementById("productId");
            const nameInput = document.getElementById("name");
            const descriptionInput = document.getElementById("description");
            const currentPriceInput = document.getElementById("current_price");
            const originalPriceInput = document.getElementById("original_price");
            const discountInput = document.getElementById("discount");
            const ratingInput = document.getElementById("rating");
            const reviewsCountInput = document.getElementById("reviews_count");
            const badgeInput = document.getElementById("badge");
            const isFeaturedInput = document.getElementById("isFeatured");
            const isBestDealInput = document.getElementById("isBestDeal");
            const imageInput = document.getElementById("image");
            const existingImagePathInput = document.getElementById('existingImagePath');
            const imagePreviewContainer = document.getElementById("imagePreviewContainer");
            const imageHint = document.getElementById("imageHint");
            const productSaveBtn = document.querySelector("#productForm button[type='submit']");


            // Function to reset the form for adding a new product
            showAddProductFormBtn.addEventListener("click", function () {
                productFormTitle.textContent = "Add New Product";
                productFormContainer.reset(); // Resets all form fields
                productIdInput.value = "";
                existingImagePathInput.value = "";
                imagePreviewContainer.innerHTML = ""; // Clear image preview
                imageHint.textContent = "Upload a new image.";
                imageInput.required = true; // Image is required for new products
                productSaveBtn.textContent = "Add Product";
            });

            // Edit Product functionality
            document.querySelectorAll(".edit-product-btn").forEach(button => {
                button.addEventListener("click", function () {
                    productFormTitle.textContent = "Edit Product";
                    
                    productIdInput.value = this.dataset.id;
                    nameInput.value = this.dataset.name;
                    descriptionInput.value = this.dataset.description;
                    currentPriceInput.value = this.dataset.currentPrice;
                    originalPriceInput.value = this.dataset.originalPrice;
                    discountInput.value = this.dataset.discount;
                    ratingInput.value = this.dataset.rating;
                    reviewsCountInput.value = this.dataset.reviewsCount;
                    badgeInput.value = this.dataset.badge;
                    isFeaturedInput.checked = (this.dataset.isFeatured === '1');
                    isBestDealInput.checked = (this.dataset.isBestDeal === '1');
                    existingImagePathInput.value = this.dataset.imagePath;

                    imageInput.required = false; // Image not required when editing
                    imageHint.textContent = "Upload a new image to replace the existing one.";

                    if (this.dataset.imagePath) {
                        imagePreviewContainer.innerHTML = `<img src="${this.dataset.imagePath}" alt="Current Product Image" />`;
                    } else {
                        imagePreviewContainer.innerHTML = "";
                    }
                    productSaveBtn.textContent = "Update Product";
                    // Scroll to form to make it visible if it's off-screen
                    productFormContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
            });

            // Delete Product functionality
            const deleteConfirmationModal = document.getElementById("deleteConfirmationModal");
            const confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
            const cancelDeleteBtn = document.getElementById("cancelDeleteBtn");
            const closeDeleteModal = document.getElementById("closeDeleteModal");
            let currentProductToDelete = null;

            document.querySelectorAll(".delete-product-btn").forEach(button => {
                button.addEventListener("click", function () {
                    currentProductToDelete = this.dataset.id;
                    deleteConfirmationModal.style.display = "flex";
                    document.getElementById("deleteConfirmationMessage").textContent = "Are you sure you want to delete this product? This action cannot be undone.";
                });
            });

            confirmDeleteBtn.addEventListener("click", function () {
                if (currentProductToDelete) {
                    window.location.href = `add-product.php?action=delete&id=${currentProductToDelete}`;
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

            // Image input change for preview
            if (imageInput) {
                imageInput.addEventListener("change", function () {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            imagePreviewContainer.innerHTML = `<img src="${e.target.result}" alt="New Product Image" />`;
                        };
                        reader.readAsDataURL(this.files[0]);
                    } else {
                        imagePreviewContainer.innerHTML = "";
                    }
                });
            }
        });
    </script>
</body>
</html>
<?php
// Close the database connection
if (isset($conn)) {
    mysqli_close($conn);
}
?>
