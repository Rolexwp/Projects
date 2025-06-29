<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Brand Bazaar - Admin Panel</title>
    <link rel="icon" type="image/x-icon" href="/icons/favicon.ico" />
    <link rel="stylesheet" href="css/admin.css">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />
    
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
      <!-- Dashboard Section -->
      <section class="content-section" id="dashboard-section">
        <h1>Dashboard</h1>

        <!-- Stats Cards -->
        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-icon">
              <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-info">
              <h3 id="totalOrders">1,245</h3>
              <p>Total Orders</p>
              <small class="text-success">+12% from last month</small>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-icon">
              <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-info">
              <h3 id="totalRevenue">$34,567</h3>
              <p>Total Revenue</p>
              <small class="text-success">+8% from last month</small>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-icon">
              <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
              <h3 id="totalCustomers">2,345</h3>
              <p>Total Customers</p>
              <small class="text-success">+5.2% from last month</small>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-icon">
              <i class="fas fa-box-open"></i>
            </div>
            <div class="stat-info">
              <h3 id="totalProducts">567</h3>
              <p>Total Products</p>
              <small class="text-danger">3 out of stock</small>
            </div>
          </div>
        </div>

        <!-- Charts -->
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
                <tr>
                  <td>#ORD-2025-001</td>
                  <td>John Doe</td>
                  <td>Jun 20, 2025</td>
                  <td>$245.99</td>
                  <td><span class="badge badge-success">Completed</span></td>
                  <td>
                    <button
                      class="btn btn-sm btn-primary view-order-btn"
                      data-order-id="ORD-2025-001"
                    >
                      <i class="fas fa-eye"></i> View
                    </button>
                  </td>
                </tr>
                <tr>
                  <td>#ORD-2025-002</td>
                  <td>Jane Smith</td>
                  <td>Jun 19, 2025</td>
                  <td>$189.50</td>
                  <td><span class="badge badge-primary">Processing</span></td>
                  <td>
                    <button
                      class="btn btn-sm btn-primary view-order-btn"
                      data-order-id="ORD-2025-002"
                    >
                      <i class="fas fa-eye"></i> View
                    </button>
                  </td>
                </tr>
                <tr>
                  <td>#ORD-2025-003</td>
                  <td>Robert Johnson</td>
                  <td>Jun 18, 2025</td>
                  <td>$567.25</td>
                  <td><span class="badge badge-warning">Pending</span></td>
                  <td>
                    <button
                      class="btn btn-sm btn-primary view-order-btn"
                      data-order-id="ORD-2025-003"
                    >
                      <i class="fas fa-eye"></i> View
                    </button>
                  </td>
                </tr>
                <tr>
                  <td>#ORD-2025-004</td>
                  <td>Emily Davis</td>
                  <td>Jun 17, 2025</td>
                  <td>$98.75</td>
                  <td><span class="badge badge-danger">Cancelled</span></td>
                  <td>
                    <button
                      class="btn btn-sm btn-primary view-order-btn"
                      data-order-id="ORD-2025-004"
                    >
                      <i class="fas fa-eye"></i> View
                    </button>
                  </td>
                </tr>
                <tr>
                  <td>#ORD-2025-005</td>
                  <td>Michael Brown</td>
                  <td>Jun 16, 2025</td>
                  <td>$324.50</td>
                  <td><span class="badge badge-success">Completed</span></td>
                  <td>
                    <button
                      class="btn btn-sm btn-primary view-order-btn"
                      data-order-id="ORD-2025-005"
                    >
                      <i class="fas fa-eye"></i> View
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <!-- Products Section -->
      <section
        class="content-section"
        id="products-section"
        style="display: none"
      >
        <!-- All Products Tab -->
        <div id="all-products-content">
          <div class="admin-card">
            <div class="admin-card-header">
              <span>Product Management</span>
              <button class="btn btn-sm btn-success" id="showAddProductForm">
                <i class="fas fa-plus"></i> Add Product
              </button>
            </div>
            <div class="admin-card-body">
              <div class="admin-tabs">
                <div class="admin-tab active" data-tab="all-products">
                  All Products
                </div>
                <div class="admin-tab" data-tab="featured-products">
                  Featured
                </div>
                <div class="admin-tab" data-tab="out-of-stock">
                  Out of Stock
                </div>
                <div class="admin-tab" data-tab="low-stock">Low Stock</div>
              </div>

              <div class="tab-content active" id="all-products-tab">
                <div class="form-group">
                  <input
                    type="text"
                    class="form-control"
                    id="productSearch"
                    placeholder="Search products..."
                  />
                </div>
                <table class="admin-table" id="productsTable">
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
                    <tr>
                      <td>PROD-001</td>
                      <td>Flagship Ultrabook 2025</td>
                      <td>Laptops</td>
                      <td>$1,399.00</td>
                      <td>45</td>
                      <td><span class="badge badge-success">Active</span></td>
                      <td>
                        <button
                          class="btn btn-sm btn-primary edit-product-btn"
                          data-product-id="PROD-001"
                        >
                          <i class="fas fa-edit"></i>
                        </button>
                        <button
                          class="btn btn-sm btn-danger delete-product-btn"
                          data-product-id="PROD-001"
                        >
                          <i class="fas fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                    <tr>
                      <td>PROD-002</td>
                      <td>Smartphone Z Pro</td>
                      <td>Mobiles</td>
                      <td>$899.00</td>
                      <td>78</td>
                      <td><span class="badge badge-success">Active</span></td>
                      <td>
                        <button
                          class="btn btn-sm btn-primary edit-product-btn"
                          data-product-id="PROD-002"
                        >
                          <i class="fas fa-edit"></i>
                        </button>
                        <button
                          class="btn btn-sm btn-danger delete-product-btn"
                          data-product-id="PROD-002"
                        >
                          <i class="fas fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                    <tr>
                      <td>PROD-003</td>
                      <td>Wireless Earbuds 2</td>
                      <td>Audio</td>
                      <td>$199.00</td>
                      <td>0</td>
                      <td>
                        <span class="badge badge-danger">Out of Stock</span>
                      </td>
                      <td>
                        <button
                          class="btn btn-sm btn-primary edit-product-btn"
                          data-product-id="PROD-003"
                        >
                          <i class="fas fa-edit"></i>
                        </button>
                        <button
                          class="btn btn-sm btn-danger delete-product-btn"
                          data-product-id="PROD-003"
                        >
                          <i class="fas fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                    <tr>
                      <td>PROD-004</td>
                      <td>Smart Watch Pro</td>
                      <td>Wearables</td>
                      <td>$349.99</td>
                      <td>22</td>
                      <td><span class="badge badge-success">Active</span></td>
                      <td>
                        <button
                          class="btn btn-sm btn-primary edit-product-btn"
                          data-product-id="PROD-004"
                        >
                          <i class="fas fa-edit"></i>
                        </button>
                        <button
                          class="btn btn-sm btn-danger delete-product-btn"
                          data-product-id="PROD-004"
                        >
                          <i class="fas fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                    <tr>
                      <td>PROD-005</td>
                      <td>Gaming Console X</td>
                      <td>Gaming</td>
                      <td>$499.99</td>
                      <td>5</td>
                      <td>
                        <span class="badge badge-warning">Low Stock</span>
                      </td>
                      <td>
                        <button
                          class="btn btn-sm btn-primary edit-product-btn"
                          data-product-id="PROD-005"
                        >
                          <i class="fas fa-edit"></i>
                        </button>
                        <button
                          class="btn btn-sm btn-danger delete-product-btn"
                          data-product-id="PROD-005"
                        >
                          <i class="fas fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>

                <div class="pagination">
                  <button disabled><i class="fas fa-chevron-left"></i></button>
                  <button class="active">1</button>
                  <button>2</button>
                  <button>3</button>
                  <button><i class="fas fa-chevron-right"></i></button>
                </div>
              </div>

              <div class="tab-content" id="featured-products-tab">
                <p>Featured products will appear here.</p>
              </div>

              <div class="tab-content" id="out-of-stock-tab">
                <p>Out of stock products will appear here.</p>
              </div>

              <div class="tab-content" id="low-stock-tab">
                <p>Low stock products will appear here.</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Add/Edit Product Form -->
        <div class="admin-card" id="productFormContainer" style="display: none">
          <div class="admin-card-header">
            <span id="productFormTitle">Add New Product</span>
          </div>
          <div class="admin-card-body">
            <form id="productForm">
              <input type="hidden" id="productId" value="" />
              <div class="form-group">
                <label class="form-label">Product Name</label>
                <input
                  type="text"
                  class="form-control"
                  id="productName"
                  required
                />
              </div>

              <div class="form-group">
                <label class="form-label">Description</label>
                <textarea
                  class="form-control"
                  id="productDescription"
                  rows="4"
                  required
                ></textarea>
              </div>

              <div class="form-row">
                <div class="form-group">
                  <label class="form-label">Price ($)</label>
                  <input
                    type="number"
                    class="form-control"
                    id="productPrice"
                    step="0.01"
                    required
                  />
                </div>
                <div class="form-group">
                  <label class="form-label">Stock Quantity</label>
                  <input
                    type="number"
                    class="form-control"
                    id="productStock"
                    required
                  />
                </div>
                <div class="form-group">
                  <label class="form-label">Category</label>
                  <select class="form-control" id="productCategory" required>
                    <option value="">Select Category</option>
                    <option value="laptops">Laptops</option>
                    <option value="mobiles">Mobiles</option>
                    <option value="audio">Audio</option>
                    <option value="gadgets">Gadgets</option>
                    <option value="fashion">Fashion</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="form-label">Product Images</label>
                <div
                  style="
                    border: 1px dashed var(--admin-border);
                    padding: 15px;
                    border-radius: 4px;
                    background: rgba(0, 0, 0, 0.02);
                  "
                >
                  <input
                    type="file"
                    class="form-control"
                    id="productImages"
                    multiple
                    accept="image/*"
                  />
                </div>
                <small class="text-muted"
                  >Upload multiple images (first image will be main)</small
                >
                <div id="productImagesPreview" class="mt-2"></div>
              </div>

              <div class="form-group">
                <label class="form-label">Featured</label>
                <div>
                  <input type="checkbox" id="featured" />
                  <label for="featured">Mark as featured product</label>
                </div>
              </div>

              <div class="form-group">
                <button
                  type="submit"
                  class="btn btn-success"
                  id="saveProductBtn"
                >
                  <i class="fas fa-save"></i> Save Product
                </button>
                <button
                  type="button"
                  class="btn btn-danger"
                  id="cancelProductForm"
                >
                  <i class="fas fa-times"></i> Cancel
                </button>
              </div>
            </form>
          </div>
        </div>
      </section>

      <!-- Orders Section -->
      <section
        class="content-section"
        id="orders-section"
        style="display: none"
      >
        <h1>Orders Management</h1>
        <div class="admin-card">
          <div class="admin-card-header">
            <span>All Orders</span>
            <div class="order-filters">
              <select
                id="orderStatusFilter"
                class="form-control"
                style="width: auto; display: inline-block"
              >
                <option value="all">All Statuses</option>
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
              </select>
              <input
                type="date"
                id="orderDateFilter"
                class="form-control"
                style="width: auto; display: inline-block"
              />
            </div>
          </div>
          <div class="admin-card-body">
            <table class="admin-table" id="ordersTable">
              <thead>
                <tr>
                  <th>Order ID</th>
                  <th>Customer</th>
                  <th>Date</th>
                  <th>Amount</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>#ORD-2025-001</td>
                  <td>John Doe</td>
                  <td>Jun 20, 2025</td>
                  <td>$245.99</td>
                  <td><span class="badge badge-success">Completed</span></td>
                  <td>
                    <button
                      class="btn btn-sm btn-primary view-order-btn"
                      data-order-id="ORD-2025-001"
                    >
                      <i class="fas fa-eye"></i> View
                    </button>
                  </td>
                </tr>
                <tr>
                  <td>#ORD-2025-002</td>
                  <td>Jane Smith</td>
                  <td>Jun 19, 2025</td>
                  <td>$189.50</td>
                  <td><span class="badge badge-primary">Processing</span></td>
                  <td>
                    <button
                      class="btn btn-sm btn-primary view-order-btn"
                      data-order-id="ORD-2025-002"
                    >
                      <i class="fas fa-eye"></i> View
                    </button>
                  </td>
                </tr>
                <tr>
                  <td>#ORD-2025-003</td>
                  <td>Robert Johnson</td>
                  <td>Jun 18, 2025</td>
                  <td>$567.25</td>
                  <td><span class="badge badge-warning">Pending</span></td>
                  <td>
                    <button
                      class="btn btn-sm btn-primary view-order-btn"
                      data-order-id="ORD-2025-003"
                    >
                      <i class="fas fa-eye"></i> View
                    </button>
                  </td>
                </tr>
                <tr>
                  <td>#ORD-2025-004</td>
                  <td>Emily Davis</td>
                  <td>Jun 17, 2025</td>
                  <td>$98.75</td>
                  <td><span class="badge badge-danger">Cancelled</span></td>
                  <td>
                    <button
                      class="btn btn-sm btn-primary view-order-btn"
                      data-order-id="ORD-2025-004"
                    >
                      <i class="fas fa-eye"></i> View
                    </button>
                  </td>
                </tr>
                <tr>
                  <td>#ORD-2025-005</td>
                  <td>Michael Brown</td>
                  <td>Jun 16, 2025</td>
                  <td>$324.50</td>
                  <td><span class="badge badge-success">Completed</span></td>
                  <td>
                    <button
                      class="btn btn-sm btn-primary view-order-btn"
                      data-order-id="ORD-2025-005"
                    >
                      <i class="fas fa-eye"></i> View
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>

            <div class="pagination">
              <button disabled><i class="fas fa-chevron-left"></i></button>
              <button class="active">1</button>
              <button>2</button>
              <button>3</button>
              <button><i class="fas fa-chevron-right"></i></button>
            </div>
          </div>
        </div>
      </section>

      <!-- Customers Section -->
      <section
        class="content-section"
        id="customers-section"
        style="display: none"
      >
        <h1>Customers Management</h1>
        <div class="admin-card">
          <div class="admin-card-header">
            <span>All Customers</span>
            <div class="customer-filters">
              <input
                type="text"
                id="customerSearch"
                class="form-control"
                placeholder="Search customers..."
                style="width: auto; display: inline-block"
              />
            </div>
          </div>
          <div class="admin-card-body">
            <table class="admin-table" id="customersTable">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Join Date</th>
                  <th>Orders</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>CUST-001</td>
                  <td>John Doe</td>
                  <td>john.doe@example.com</td>
                  <td>(123) 456-7890</td>
                  <td>May 15, 2025</td>
                  <td>12</td>
                  <td>
                    <button
                      class="btn btn-sm btn-primary view-customer-btn"
                      data-customer-id="CUST-001"
                    >
                      <i class="fas fa-eye"></i> View
                    </button>
                  </td>
                </tr>
                <tr>
                  <td>CUST-002</td>
                  <td>Jane Smith</td>
                  <td>jane.smith@example.com</td>
                  <td>(234) 567-8901</td>
                  <td>Apr 22, 2025</td>
                  <td>8</td>
                  <td>
                    <button
                      class="btn btn-sm btn-primary view-customer-btn"
                      data-customer-id="CUST-002"
                    >
                      <i class="fas fa-eye"></i> View
                    </button>
                  </td>
                </tr>
                <tr>
                  <td>CUST-003</td>
                  <td>Robert Johnson</td>
                  <td>robert.j@example.com</td>
                  <td>(345) 678-9012</td>
                  <td>Jun 5, 2025</td>
                  <td>3</td>
                  <td>
                    <button
                      class="btn btn-sm btn-primary view-customer-btn"
                      data-customer-id="CUST-003"
                    >
                      <i class="fas fa-eye"></i> View
                    </button>
                  </td>
                </tr>
                <tr>
                  <td>CUST-004</td>
                  <td>Emily Davis</td>
                  <td>emily.d@example.com</td>
                  <td>(456) 789-0123</td>
                  <td>Mar 18, 2025</td>
                  <td>15</td>
                  <td>
                    <button
                      class="btn btn-sm btn-primary view-customer-btn"
                      data-customer-id="CUST-004"
                    >
                      <i class="fas fa-eye"></i> View
                    </button>
                  </td>
                </tr>
                <tr>
                  <td>CUST-005</td>
                  <td>Michael Brown</td>
                  <td>michael.b@example.com</td>
                  <td>(567) 890-1234</td>
                  <td>Feb 10, 2025</td>
                  <td>22</td>
                  <td>
                    <button
                      class="btn btn-sm btn-primary view-customer-btn"
                      data-customer-id="CUST-005"
                    >
                      <i class="fas fa-eye"></i> View
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>

            <div class="pagination">
              <button disabled><i class="fas fa-chevron-left"></i></button>
              <button class="active">1</button>
              <button>2</button>
              <button>3</button>
              <button><i class="fas fa-chevron-right"></i></button>
            </div>
          </div>
        </div>
      </section>
    </main>

    <!-- Order Detail Modal -->
    <div class="modal" id="orderDetailModal">
      <div class="modal-content">
        <div class="modal-header">
          <h3>Order Details - <span id="modalOrderId"></span></h3>
          <button class="close-modal" id="closeOrderModal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="order-info">
            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Customer Name</label>
                <p id="modalCustomerName"></p>
              </div>
              <div class="form-group">
                <label class="form-label">Order Date</label>
                <p id="modalOrderDate"></p>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Email</label>
                <p id="modalCustomerEmail"></p>
              </div>
              <div class="form-group">
                <label class="form-label">Phone</label>
                <p id="modalCustomerPhone"></p>
              </div>
            </div>
            <div class="form-group">
              <label class="form-label">Shipping Address</label>
              <p id="modalShippingAddress"></p>
            </div>
            <div class="form-group">
              <label class="form-label">Order Status</label>
              <select class="form-control" id="modalOrderStatus">
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
              </select>
            </div>
          </div>

          <div class="order-items">
            <h4>Order Items</h4>
            <table class="admin-table">
              <thead>
                <tr>
                  <th>Product</th>
                  <th>Price</th>
                  <th>Quantity</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody id="modalOrderItems">
                <!-- Order items will be populated here -->
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="3" class="text-right">
                    <strong>Subtotal:</strong>
                  </td>
                  <td id="modalSubtotal"></td>
                </tr>
                <tr>
                  <td colspan="3" class="text-right">
                    <strong>Shipping:</strong>
                  </td>
                  <td id="modalShipping"></td>
                </tr>
                <tr>
                  <td colspan="3" class="text-right"><strong>Tax:</strong></td>
                  <td id="modalTax"></td>
                </tr>
                <tr>
                  <td colspan="3" class="text-right">
                    <strong>Total:</strong>
                  </td>
                  <td id="modalTotal"></td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" id="saveOrderChanges">
            Save Changes
          </button>
          <button class="btn btn-danger" id="cancelOrderChanges">Cancel</button>
        </div>
      </div>
    </div>

    <!-- Customer Detail Modal -->
    <div class="modal" id="customerDetailModal">
      <div class="modal-content">
        <div class="modal-header">
          <h3>Customer Details - <span id="modalCustomerId"></span></h3>
          <button class="close-modal" id="closeCustomerModal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="customer-info">
            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Full Name</label>
                <p id="modalCustomerFullName"></p>
              </div>
              <div class="form-group">
                <label class="form-label">Join Date</label>
                <p id="modalCustomerJoinDate"></p>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Email</label>
                <p id="modalCustomerDetailEmail"></p>
              </div>
              <div class="form-group">
                <label class="form-label">Phone</label>
                <p id="modalCustomerDetailPhone"></p>
              </div>
            </div>
            <div class="form-group">
              <label class="form-label">Address</label>
              <p id="modalCustomerAddress"></p>
            </div>
          </div>

          <div class="customer-stats">
            <h4>Customer Statistics</h4>
            <div class="stats-grid">
              <div class="stat-card">
                <div class="stat-icon">
                  <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-info">
                  <h3 id="modalCustomerTotalOrders">0</h3>
                  <p>Total Orders</p>
                </div>
              </div>
              <div class="stat-card">
                <div class="stat-icon">
                  <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-info">
                  <h3 id="modalCustomerTotalSpent">$0</h3>
                  <p>Total Spent</p>
                </div>
              </div>
              <div class="stat-card">
                <div class="stat-icon">
                  <i class="fas fa-star"></i>
                </div>
                <div class="stat-info">
                  <h3 id="modalCustomerAvgRating">0.0</h3>
                  <p>Average Rating</p>
                </div>
              </div>
            </div>
          </div>

          <div class="customer-orders">
            <h4>Recent Orders</h4>
            <table class="admin-table">
              <thead>
                <tr>
                  <th>Order ID</th>
                  <th>Date</th>
                  <th>Amount</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody id="modalCustomerOrders">
                <!-- Customer orders will be populated here -->
              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" id="saveCustomerChanges">
            Save Changes
          </button>
          <button class="btn btn-danger" id="cancelCustomerChanges">
            Cancel
          </button>
        </div>
      </div>
    </div>

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

    <script>
      // Sample data for demonstration
      const sampleData = {
        orders: [
          {
            id: "ORD-2025-001",
            customer: "John Doe",
            date: "Jun 20, 2025",
            amount: 245.99,
            status: "completed",
            email: "john.doe@example.com",
            phone: "(123) 456-7890",
            address: "123 Main St, Apt 4B, New York, NY 10001",
            items: [
              {
                name: "Smartphone Z Pro",
                price: 899.0,
                quantity: 1,
                total: 899.0,
              },
              {
                name: "Wireless Earbuds 2",
                price: 199.0,
                quantity: 2,
                total: 398.0,
              },
            ],
            subtotal: 1297.0,
            shipping: 0.0,
            tax: 129.7,
            total: 1426.7,
          },
          {
            id: "ORD-2025-002",
            customer: "Jane Smith",
            date: "Jun 19, 2025",
            amount: 189.5,
            status: "processing",
            email: "jane.smith@example.com",
            phone: "(234) 567-8901",
            address: "456 Oak Ave, Los Angeles, CA 90001",
            items: [
              {
                name: "Smart Watch Pro",
                price: 349.99,
                quantity: 1,
                total: 349.99,
              },
            ],
            subtotal: 349.99,
            shipping: 10.0,
            tax: 35.0,
            total: 394.99,
          },
        ],
        customers: [
          {
            id: "CUST-001",
            name: "John Doe",
            email: "john.doe@example.com",
            phone: "(123) 456-7890",
            joinDate: "May 15, 2025",
            address: "123 Main St, Apt 4B, New York, NY 10001",
            totalOrders: 12,
            totalSpent: 3456.78,
            avgRating: 4.5,
            recentOrders: [
              {
                id: "ORD-2025-001",
                date: "Jun 20, 2025",
                amount: 245.99,
                status: "completed",
              },
              {
                id: "ORD-2024-105",
                date: "May 28, 2025",
                amount: 189.5,
                status: "completed",
              },
            ],
          },
          {
            id: "CUST-002",
            name: "Jane Smith",
            email: "jane.smith@example.com",
            phone: "(234) 567-8901",
            joinDate: "Apr 22, 2025",
            address: "456 Oak Ave, Los Angeles, CA 90001",
            totalOrders: 8,
            totalSpent: 1895.3,
            avgRating: 4.2,
            recentOrders: [
              {
                id: "ORD-2025-002",
                date: "Jun 19, 2025",
                amount: 189.5,
                status: "processing",
              },
              {
                id: "ORD-2024-098",
                date: "Apr 15, 2025",
                amount: 345.0,
                status: "completed",
              },
            ],
          },
        ],
        products: [
          {
            id: "PROD-001",
            name: "Flagship Ultrabook 2025",
            description:
              "Latest ultrabook with powerful processor and long battery life",
            category: "laptops",
            price: 1399.0,
            stock: 45,
            status: "active",
            featured: true,
            images: [],
          },
          {
            id: "PROD-002",
            name: "Smartphone Z Pro",
            description: "Premium smartphone with advanced camera system",
            category: "mobiles",
            price: 899.0,
            stock: 78,
            status: "active",
            featured: false,
            images: [],
          },
        ],
      };

      document.addEventListener("DOMContentLoaded", function () {
        // Toggle sidebar on mobile
        const menuToggle = document.getElementById("menuToggle");
        const sidebar = document.querySelector(".admin-sidebar");

        menuToggle.addEventListener("click", function () {
          sidebar.classList.toggle("show");
        });

        // Toggle submenus
        const productsMenu = document.getElementById("productsMenu");
        const productsSubmenu = document.getElementById("productsSubmenu");
        const contentMenu = document.getElementById("contentMenu");
        const contentSubmenu = document.getElementById("contentSubmenu");
        const productArrows = document.querySelectorAll(
          "#productsMenu .menu-arrow"
        );
        const contentArrows = document.querySelectorAll(
          "#contentMenu .menu-arrow"
        );

        productsMenu.addEventListener("click", function (e) {
          e.preventDefault();
          productsSubmenu.classList.toggle("show");
          productArrows.forEach((arrow) => arrow.classList.toggle("rotated"));
        });

        contentMenu.addEventListener("click", function (e) {
          e.preventDefault();
          contentSubmenu.classList.toggle("show");
          contentArrows.forEach((arrow) => arrow.classList.toggle("rotated"));
        });

        // Tab functionality
        const tabs = document.querySelectorAll(".admin-tab");
        tabs.forEach((tab) => {
          tab.addEventListener("click", function () {
            // Remove active class from all tabs and contents
            document
              .querySelectorAll(".admin-tab")
              .forEach((t) => t.classList.remove("active"));
            document
              .querySelectorAll(".tab-content")
              .forEach((c) => c.classList.remove("active"));

            // Add active class to clicked tab and corresponding content
            this.classList.add("active");
            const tabId = this.getAttribute("data-tab");
            document.getElementById(tabId + "-tab").classList.add("active");
          });
        });

        // Toggle user dropdown
        const userDropdownToggle =
          document.getElementById("userDropdownToggle");
        const userDropdown = document.querySelector(".user-dropdown");

        userDropdownToggle.addEventListener("click", function () {
          userDropdown.classList.toggle("show");
        });

        // Toggle notifications dropdown
        const notificationIcon = document.querySelector(".notification-icon");
        const notificationDropdown = document.querySelector(
          ".notification-dropdown"
        );

        notificationIcon.addEventListener("click", function () {
          notificationDropdown.classList.toggle("show");
        });

        // Dark mode toggle
        const darkModeToggle = document.getElementById("darkModeToggle");

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

        // Check for saved dark mode preference
        if (localStorage.getItem("darkMode") === "true") {
          document.body.classList.add("dark-mode");
          darkModeToggle.querySelector("i").classList.remove("fa-moon");
          darkModeToggle.querySelector("i").classList.add("fa-sun");
        }

        // Close dropdowns when clicking outside
        document.addEventListener("click", function (e) {
          if (!userDropdownToggle.contains(e.target)) {
            userDropdown.classList.remove("show");
          }

          if (!notificationIcon.contains(e.target)) {
            notificationDropdown.classList.remove("show");
          }

          // Close sidebar when clicking outside on mobile
          if (window.innerWidth < 992 && !sidebar.contains(e.target)) {
            if (!menuToggle.contains(e.target)) {
              sidebar.classList.remove("show");
            }
          }
        });

        // Add active state to menu items
        const menuItems = document.querySelectorAll(".admin-menu li a");
        menuItems.forEach((item) => {
          item.addEventListener("click", function (e) {
            if (!this.querySelector(".menu-arrow")) {
              // Remove active class from all items
              menuItems.forEach((i) => i.classList.remove("active"));

              // Add active class to clicked item
              this.classList.add("active");
            }
          });
        });

        // Add active state to submenu items
        const submenuItems = document.querySelectorAll(".admin-submenu li a");
        submenuItems.forEach((item) => {
          item.addEventListener("click", function (e) {
            // Remove active class from all items
            submenuItems.forEach((i) => i.classList.remove("active"));

            // Add active class to clicked item
            this.classList.add("active");
          });
        });

        // Section navigation
        const contentSections = document.querySelectorAll(".content-section");

        function showSection(sectionId) {
          contentSections.forEach((section) => {
            section.style.display = "none";
          });

          const activeSection = document.getElementById(sectionId + "-section");
          if (activeSection) {
            activeSection.style.display = "block";
          }
        }

        // Set dashboard as default
        showSection("dashboard");

        // Handle menu clicks
        const menuLinks = document.querySelectorAll(
          ".admin-menu a[data-section], .admin-submenu a[data-subsection]"
        );
        menuLinks.forEach((link) => {
          link.addEventListener("click", function (e) {
            e.preventDefault();

            const section =
              this.getAttribute("data-section") ||
              this.getAttribute("data-subsection");
            if (section) {
              showSection(section);

              // Handle product form visibility
              if (section === "add-product") {
                document.getElementById("all-products-content").style.display =
                  "none";
                document.getElementById("productFormContainer").style.display =
                  "block";
                document.getElementById("productFormTitle").textContent =
                  "Add New Product";
                document.getElementById("productId").value = "";
                document.getElementById("productForm").reset();
                document.getElementById("productImagesPreview").innerHTML = "";
              } else if (section === "all-products") {
                document.getElementById("all-products-content").style.display =
                  "block";
                document.getElementById("productFormContainer").style.display =
                  "none";
              } else {
                document.getElementById("all-products-content").style.display =
                  "block";
                document.getElementById("productFormContainer").style.display =
                  "none";
              }
            }
          });
        });

        // Product form handling
        const productForm = document.getElementById("productForm");
        const showAddProductForm =
          document.getElementById("showAddProductForm");
        const cancelProductForm = document.getElementById("cancelProductForm");
        const productFormContainer = document.getElementById(
          "productFormContainer"
        );
        const allProductsContent = document.getElementById(
          "all-products-content"
        );

        if (showAddProductForm) {
          showAddProductForm.addEventListener("click", function () {
            allProductsContent.style.display = "none";
            productFormContainer.style.display = "block";
            document.getElementById("productFormTitle").textContent =
              "Add New Product";
            document.getElementById("productId").value = "";
            document.getElementById("productForm").reset();
            document.getElementById("productImagesPreview").innerHTML = "";
          });
        }

        if (cancelProductForm) {
          cancelProductForm.addEventListener("click", function () {
            productFormContainer.style.display = "none";
            allProductsContent.style.display = "block";
          });
        }

        if (productForm) {
          productForm.addEventListener("submit", function (e) {
            e.preventDefault();

            // Get form data
            const productId = document.getElementById("productId").value;
            const isEdit = productId !== "";

            // In a real app, you would send this data to the server
            const productData = {
              id: isEdit
                ? productId
                : "PROD-" + Math.floor(1000 + Math.random() * 9000),
              name: document.getElementById("productName").value,
              description: document.getElementById("productDescription").value,
              price: parseFloat(document.getElementById("productPrice").value),
              stock: parseInt(document.getElementById("productStock").value),
              category: document.getElementById("productCategory").value,
              featured: document.getElementById("featured").checked,
              status: "active",
            };

            // Simulate API call
            setTimeout(() => {
              // Show success message
              alert(`Product ${isEdit ? "updated" : "added"} successfully!`);

              // Reset form
              if (!isEdit) {
                productForm.reset();
                document.getElementById("productImagesPreview").innerHTML = "";
              }

              // Hide form and show product list
              productFormContainer.style.display = "none";
              allProductsContent.style.display = "block";

              // In a real app, you would refresh the product list from the server
            }, 1000);
          });
        }

        // Edit product buttons
        const editProductButtons =
          document.querySelectorAll(".edit-product-btn");
        editProductButtons.forEach((button) => {
          button.addEventListener("click", function () {
            const productId = this.getAttribute("data-product-id");

            // In a real app, you would fetch the product data from the server
            const product = sampleData.products.find(
              (p) => p.id === productId
            ) || {
              id: productId,
              name: "Sample Product",
              description: "Sample description",
              price: 99.99,
              stock: 10,
              category: "laptops",
              featured: false,
            };

            // Populate form
            document.getElementById("productId").value = product.id;
            document.getElementById("productName").value = product.name;
            document.getElementById("productDescription").value =
              product.description;
            document.getElementById("productPrice").value = product.price;
            document.getElementById("productStock").value = product.stock;
            document.getElementById("productCategory").value = product.category;
            document.getElementById("featured").checked = product.featured;
            document.getElementById("productFormTitle").textContent =
              "Edit Product";

            // Show form
            allProductsContent.style.display = "none";
            productFormContainer.style.display = "block";
          });
        });

        // Delete product buttons
        const deleteProductButtons = document.querySelectorAll(
          ".delete-product-btn"
        );
        const deleteConfirmationModal = document.getElementById(
          "deleteConfirmationModal"
        );
        const confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
        const cancelDeleteBtn = document.getElementById("cancelDeleteBtn");
        const closeDeleteModal = document.getElementById("closeDeleteModal");
        let currentDeleteItem = null;

        deleteProductButtons.forEach((button) => {
          button.addEventListener("click", function () {
            const productId = this.getAttribute("data-product-id");
            currentDeleteItem = {
              type: "product",
              id: productId,
            };

            document.getElementById(
              "deleteConfirmationMessage"
            ).textContent = `Are you sure you want to delete product ${productId}? This action cannot be undone.`;

            deleteConfirmationModal.style.display = "flex";
          });
        });

        // Delete confirmation
        confirmDeleteBtn.addEventListener("click", function () {
          if (currentDeleteItem) {
            // In a real app, you would send a delete request to the server
            setTimeout(() => {
              alert(
                `${currentDeleteItem.type} ${currentDeleteItem.id} deleted successfully!`
              );
              deleteConfirmationModal.style.display = "none";

              // In a real app, you would refresh the list from the server
            }, 1000);
          }
        });

        // Cancel delete
        cancelDeleteBtn.addEventListener("click", function () {
          deleteConfirmationModal.style.display = "none";
        });

        closeDeleteModal.addEventListener("click", function () {
          deleteConfirmationModal.style.display = "none";
        });

        // Order detail modals
        const viewOrderButtons = document.querySelectorAll(".view-order-btn");
        const orderDetailModal = document.getElementById("orderDetailModal");
        const closeOrderModal = document.getElementById("closeOrderModal");
        const saveOrderChanges = document.getElementById("saveOrderChanges");
        const cancelOrderChanges =
          document.getElementById("cancelOrderChanges");

        viewOrderButtons.forEach((button) => {
          button.addEventListener("click", function () {
            const orderId = this.getAttribute("data-order-id");

            // In a real app, you would fetch the order details from the server
            const order = sampleData.orders.find((o) => o.id === orderId) || {
              id: orderId,
              customer: "Sample Customer",
              date: new Date().toLocaleDateString(),
              amount: 99.99,
              status: "pending",
              email: "customer@example.com",
              phone: "(000) 000-0000",
              address: "123 Sample St, City, Country",
              items: [
                {
                  name: "Sample Product",
                  price: 99.99,
                  quantity: 1,
                  total: 99.99,
                },
              ],
              subtotal: 99.99,
              shipping: 0.0,
              tax: 9.99,
              total: 109.98,
            };

            // Populate modal
            document.getElementById("modalOrderId").textContent = order.id;
            document.getElementById("modalCustomerName").textContent =
              order.customer;
            document.getElementById("modalOrderDate").textContent = order.date;
            document.getElementById("modalCustomerEmail").textContent =
              order.email;
            document.getElementById("modalCustomerPhone").textContent =
              order.phone;
            document.getElementById("modalShippingAddress").textContent =
              order.address;
            document.getElementById("modalOrderStatus").value = order.status;

            // Populate order items
            const orderItemsContainer =
              document.getElementById("modalOrderItems");
            orderItemsContainer.innerHTML = "";

            order.items.forEach((item) => {
              const row = document.createElement("tr");
              row.innerHTML = `
                <td>${item.name}</td>
                <td>$${item.price.toFixed(2)}</td>
                <td>${item.quantity}</td>
                <td>$${item.total.toFixed(2)}</td>
              `;
              orderItemsContainer.appendChild(row);
            });

            // Set totals
            document.getElementById(
              "modalSubtotal"
            ).textContent = `$${order.subtotal.toFixed(2)}`;
            document.getElementById(
              "modalShipping"
            ).textContent = `$${order.shipping.toFixed(2)}`;
            document.getElementById(
              "modalTax"
            ).textContent = `$${order.tax.toFixed(2)}`;
            document.getElementById(
              "modalTotal"
            ).textContent = `$${order.total.toFixed(2)}`;

            // Show modal
            orderDetailModal.style.display = "flex";
          });
        });

        // Close order modal
        closeOrderModal.addEventListener("click", function () {
          orderDetailModal.style.display = "none";
        });

        cancelOrderChanges.addEventListener("click", function () {
          orderDetailModal.style.display = "none";
        });

        // Save order changes
        saveOrderChanges.addEventListener("click", function () {
          // In a real app, you would send the updated status to the server
          const newStatus = document.getElementById("modalOrderStatus").value;

          setTimeout(() => {
            alert(`Order status updated to ${newStatus}`);
            orderDetailModal.style.display = "none";

            // In a real app, you would refresh the order list
          }, 1000);
        });

        // Customer detail modals
        const viewCustomerButtons =
          document.querySelectorAll(".view-customer-btn");
        const customerDetailModal = document.getElementById(
          "customerDetailModal"
        );
        const closeCustomerModal =
          document.getElementById("closeCustomerModal");
        const saveCustomerChanges = document.getElementById(
          "saveCustomerChanges"
        );
        const cancelCustomerChanges = document.getElementById(
          "cancelCustomerChanges"
        );

        viewCustomerButtons.forEach((button) => {
          button.addEventListener("click", function () {
            const customerId = this.getAttribute("data-customer-id");

            // In a real app, you would fetch the customer details from the server
            const customer = sampleData.customers.find(
              (c) => c.id === customerId
            ) || {
              id: customerId,
              name: "Sample Customer",
              email: "customer@example.com",
              phone: "(000) 000-0000",
              joinDate: new Date().toLocaleDateString(),
              address: "123 Sample St, City, Country",
              totalOrders: 0,
              totalSpent: 0,
              avgRating: 0,
              recentOrders: [],
            };

            // Populate modal
            document.getElementById("modalCustomerId").textContent =
              customer.id;
            document.getElementById("modalCustomerFullName").textContent =
              customer.name;
            document.getElementById("modalCustomerDetailEmail").textContent =
              customer.email;
            document.getElementById("modalCustomerDetailPhone").textContent =
              customer.phone;
            document.getElementById("modalCustomerJoinDate").textContent =
              customer.joinDate;
            document.getElementById("modalCustomerAddress").textContent =
              customer.address;
            document.getElementById("modalCustomerTotalOrders").textContent =
              customer.totalOrders;
            document.getElementById(
              "modalCustomerTotalSpent"
            ).textContent = `$${customer.totalSpent.toFixed(2)}`;
            document.getElementById("modalCustomerAvgRating").textContent =
              customer.avgRating.toFixed(1);

            // Populate recent orders
            const customerOrdersContainer = document.getElementById(
              "modalCustomerOrders"
            );
            customerOrdersContainer.innerHTML = "";

            customer.recentOrders.forEach((order) => {
              const row = document.createElement("tr");
              row.innerHTML = `
                <td>${order.id}</td>
                <td>${order.date}</td>
                <td>$${order.amount.toFixed(2)}</td>
                <td><span class="badge badge-${
                  order.status === "completed"
                    ? "success"
                    : order.status === "processing"
                    ? "primary"
                    : order.status === "cancelled"
                    ? "danger"
                    : "warning"
                }">${
                order.status.charAt(0).toUpperCase() + order.status.slice(1)
              }</span></td>
              `;
              customerOrdersContainer.appendChild(row);
            });

            // Show modal
            customerDetailModal.style.display = "flex";
          });
        });

        // Close customer modal
        closeCustomerModal.addEventListener("click", function () {
          customerDetailModal.style.display = "none";
        });

        cancelCustomerChanges.addEventListener("click", function () {
          customerDetailModal.style.display = "none";
        });

        // Save customer changes
        saveCustomerChanges.addEventListener("click", function () {
          // In a real app, you would send the updated customer data to the server
          setTimeout(() => {
            alert("Customer details updated successfully!");
            customerDetailModal.style.display = "none";

            // In a real app, you would refresh the customer list
          }, 1000);
        });

        // Global search
        const globalSearch = document.getElementById("globalSearch");
        if (globalSearch) {
          globalSearch.addEventListener("input", function () {
            const searchTerm = this.value.toLowerCase();

            // In a real app, you would send the search term to the server
            console.log("Searching for:", searchTerm);
          });
        }

        // Product search
        const productSearch = document.getElementById("productSearch");
        if (productSearch) {
          productSearch.addEventListener("input", function () {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll("#productsTable tbody tr");

            rows.forEach((row) => {
              const text = row.textContent.toLowerCase();
              row.style.display = text.includes(searchTerm) ? "" : "none";
            });
          });
        }

        // Customer search
        const customerSearch = document.getElementById("customerSearch");
        if (customerSearch) {
          customerSearch.addEventListener("input", function () {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll("#customersTable tbody tr");

            rows.forEach((row) => {
              const text = row.textContent.toLowerCase();
              row.style.display = text.includes(searchTerm) ? "" : "none";
            });
          });
        }

        // Order filters
        const orderStatusFilter = document.getElementById("orderStatusFilter");
        const orderDateFilter = document.getElementById("orderDateFilter");

        if (orderStatusFilter) {
          orderStatusFilter.addEventListener("change", function () {
            applyOrderFilters();
          });
        }

        if (orderDateFilter) {
          orderDateFilter.addEventListener("change", function () {
            applyOrderFilters();
          });
        }

        function applyOrderFilters() {
          const statusFilter = orderStatusFilter.value;
          const dateFilter = orderDateFilter.value;
          const rows = document.querySelectorAll("#ordersTable tbody tr");

          rows.forEach((row) => {
            const status = row
              .querySelector("td:nth-child(5) span")
              .textContent.toLowerCase();
            const date = row.querySelector("td:nth-child(3)").textContent;

            const statusMatch =
              statusFilter === "all" || status.includes(statusFilter);
            const dateMatch =
              !dateFilter ||
              date.includes(new Date(dateFilter).toLocaleDateString());

            row.style.display = statusMatch && dateMatch ? "" : "none";
          });
        }

        // Logout functionality
        const logoutBtn = document.getElementById("logoutBtn");
        if (logoutBtn) {
          logoutBtn.addEventListener("click", function (e) {
            e.preventDefault();

            // In a real app, you would send a logout request to the server
            if (confirm("Are you sure you want to logout?")) {
              alert("You have been logged out successfully.");
              // Redirect to login page
              window.location.href = "/login";
            }
          });
        }
      });
    </script>
  </body>
</html>
