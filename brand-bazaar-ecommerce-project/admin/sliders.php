<?php
// Include database configuration
require_once 'config.php';

// Initialize variables
$message = '';
$messageType = '';
$sliderId = 0;
$title = '';
$description = '';
$link = '';
$orderBy = 0;
$badgeText = ''; // New
$showCountdown = 0; // New, 0 for FALSE, 1 for TRUE
$countdownDate = NULL; // New

// Handle Delete Slider
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_slider'])) {
    $sliderId = (int)$_POST['slider_id'];
    
    // Start transaction for atomic operation
    $conn->begin_transaction();
    
    try {
        // First, get the image path to delete the file
        $stmt = $conn->prepare("SELECT image_path FROM sliders WHERE id = ?");
        $stmt->bind_param("i", $sliderId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $imageToDelete = $row['image_path'];
            
            // Delete from database first
            $stmt_del = $conn->prepare("DELETE FROM sliders WHERE id = ?");
            $stmt_del->bind_param("i", $sliderId);
            
            if ($stmt_del->execute()) {
                // Delete the physical image file if it exists
                if (!empty($imageToDelete)) {
                    // Ensure the path is relative to the document root for unlink to work
                    // Adjust this path if your 'uploads' directory is not directly under the document root
                    $absolutePath = $_SERVER['DOCUMENT_ROOT'] . str_replace('/brand-bazaar-ecommerce-project', '', $imageToDelete);
                    
                    if (file_exists($absolutePath) && is_file($absolutePath)) {
                        if (!unlink($absolutePath)) {
                            // Log error but don't fail transaction if file delete fails
                            error_log("Failed to delete image file: " . $absolutePath);
                        }
                    }
                }
                
                $conn->commit();
                $message = "Slider deleted successfully!";
                $messageType = "success";
            } else {
                throw new Exception("Database delete failed");
            }
            $stmt_del->close();
        } else {
            throw new Exception("Slider not found");
        }
        $stmt->close();
    } catch (Exception $e) {
        $conn->rollback();
        $message = "Error deleting slider: " . $e->getMessage();
        $messageType = "error";
    }
}

// Handle form submission (non-file fields)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_slider'])) {
    $sliderId = isset($_POST['slider_id']) ? (int)$_POST['slider_id'] : 0;
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $link = trim($_POST['link']);
    $orderBy = isset($_POST['order_by']) ? (int)$_POST['order_by'] : 0;
    
    // New fields
    $badgeText = trim($_POST['badge_text']);
    $showCountdown = isset($_POST['show_countdown']) ? 1 : 0;
    $countdownDate = !empty($_POST['countdown_date']) ? $_POST['countdown_date'] : NULL;
    
    // Validate required fields
    if (empty($title)) {
        $message = "Title is required!";
        $messageType = "error";
    }
}

// Define upload directory with absolute path
// Adjust '/brand-bazaar-ecommerce-project/uploads/sliders/' if your project structure is different
$uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/brand-bazaar-ecommerce-project/uploads/sliders/';
$uploadDir = str_replace('\\', '/', $uploadDir); // Normalize slashes

// Create directory if it doesn't exist
if (!is_dir($uploadDir)) {
    if (!mkdir($uploadDir, 0777, true)) {
        die("Failed to create upload directory. Please check permissions.");
    }
}

