<?php
require_once 'config.php';

// Function to get all products
function getProducts($conn, $filter = 'all') {
    $query = "SELECT p.id, p.name, c.name as category, p.price, p.stock_quantity, 
              p.is_active, p.is_featured, p.image_url
              FROM products p
              LEFT JOIN categories c ON p.category_id = c.id";
    
    // Apply filters
    switch ($filter) {
        case 'featured':
            $query .= " WHERE p.is_featured = TRUE AND p.is_active = TRUE";
            break;
        case 'out-of-stock':
            $query .= " WHERE p.stock_quantity <= 0 AND p.is_active = TRUE";
            break;
        case 'low-stock':
            $query .= " WHERE p.stock_quantity > 0 AND p.stock_quantity <= 10 AND p.is_active = TRUE";
            break;
        case 'all':
        default:
            $query .= " WHERE p.is_active = TRUE";
            break;
    }
    
    $query .= " ORDER BY p.name";
    
    $result = mysqli_query($conn, $query);
    $products = array();
    
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
    
    return $products;
}

// Function to get all categories
function getCategories($conn) {
    $result = mysqli_query($conn, "SELECT id, name FROM categories ORDER BY name");
    $categories = array();
    
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
    
    return $categories;
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_product'])) {
        // Add new product
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $price = floatval($_POST['price']);
        $category_id = intval($_POST['category_id']);
        $stock_quantity = intval($_POST['stock_quantity']);
        $is_featured = isset($_POST['is_featured']) ? 1 : 0;
        
        $query = "INSERT INTO products (name, description, price, category_id, stock_quantity, is_featured)
                  VALUES ('$name', '$description', $price, $category_id, $stock_quantity, $is_featured)";
        
        if (mysqli_query($conn, $query)) {
            $success = "Product added successfully!";
        } else {
            $error = "Error adding product: " . mysqli_error($conn);
        }
    } elseif (isset($_POST['update_product'])) {
        // Update existing product
        $id = intval($_POST['product_id']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $price = floatval($_POST['price']);
        $category_id = intval($_POST['category_id']);
        $stock_quantity = intval($_POST['stock_quantity']);
        $is_featured = isset($_POST['is_featured']) ? 1 : 0;
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        
        $query = "UPDATE products SET 
                  name = '$name',
                  description = '$description',
                  price = $price,
                  category_id = $category_id,
                  stock_quantity = $stock_quantity,
                  is_featured = $is_featured,
                  is_active = $is_active
                  WHERE id = $id";
        
        if (mysqli_query($conn, $query)) {
            $success = "Product updated successfully!";
        } else {
            $error = "Error updating product: " . mysqli_error($conn);
        }
    } elseif (isset($_POST['delete_product'])) {
        // Delete product (soft delete)
        $id = intval($_POST['product_id']);
        
        $query = "UPDATE products SET is_active = FALSE WHERE id = $id";
        
        if (mysqli_query($conn, $query)) {
            $success = "Product deleted successfully!";
        } else {
            $error = "Error deleting product: " . mysqli_error($conn);
        }
    }
}