// Handle image upload and database save/update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_slider'])) {
    $imagePath = isset($_POST['current_image_path']) ? $_POST['current_image_path'] : ''; // Default to current image path

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = basename($_FILES['image']['name']);
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $newFileName = uniqid('slider_') . '.' . $fileExtension;
        $destPath = $uploadDir . $newFileName;

        if (!file_exists($fileTmpPath)) {
            $message = "Temporary upload file not found.";
            $messageType = "error";
        } elseif (!is_writable($uploadDir)) {
            $message = "Upload directory is not writable. Please check permissions.";
            $messageType = "error";
        } elseif (!in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
            $message = "Invalid file type. Only JPG, JPEG, PNG, GIF are allowed.";
            $messageType = "error";
        } elseif (move_uploaded_file($fileTmpPath, $destPath)) {
            $imagePath = '/brand-bazaar-ecommerce-project/uploads/sliders/' . $newFileName;
            // Optionally, delete old image if updating and a new image is uploaded
            if ($sliderId > 0 && !empty($_POST['current_image_path']) && $_POST['current_image_path'] !== $imagePath) {
                 $oldAbsolutePath = $_SERVER['DOCUMENT_ROOT'] . str_replace('/brand-bazaar-ecommerce-project', '', $_POST['current_image_path']);
                 if (file_exists($oldAbsolutePath) && is_file($oldAbsolutePath)) {
                     unlink($oldAbsolutePath); // Delete the old physical file
                 }
            }
        } else {
            $error = error_get_last();
            $message = "Error moving uploaded file. Server error: " . ($error ? $error['message'] : "Unknown error");
            $messageType = "error";
        }
    } else if ($sliderId == 0 && empty($imagePath)) {
        // If adding a new slider and no image is uploaded
        $message = "Image is required for new sliders!";
        $messageType = "error";
    }

    if ($messageType !== "error") { // Proceed only if no file upload errors
        if ($sliderId > 0) {
            // Update existing slider
            $stmt = $conn->prepare("UPDATE sliders SET image_path = ?, title = ?, description = ?, link = ?, order_by = ?, badge_text = ?, show_countdown = ?, countdown_date = ? WHERE id = ?");
            // 's' for string, 'i' for integer. For countdown_date, use 's' as it can be NULL.
            $stmt->bind_param("ssssisisi", $imagePath, $title, $description, $link, $orderBy, $badgeText, $showCountdown, $countdownDate, $sliderId);
        } else {
            // Add new slider
            $stmt = $conn->prepare("INSERT INTO sliders (image_path, title, description, link, order_by, badge_text, show_countdown, countdown_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssisis", $imagePath, $title, $description, $link, $orderBy, $badgeText, $showCountdown, $countdownDate);
        }
        
        if ($stmt->execute()) {
            $message = $sliderId > 0 ? "Slider updated successfully!" : "Slider added successfully!";
            $messageType = "success";
        } else {
            $message = "Error saving to database: " . $conn->error;
            $messageType = "error";
            // Delete the uploaded file if database update failed
            if (isset($destPath) && file_exists($destPath)) {
                unlink($destPath);
            }
        }
        $stmt->close();
    }
}