// Get current filter
$filter = $_GET['filter'] ?? 'all';
$products = getProducts($conn, $filter);
$categories = getCategories($conn);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Brand Bazaar - Product Management</title>
    <link rel="icon" type="image/x-icon" href="/icons/favicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="../admin/css/admin.css" />
    <style>
      /* Status badges */
      .badge {
        display: inline-block;
        padding: 0.25em 0.4em;
        font-size: 75%;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.25rem;
      }
      .badge-primary { color: #fff; background-color: #007bff; }
      .badge-success { color: #fff; background-color: #28a745; }
      .badge-warning { color: #212529; background-color: #ffc107; }
      .badge-danger { color: #fff; background-color: #dc3545; }
      
      /* Table styles */
      .admin-table {
        width: 100%;
        border-collapse: collapse;
      }
      .admin-table th, .admin-table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #dee2e6;
      }
      .admin-table th {
        background-color: #f8f9fa;
        font-weight: 600;
      }
      
      /* Form controls */
      .form-control {
        display: block;
        width: 100%;
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
      }
      
      /* Buttons */
      .btn {
        display: inline-block;
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        font-weight: 400;
        line-height: 1.5;
        text-align: center;
        text-decoration: none;
        white-space: nowrap;
        vertical-align: middle;
        border: 1px solid transparent;
        border-radius: 0.25rem;
        transition: all 0.15s ease-in-out;
      }
      .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
      }
      .btn-primary {
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
      }
      .btn-success {
        color: #fff;
        background-color: #28a745;
        border-color: #28a745;
      }
      .btn-danger {
        color: #fff;
        background-color: #dc3545;
        border-color: #dc3545;
      }
      .btn-primary:hover {
        background-color: #0069d9;
        border-color: #0062cc;
      }
      
      /* Pagination */
      .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
      }
      .pagination button {
        margin: 0 5px;
        padding: 5px 10px;
        border: 1px solid #dee2e6;
        background: #fff;
        cursor: pointer;
      }
      .pagination button.active {
        background: #007bff;
        color: #fff;
        border-color: #007bff;
      }
      .pagination button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
      }
      
      /* Tabs */
      .admin-tabs {
        display: flex;
        border-bottom: 1px solid #dee2e6;
        margin-bottom: 20px;
      }
      .admin-tab {
        padding: 10px 20px;
        cursor: pointer;
        border-bottom: 2px solid transparent;
      }
      .admin-tab.active {
        border-bottom-color: #007bff;
        color: #007bff;
        font-weight: 600;
      }
      .tab-content {
        display: none;
      }
      .tab-content.active {
        display: block;
      }
      
      /* Modal */
      .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.4);
      }
      .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 600px;
        border-radius: 5px;
      }
      .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
      }
      .close:hover {
        color: black;
      }
    </style>
  </head>
   <?php include 'navbar.php'; ?>

  <body class="admin-panel">
        <main class="admin-main">
    <!-- Products Section -->
    <section class="content-section">
      <h1>Product Management</h1>
      
      <?php if (isset($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
      <?php endif; ?>
      
      <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
      <?php endif; ?>

      <div class="admin-card">
        <div class="admin-card-header">
          <span>Product Management</span>
          <button class="btn btn-sm btn-success" onclick="document.getElementById('addProductModal').style.display='block'">
            <i class="fas fa-plus"></i> Add Product
          </button>
        </div>
        <div class="admin-card-body">
          <div class="admin-tabs">
            <div class="admin-tab <?php echo $filter == 'all' ? 'active' : ''; ?>" 
                 onclick="window.location.href='products.php?filter=all'">
              All Products
            </div>
            <div class="admin-tab <?php echo $filter == 'featured' ? 'active' : ''; ?>" 
                 onclick="window.location.href='products.php?filter=featured'">
              Featured
            </div>
            <div class="admin-tab <?php echo $filter == 'out-of-stock' ? 'active' : ''; ?>" 
                 onclick="window.location.href='products.php?filter=out-of-stock'">
              Out of Stock
            </div>
            <div class="admin-tab <?php echo $filter == 'low-stock' ? 'active' : ''; ?>" 
                 onclick="window.location.href='products.php?filter=low-stock'">
              Low Stock
            </div>
          </div>

          <div class="tab-content active">
            <div class="form-group">
              <form method="get" action="products.php">
                <input type="hidden" name="filter" value="<?php echo $filter; ?>">
                <input type="text" name="search" class="form-control" placeholder="Search products..." 
                       value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
              </form>
            </div>
            
            <?php if (empty($products)): ?>
              <p>No products found.</p>
            <?php else: ?>
              <table class="admin-table">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($products as $product): 
                    $status_class = 'badge-success';
                    $status_text = 'Active';
                    
                    if ($product['stock_quantity'] <= 0) {
                      $status_class = 'badge-danger';
                      $status_text = 'Out of Stock';
                    } elseif ($product['stock_quantity'] <= 10) {
                      $status_class = 'badge-warning';
                      $status_text = 'Low Stock';
                    }
                  ?>
                  <tr>
                    <td>PROD-<?php echo str_pad($product['id'], 3, '0', STR_PAD_LEFT); ?></td>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td><?php echo htmlspecialchars($product['category'] ?? 'Uncategorized'); ?></td>
                    <td>$<?php echo number_format($product['price'], 2); ?></td>
                    <td><?php echo $product['stock_quantity']; ?></td>
                    <td><span class="badge <?php echo $status_class; ?>"><?php echo $status_text; ?></span></td>
                    <td>
                      <button class="btn btn-sm btn-primary" 
                              onclick="openEditModal(<?php echo $product['id']; ?>)">
                        <i class="fas fa-edit"></i>
                      </button>
                      <form method="post" style="display:inline;">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <input type="hidden" name="delete_product" value="1">
                        <button type="submit" class="btn btn-sm btn-danger" 
                                onclick="return confirm('Are you sure you want to delete this product?')">
                          <i class="fas fa-trash"></i>
                        </button>
                      </form>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>

              <div class="pagination">
                <button disabled><i class="fas fa-chevron-left"></i></button>
                <button class="active">1</button>
                <button>2</button>
                <button>3</button>
                <button><i class="fas fa-chevron-right"></i></button>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>

    <!-- Add Product Modal -->
    <div id="addProductModal" class="modal">
      <div class="modal-content">
        <span class="close" onclick="document.getElementById('addProductModal').style.display='none'">&times;</span>
        <h2>Add New Product</h2>
        <form method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label>Product Name</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
          </div>
          <div class="form-group">
            <label>Price</label>
            <input type="number" step="0.01" name="price" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Category</label>
            <select name="category_id" class="form-control" required>
              <option value="">Select Category</option>
              <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Stock Quantity</label>
            <input type="number" name="stock_quantity" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Featured Product</label>
            <input type="checkbox" name="is_featured" value="1">
          </div>
          <div class="form-group">
            <label>Product Image</label>
            <input type="file" name="image" class="form-control">
          </div>
          <button type="submit" name="add_product" class="btn btn-primary">Add Product</button>
        </form>
      </div>
    </div>

    <!-- Edit Product Modal -->
    <div id="editProductModal" class="modal">
      <div class="modal-content">
        <span class="close" onclick="document.getElementById('editProductModal').style.display='none'">&times;</span>
        <h2>Edit Product</h2>
        <form method="post" id="editProductForm" enctype="multipart/form-data">
          <input type="hidden" name="product_id" id="editProductId">
          <input type="hidden" name="update_product" value="1">
          <div class="form-group">
            <label>Product Name</label>
            <input type="text" name="name" id="editProductName" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Description</label>
            <textarea name="description" id="editProductDescription" class="form-control" rows="3"></textarea>
          </div>
          <div class="form-group">
            <label>Price</label>
            <input type="number" step="0.01" name="price" id="editProductPrice" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Category</label>
            <select name="category_id" id="editProductCategory" class="form-control" required>
              <option value="">Select Category</option>
              <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Stock Quantity</label>
            <input type="number" name="stock_quantity" id="editProductStock" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Featured Product</label>
            <input type="checkbox" name="is_featured" id="editProductFeatured" value="1">
          </div>
          <div class="form-group">
            <label>Active Status</label>
            <input type="checkbox" name="is_active" id="editProductActive" value="1">
          </div>
          <div class="form-group">
            <label>Product Image</label>
            <input type="file" name="image" class="form-control">
            <div id="editProductImagePreview" style="margin-top:10px;"></div>
          </div>
          <button type="submit" class="btn btn-primary">Update Product</button>
        </form>
      </div>
    </div>
</main>
    <script>
      // Function to open edit modal and populate form
      function openEditModal(productId) {
        // In a real application, you would fetch the product data via AJAX
        // For this simple example, we'll just show the modal
        document.getElementById('editProductId').value = productId;
        document.getElementById('editProductModal').style.display = 'block';
      }
      
      // Close modals when clicking outside
      window.onclick = function(event) {
        if (event.target.className === 'modal') {
          event.target.style.display = 'none';
        }
      }
    </script>
  </body>
</html>
<?php
// Close database connection
mysqli_close($conn);
?>