// Fetch all sliders for display
$sliders = [];
$result = $conn->query("SELECT * FROM sliders ORDER BY order_by ASC, id DESC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $sliders[] = $row;
    }
    $result->free();
} else {
    $message = "Error fetching sliders: " . $conn->error;
    $messageType = "error";
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Brand Bazaar - Slider Management</title>
    <link rel="icon" type="image/x-icon" href="/icons/favicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="../admin/css/admin.css" />
    <style>
        .slider-img-thumb {
            width: 100px;
            height: 60px;
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
        /* Custom Modal for messages, similar to admin.php's delete confirmation */
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

    <aside class="admin-sidebar">
        <button class="menu-toggle" id="menuToggle">
            <i class="fas fa-bars"></i>
        </button>
        <ul class="admin-menu">
            <li>
                <a href="admin.php" data-section="dashboard">
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
                    <li><a href="admin.php#all-products" data-subsection="all-products">All Products</a></li>
                    <li><a href="admin.php#add-product" data-subsection="add-product">Add New</a></li>
                    <li><a href="admin.php#categories" data-subsection="categories">Categories</a></li>
                    <li>
              <a href="#Featured Products" data-subsection="Featured Products">Featured Products</a>
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
                <a href="reports.php" data-section="reports">
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
        <section class="content-section" id="sliders-section">
            <h1>Slider Management</h1>

            <?php if (!empty($message)): ?>
                <div class="message-box <?php echo $messageType; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <div class="admin-card">
                <div class="admin-card-header">
                    <span>Manage Sliders</span>
                    <button class="btn btn-sm btn-success" id="showAddSliderForm">
                        <i class="fas fa-plus"></i> Add New Slider
                    </button>
                </div>
                <div class="admin-card-body">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Badge</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Link</th>
                                <th>Order</th>
                                <th>Countdown</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($sliders) > 0): ?>
                                <?php foreach ($sliders as $slider): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($slider['id']); ?></td>
                                        <td>
                                            <?php if (!empty($slider['image_path']) && file_exists($_SERVER['DOCUMENT_ROOT'] . str_replace('/brand-bazaar-ecommerce-project', '', $slider['image_path']))): ?>
                                                <img src="<?php echo htmlspecialchars($slider['image_path']); ?>" alt="Slider Image" class="slider-img-thumb" />
                                            <?php else: ?>
                                                <img src="https://placehold.co/100x60/f0f0f0/cccccc?text=No+Image" alt="No Image" class="slider-img-thumb" />
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($slider['badge_text'] ?? '-'); ?></td>
                                        <td><?php echo htmlspecialchars($slider['title']); ?></td>
                                        <td><?php echo htmlspecialchars(substr($slider['description'], 0, 50)) . (strlen($slider['description']) > 50 ? '...' : ''); ?></td>
                                        <td><?php echo htmlspecialchars($slider['link']); ?></td>
                                        <td><?php echo htmlspecialchars($slider['order_by']); ?></td>
                                        <td><?php echo ($slider['show_countdown'] ?? 0) ? 'Yes' : 'No'; ?></td>
                                        <td>
                                            <button 
                                                class="btn btn-sm btn-primary edit-slider-btn"
                                                data-id="<?php echo htmlspecialchars($slider['id']); ?>"
                                                data-title="<?php echo htmlspecialchars($slider['title']); ?>"
                                                data-description="<?php echo htmlspecialchars($slider['description']); ?>"
                                                data-link="<?php echo htmlspecialchars($slider['link']); ?>"
                                                data-order="<?php echo htmlspecialchars($slider['order_by']); ?>"
                                                data-image="<?php echo htmlspecialchars($slider['image_path']); ?>"
                                                data-badge-text="<?php echo htmlspecialchars($slider['badge_text'] ?? ''); ?>"
                                                data-show-countdown="<?php echo htmlspecialchars($slider['show_countdown'] ?? '0'); ?>"
                                                data-countdown-date="<?php echo htmlspecialchars($slider['countdown_date'] ?? ''); ?>"
                                            >
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button 
                                                class="btn btn-sm btn-danger delete-slider-btn"
                                                data-id="<?php echo htmlspecialchars($slider['id']); ?>"
                                                data-image="<?php echo htmlspecialchars($slider['image_path']); ?>"
                                            >
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9">No sliders found. Add a new one!</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="admin-card" id="sliderFormContainer" style="display: none;">
                <div class="admin-card-header">
                    <span id="sliderFormTitle">Add New Slider</span>
                </div>
                <div class="admin-card-body">
                    <form id="sliderForm" method="POST" action="sliders.php" enctype="multipart/form-data">
                        <input type="hidden" name="slider_id" id="sliderId" value="" />
                        <input type="hidden" name="current_image_path" id="currentImagePath" value="" />
                        
                        <div class="form-group">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" id="sliderTitle" required />
                        </div>

                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="sliderDescription" rows="3"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Link (URL)</label>
                            <input type="url" class="form-control" name="link" id="sliderLink" placeholder="e.g., https://yourstore.com/deals" />
                        </div>

                        <div class="form-group">
                            <label class="form-label">Order (e.g., 1, 2, 3)</label>
                            <input type="number" class="form-control" name="order_by" id="sliderOrderBy" value="0" />
                            <small class="text-muted">Sliders will be sorted by this number (lower numbers appear first).</small>
                        </div>

                        <div class="form-group image-preview">
                            <label class="form-label">Image</label>
                            <input type="file" class="form-control" name="image" id="sliderImage" accept="image/*" />
                            <small class="text-muted" id="imageHint">Upload a new image (will replace existing if editing).</small>
                            <div id="imagePreviewContainer">
                                </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Badge Text (Optional)</label>
                            <input type="text" class="form-control" name="badge_text" id="sliderBadgeText" placeholder="e.g., Hot Deal, New" maxlength="100" />
                            <small class="text-muted">A short text to display on the slider, like 'Sale' or 'New'.</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Show Countdown Timer</label>
                            <input type="checkbox" name="show_countdown" id="sliderShowCountdown" value="1" />
                            <small class="text-muted">Check to display a countdown timer on this slider.</small>
                        </div>

                        <div class="form-group" id="countdownDateGroup" style="display: none;">
                            <label class="form-label">Countdown End Date/Time</label>
                            <input type="datetime-local" class="form-control" name="countdown_date" id="sliderCountdownDate" />
                            <small class="text-muted">Set the date and time for the countdown to end.</small>
                        </div>

                        <div class="form-group">
                            <button type="submit" name="submit_slider" class="btn btn-success"><i class="fas fa-save"></i> Save Slider</button>
                            <button type="button" class="btn btn-danger" id="cancelSliderForm"><i class="fas fa-times"></i> Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>

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

    <div class="custom-modal" id="deleteConfirmationModal">
      <div class="custom-modal-content" style="max-width: 500px">
        <div class="custom-modal-header">
          <h3>Confirm Deletion</h3>
          <button class="custom-modal-close-btn" id="closeDeleteModal">&times;</button>
        </div>
        <div class="custom-modal-body">
          <p id="deleteConfirmationMessage">
            Are you sure you want to delete this item?
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
            // General admin panel JS (copied/adapted from admin.php)
            const menuToggle = document.getElementById("menuToggle");
            const sidebar = document.querySelector(".admin-sidebar");
            if (menuToggle && sidebar) {
                menuToggle.addEventListener("click", function () {
                    sidebar.classList.toggle("show");
                });
            }

            const productsMenu = document.getElementById("productsMenu");
            const productsSubmenu = document.getElementById("productsSubmenu");
            const contentMenu = document.getElementById("contentMenu");
            const contentSubmenu = document.getElementById("contentSubmenu");

            if (productsMenu && productsSubmenu) {
                productsMenu.addEventListener("click", function (e) {
                    e.preventDefault();
                    productsSubmenu.classList.toggle("show");
                    this.querySelector(".menu-arrow")?.classList.toggle("rotated");
                });
            }
            if (contentMenu && contentSubmenu) {
                contentSubmenu.addEventListener("click", function (e) {
                    e.preventDefault();
                    contentSubmenu.classList.toggle("show");
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
                    // Perform logout action here (e.g., redirect to logout script)
                    window.location.href = "logout.php";
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


            // Slider Management Specific JS
            const showAddSliderFormBtn = document.getElementById("showAddSliderForm");
            const sliderFormContainer = document.getElementById("sliderFormContainer");
            const cancelSliderFormBtn = document.getElementById("cancelSliderForm");
            const sliderFormTitle = document.getElementById("sliderFormTitle");
            const sliderForm = document.getElementById("sliderForm");
            const sliderIdInput = document.getElementById("sliderId");
            const sliderTitleInput = document.getElementById("sliderTitle");
            const sliderDescriptionInput = document.getElementById("sliderDescription");
            const sliderLinkInput = document.getElementById("sliderLink");
            const sliderOrderByInput = document.getElementById("sliderOrderBy");
            const sliderImageInput = document.getElementById("sliderImage");
            const imagePreviewContainer = document.getElementById("imagePreviewContainer");
            const imageHint = document.getElementById("imageHint");
            const currentImagePathInput = document.getElementById('currentImagePath');
            const sliderBadgeTextInput = document.getElementById("sliderBadgeText"); // New
            const sliderShowCountdownInput = document.getElementById("sliderShowCountdown"); // New
            const countdownDateGroup = document.getElementById("countdownDateGroup"); // New
            const sliderCountdownDateInput = document.getElementById("sliderCountdownDate"); // New

            function toggleCountdownDateGroup() {
                if (sliderShowCountdownInput.checked) {
                    countdownDateGroup.style.display = "block";
                    sliderCountdownDateInput.required = true; 
                } else {
                    countdownDateGroup.style.display = "none";
                    sliderCountdownDateInput.required = false;
                    sliderCountdownDateInput.value = ""; // Clear value if hidden
                }
            }

            showAddSliderFormBtn.addEventListener("click", function () {
                sliderFormContainer.style.display = "block";
                sliderFormTitle.textContent = "Add New Slider";
                sliderForm.reset(); // Clear form fields
                sliderIdInput.value = ""; // Clear slider ID for add mode
                imagePreviewContainer.innerHTML = ""; // Clear image preview
                imageHint.textContent = "Upload a new image.";
                sliderImageInput.required = true; // Image is required for new sliders
                sliderBadgeTextInput.value = ""; // Reset new fields
                sliderShowCountdownInput.checked = false; // Reset new fields
                sliderCountdownDateInput.value = ""; // Reset new fields
                toggleCountdownDateGroup(); // Update visibility
            });

            cancelSliderFormBtn.addEventListener("click", function () {
                sliderFormContainer.style.display = "none";
            });

            // Edit Slider functionality
            document.querySelectorAll(".edit-slider-btn").forEach(button => {
                button.addEventListener("click", function () {
                    sliderFormContainer.style.display = "block";
                    sliderFormTitle.textContent = "Edit Slider";
                    
                    const id = this.dataset.id;
                    const title = this.dataset.title;
                    const description = this.dataset.description;
                    const link = this.dataset.link;
                    const order = this.dataset.order;
                    const image = this.dataset.image;
                    const badgeText = this.dataset.badgeText; // New
                    const showCountdown = this.dataset.showCountdown; // New
                    const countdownDate = this.dataset.countdownDate; // New

                    sliderIdInput.value = id;
                    sliderTitleInput.value = title;
                    sliderDescriptionInput.value = description;
                    sliderLinkInput.value = link;
                    sliderOrderByInput.value = order;
                    currentImagePathInput.value = image; // Store current image path
                    sliderImageInput.required = false; // Image not required when editing
                    imageHint.textContent = "Upload a new image to replace the existing one.";
                    sliderBadgeTextInput.value = badgeText; // Assign new field
                    sliderShowCountdownInput.checked = (showCountdown === '1'); // Assign new field
                    sliderCountdownDateInput.value = countdownDate; // Assign new field

                    if (image) {
                        imagePreviewContainer.innerHTML = `<img src="${image}" alt="Current Slider Image" />`;
                    } else {
                        imagePreviewContainer.innerHTML = "";
                    }

                    toggleCountdownDateGroup(); // Update visibility based on loaded data
                });
            });

            // Delete Slider functionality
            const deleteConfirmationModal = document.getElementById("deleteConfirmationModal");
            const confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
            const cancelDeleteBtn = document.getElementById("cancelDeleteBtn");
            const closeDeleteModal = document.getElementById("closeDeleteModal");
            let currentSliderToDelete = null;

            document.querySelectorAll(".delete-slider-btn").forEach(button => {
                button.addEventListener("click", function () {
                    currentSliderToDelete = this.dataset.id;
                    deleteConfirmationModal.style.display = "flex";
                    document.getElementById("deleteConfirmationMessage").textContent = "Are you sure you want to delete this slider? This action cannot be undone.";
                });
            });

            confirmDeleteBtn.addEventListener("click", function () {
                if (currentSliderToDelete) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = 'sliders.php'; // Or the current page
                    
                    const inputId = document.createElement('input');
                    inputId.type = 'hidden';
                    inputId.name = 'slider_id';
                    inputId.value = currentSliderToDelete;
                    form.appendChild(inputId);

                    const inputDelete = document.createElement('input');
                    inputDelete.type = 'hidden';
                    inputDelete.name = 'delete_slider';
                    inputDelete.value = '1';
                    form.appendChild(inputDelete);

                    document.body.appendChild(form);
                    form.submit();
                }
            });

            cancelDeleteBtn.addEventListener("click", function () {
                deleteConfirmationModal.style.display = "none";
                currentSliderToDelete = null;
            });

            closeDeleteModal.addEventListener("click", function () {
                deleteConfirmationModal.style.display = "none";
                currentSliderToDelete = null;
            });

            // Image input change for preview
            if (sliderImageInput) {
                sliderImageInput.addEventListener("change", function () {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            imagePreviewContainer.innerHTML = `<img src="${e.target.result}" alt="New Slider Image" />`;
                        };
                        reader.readAsDataURL(this.files[0]);
                    } else {
                        imagePreviewContainer.innerHTML = "";
                    }
                });
            }

            // Event listener for the checkbox to toggle countdown date input
            if (sliderShowCountdownInput) {
                sliderShowCountdownInput.addEventListener("change", toggleCountdownDateGroup);
            }

            // Initial call to set correct visibility on page load
            toggleCountdownDateGroup();
        });
    </script>
</body>
</html>