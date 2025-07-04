<?php
require_once 'config.php';
<<<<<<< HEAD
=======
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit;
}
>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Brand Bazaar - Reports</title>
    <link rel="icon" type="image/x-icon" href="/icons/favicon.ico" />
    <link rel="stylesheet" href="css/admin.css">
<<<<<<< HEAD
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
=======
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />
>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
<<<<<<< HEAD
=======
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
>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a
        </div>

        <button class="dark-mode-toggle" id="darkModeToggle">
          <i class="fas fa-moon"></i>
        </button>

        <div class="admin-user" id="userDropdownToggle">
          <span>Admin User</span>
<<<<<<< HEAD
          <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Admin"/>
=======
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
>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a
        </div>
      </div>
    </header>

    <aside class="admin-sidebar">
      <button class="menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i>
      </button>
      <ul class="admin-menu">
        <li>
<<<<<<< HEAD
          <a href="dashboard.php">
=======
          <a href="dashboard.php" data-section="dashboard">
>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a
            <i class="fas fa-tachometer-alt"></i>
            Dashboard
          </a>
        </li>
        <li>
<<<<<<< HEAD
          <a href="all-products.php">
=======
          <a href="all-products.php" data-section="products">
>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a
            <i class="fas fa-box-open"></i>
            Products
          </a>
        </li>
        <li>
<<<<<<< HEAD
          <a href="orders.php">
=======
          <a href="orders.php" data-section="orders">
>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a
            <i class="fas fa-shopping-cart"></i>
            Orders
          </a>
        </li>
        <li>
<<<<<<< HEAD
          <a href="customers.php">
=======
          <a href="customers.php" data-section="customers">
>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a
            <i class="fas fa-users"></i>
            Customers
          </a>
        </li>
        <li>
<<<<<<< HEAD
          <a href="sliders.php">
            <i class="fas fa-percentage"></i>
            Sliders
          </a>
        </li>
        <li>
          <a href="reports.php" class="active">
=======
          <a href="sliders.php" data-section="Sliders">
            <i class="fas fa-percentage"></i>
           Sliders
          </a>
        </li>
        <li>
          <a href="reports.php" class="active" data-section="Reports">
>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a
            <i class="fas fa-chart-bar"></i>
            Reports
          </a>
        </li>
        <li>
<<<<<<< HEAD
          <a href="settings.php">
=======
          <a href="settings.php" data-section="settings">
>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a
            <i class="fas fa-cog"></i>
            Settings
          </a>
        </li>
      </ul>
    </aside>

    <main class="admin-main">
        <section class="content-section">
            <h1>Analytics & Reports</h1>
<<<<<<< HEAD
=======

>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a
            <div class="admin-card">
                <div class="admin-card-header">
                    <span>Report Filters</span>
                </div>
                <div class="admin-card-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Report Type</label>
                            <select class="form-control" id="reportType">
                                <option value="sales">Sales Report</option>
                                <option value="products">Product Performance</option>
                                <option value="customers">Customer Analytics</option>
<<<<<<< HEAD
                                <option value="orders">Order Statistics</option>
                            </select>
=======
                                <option value="orders">Order Statistics</option> </select>
>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a
                        </div>
                        <div class="form-group">
                            <label class="form-label">Date Range</label>
                            <select class="form-control" id="dateRange">
                                <option value="today">Today</option>
                                <option value="yesterday">Yesterday</option>
                                <option value="week">This Week</option>
                                <option value="month" selected>This Month</option>
                                <option value="quarter">This Quarter</option>
                                <option value="year">This Year</option>
                                <option value="custom">Custom Range</option>
                            </select>
                        </div>
                        <div class="form-group" id="customDateRange" style="display: none;">
                            <label class="form-label">Custom Range</label>
                            <div class="form-row">
                                <input type="date" class="form-control" id="startDate">
                                <span class="mx-2">to</span>
                                <input type="date" class="form-control" id="endDate">
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" id="generateReport">
                                <i class="fas fa-chart-line"></i> Generate Report
                            </button>
                            <button class="btn btn-success" id="exportReport">
                                <i class="fas fa-file-excel"></i> Export Report
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="admin-card mt-4">
                <div class="admin-card-header">
                    <span id="reportTitle">Sales Overview</span>
                </div>
                <div class="admin-card-body">
                    <div class="chart-container" style="position: relative; height:400px; width:100%">
                        <canvas id="myChart"></canvas>
                    </div>
                     <div id="orderDetailsReport" style="display: none;">
                        <h3>Order Status Breakdown</h3>
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Count</th>
                                    <th>Total Value</th>
                                </tr>
                            </thead>
<<<<<<< HEAD
                            <tbody id="orderStatsTableBody"></tbody>
                        </table>
                        <div id="averageOrderValue" style="margin-top: 20px; font-weight: bold;"></div>
=======
                            <tbody id="orderStatsTableBody">
                                </tbody>
                        </table>
                        <div id="averageOrderValue" style="margin-top: 20px; font-weight: bold;">
                            </div>
>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="js/admin.js"></script>
    <script>
<<<<<<< HEAD
      let myChartInstance;

=======
      let myChartInstance; // Keep track of the chart instance

      // Function to get dates based on range
>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a
      function getDateRange() {
        const dateRange = document.getElementById('dateRange').value;
        let startDate, endDate;
        const today = new Date();
<<<<<<< HEAD
        today.setHours(0,0,0,0);
=======
        today.setHours(0,0,0,0); // Normalize to start of day
>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a

        switch (dateRange) {
          case 'today':
            startDate = new Date(today);
            endDate = new Date(today);
<<<<<<< HEAD
            endDate.setHours(23,59,59,999);
=======
            endDate.setHours(23,59,59,999); // End of day
>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a
            break;
          case 'yesterday':
            startDate = new Date(today);
            startDate.setDate(today.getDate() - 1);
            endDate = new Date(startDate);
            endDate.setHours(23,59,59,999);
            break;
          case 'week':
            const dayOfWeek = today.getDay();
            startDate = new Date(today);
<<<<<<< HEAD
            startDate.setDate(today.getDate() - (dayOfWeek === 0 ? 6 : dayOfWeek - 1));
=======
            startDate.setDate(today.getDate() - (dayOfWeek === 0 ? 6 : dayOfWeek - 1)); // Monday as start of week
>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a
            endDate = new Date(startDate);
            endDate.setDate(startDate.getDate() + 6);
            endDate.setHours(23,59,59,999);
            break;
          case 'month':
            startDate = new Date(today.getFullYear(), today.getMonth(), 1);
            endDate = new Date(today.getFullYear(), today.getMonth() + 1, 0);
            endDate.setHours(23,59,59,999);
            break;
          case 'quarter':
            const currentMonth = today.getMonth();
            const currentQuarter = Math.floor(currentMonth / 3);
            startDate = new Date(today.getFullYear(), currentQuarter * 3, 1);
            endDate = new Date(today.getFullYear(), currentQuarter * 3 + 3, 0);
            endDate.setHours(23,59,59,999);
            break;
          case 'year':
            startDate = new Date(today.getFullYear(), 0, 1);
            endDate = new Date(today.getFullYear(), 11, 31);
            endDate.setHours(23,59,59,999);
            break;
          case 'custom':
            startDate = new Date(document.getElementById('startDate').value);
            endDate = new Date(document.getElementById('endDate').value);
            endDate.setHours(23,59,59,999);
            break;
          default:
            startDate = new Date(today.getFullYear(), today.getMonth(), 1);
            endDate = new Date(today.getFullYear(), today.getMonth() + 1, 0);
            endDate.setHours(23,59,59,999);
            break;
        }
        return { startDate: startDate.toISOString().split('T')[0], endDate: endDate.toISOString().split('T')[0] };
      }

<<<<<<< HEAD
      async function fetchData(reportType, startDate, endDate) {
        // Replace simulation with AJAX to your actual API endpoints
        let data = {};
        if (reportType === 'sales') {
=======

      // Function to fetch data based on report type and date range
      async function fetchData(reportType, startDate, endDate) {
        // This is a placeholder for actual AJAX calls to your API endpoints
        // You would typically have PHP scripts like api/sales_data.php, api/product_data.php, etc.
        let data = {};
        if (reportType === 'sales') {
            // Simulate sales data
>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a
            data = {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Monthly Sales',
                    data: [12000, 19000, 3000, 5000, 2000, 30000],
                    backgroundColor: 'rgba(10, 69, 166, 0.6)',
                    borderColor: 'rgba(10, 69, 166, 1)',
                    borderWidth: 1
                }]
            };
        } else if (reportType === 'products') {
<<<<<<< HEAD
=======
            // Simulate product performance data
>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a
            data = {
                labels: ['Laptop X', 'Mobile Y', 'Earbuds Z', 'Smartwatch A', 'Gaming Console B'],
                datasets: [{
                    label: 'Products Sold',
                    data: [50, 75, 30, 45, 60],
                    backgroundColor: ['#0a45a6', '#4CAF50', '#FFC107', '#00BCD4', '#E91E63'],
                    borderColor: 'white',
                    borderWidth: 1
                }]
            };
        } else if (reportType === 'customers') {
<<<<<<< HEAD
=======
            // Simulate customer analytics data (e.g., new customers per month)
>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a
            data = {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'New Customers',
                    data: [10, 15, 7, 20, 12, 25],
                    backgroundColor: 'rgba(76, 175, 80, 0.6)',
                    borderColor: 'rgba(76, 175, 80, 1)',
                    borderWidth: 1
                }]
            };
        } else if (reportType === 'orders') {
<<<<<<< HEAD
=======
            // Fetch real order statistics from the database via an API call
>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a
            try {
                const response = await fetch(`api/order_stats.php?startDate=${startDate}&endDate=${endDate}`);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                data = await response.json();
            } catch (error) {
                console.error("Error fetching order statistics:", error);
<<<<<<< HEAD
                data = { statuses: {}, totalOrders: 0, totalRevenue: 0, averageOrderValue: 0 };
=======
                data = { statuses: {}, totalOrders: 0, totalRevenue: 0, averageOrderValue: 0 }; // Default empty data
>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a
            }
        }
        return data;
      }

<<<<<<< HEAD
=======
      // Function to render charts
>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a
      function renderChart(data, reportType) {
        const ctx = document.getElementById('myChart').getContext('2d');

        if (myChartInstance) {
<<<<<<< HEAD
          myChartInstance.destroy();
        }

        document.getElementById('orderDetailsReport').style.display = 'none';
        document.querySelector('.chart-container').style.display = 'block';
=======
          myChartInstance.destroy(); // Destroy existing chart instance
        }

        document.getElementById('orderDetailsReport').style.display = 'none'; // Hide order details table by default
        document.querySelector('.chart-container').style.display = 'block'; // Show chart canvas
>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a

        if (reportType === 'sales' || reportType === 'customers') {
          myChartInstance = new Chart(ctx, {
            type: 'line',
            data: data,
            options: {
              responsive: true,
              maintainAspectRatio: false,
              scales: {
                y: {
                  beginAtZero: true,
                  ticks: {
                    callback: function(value) {
                      return reportType === 'sales' ? '₹' + value.toLocaleString() : value;
                    }
                  }
                }
              }
            }
          });
        } else if (reportType === 'products') {
          myChartInstance = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
              responsive: true,
              maintainAspectRatio: false,
              scales: {
                y: {
                  beginAtZero: true
                }
              }
            }
          });
        } else if (reportType === 'orders') {
<<<<<<< HEAD
=======
            // Hide chart, show table
>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a
            document.querySelector('.chart-container').style.display = 'none';
            document.getElementById('orderDetailsReport').style.display = 'block';
            populateOrderStatsTable(data);
        }
      }

<<<<<<< HEAD
      function populateOrderStatsTable(data) {
          const tableBody = document.getElementById('orderStatsTableBody');
          tableBody.innerHTML = '';
=======
      // Function to populate order statistics table
      function populateOrderStatsTable(data) {
          const tableBody = document.getElementById('orderStatsTableBody');
          tableBody.innerHTML = ''; // Clear previous data

>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a
          let totalOrders = 0;
          let totalRevenue = 0;

          if (data && data.statuses) {
              for (const status in data.statuses) {
                  const row = tableBody.insertRow();
                  const statusCell = row.insertCell();
                  const countCell = row.insertCell();
                  const valueCell = row.insertCell();

                  statusCell.textContent = ucfirst(status);
                  countCell.textContent = data.statuses[status].count;
                  valueCell.textContent = '₹' + data.statuses[status].total_value.toLocaleString();

                  totalOrders += data.statuses[status].count;
                  totalRevenue += data.statuses[status].total_value;
              }
          }

          const avgOrderValue = totalOrders > 0 ? totalRevenue / totalOrders : 0;
<<<<<<< HEAD
          document.getElementById('averageOrderValue').textContent = `Total Orders: ${totalOrders} | Total Revenue: ₹${totalRevenue.toLocaleString()} | Average Order Value: ₹${avgOrderValue.toLocaleString(undefined, {maximumFractionDigits: 2})}`;
      }

=======
          document.getElementById('averageOrderValue').textContent = `Total Orders: ${totalOrders} | Total Revenue: ₹${totalRevenue.toLocaleString()} | Average Order Value: ₹${avgOrderValue.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
      }

      // Helper function to capitalize first letter
>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a
      function ucfirst(str) {
          if (!str) return str;
          return str.charAt(0).toUpperCase() + str.slice(1);
      }

<<<<<<< HEAD
      document.getElementById('reportType').addEventListener('change', function() {
        const reportType = this.value;
        document.getElementById('reportTitle').textContent = this.options[this.selectedIndex].text;
=======

      // Event Listeners
      document.getElementById('reportType').addEventListener('change', function() {
        const reportType = this.value;
        document.getElementById('reportTitle').textContent = this.options[this.selectedIndex].text;
        // Logic to hide/show custom date range based on selection (already exists)
>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a
        if (reportType === 'custom') {
            document.getElementById('customDateRange').style.display = 'block';
        } else {
            document.getElementById('customDateRange').style.display = 'none';
        }
<<<<<<< HEAD
=======
        // Generate report immediately on type change if not custom
>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a
        if (reportType !== 'custom') {
            generateReport();
        }
      });

      document.getElementById('dateRange').addEventListener('change', function() {
        const customDateRange = document.getElementById('customDateRange');
        if (this.value === 'custom') {
          customDateRange.style.display = 'block';
        } else {
          customDateRange.style.display = 'none';
<<<<<<< HEAD
          generateReport();
=======
          generateReport(); // Generate report immediately on range change if not custom
>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a
        }
      });

      document.getElementById('generateReport').addEventListener('click', generateReport);

      async function generateReport() {
        const reportType = document.getElementById('reportType').value;
        const { startDate, endDate } = getDateRange();
        const data = await fetchData(reportType, startDate, endDate);
        renderChart(data, reportType);
      }

<<<<<<< HEAD
=======
      // Export report (existing functionality, potentially needs API endpoint for each report type)
>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a
      document.getElementById('exportReport').addEventListener('click', function() {
        const reportType = document.getElementById('reportType').value;
        const dateRange = document.getElementById('dateRange').value;
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;

<<<<<<< HEAD
=======
        // Build export URL
>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a
        let exportUrl = `export_report.php?type=${reportType}&range=${dateRange}`;
        if(dateRange === 'custom') {
          exportUrl += `&start=${startDate}&end=${endDate}`;
        }
<<<<<<< HEAD
        window.location.href = exportUrl;
      });

      document.addEventListener('DOMContentLoaded', function() {
=======

        // Trigger download
        window.location.href = exportUrl;
      });

      // Initialize charts and reports on page load
      document.addEventListener('DOMContentLoaded', function() {
        // Set default dates for custom range
>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a
        const today = new Date().toISOString().split('T')[0];
        const lastMonth = new Date();
        lastMonth.setMonth(lastMonth.getMonth() - 1);
        const lastMonthStr = lastMonth.toISOString().split('T')[0];
<<<<<<< HEAD
        document.getElementById('startDate').value = lastMonthStr;
        document.getElementById('endDate').value = today;
        generateReport();
=======

        document.getElementById('startDate').value = lastMonthStr;
        document.getElementById('endDate').value = today;

        generateReport(); // Generate default report on load
>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a
      });
    </script>
    <script>
    // This is a placeholder for a new API endpoint you'll need to create.
    // Create a new file: `api/order_stats.php` in your admin directory.
    // The content of `api/order_stats.php` should look something like this:

    /*
    <?php
<<<<<<< HEAD
    require_once '../config.php';
    header('Content-Type: application/json');
=======
    require_once '../config.php'; // Adjust path as necessary
    session_start();

    // Check if admin is logged in (optional, but recommended for API access)
    if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
        // http_response_code(401);
        // echo json_encode(['error' => 'Unauthorized access']);
        // exit;
    }

    header('Content-Type: application/json');

>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a
    $startDate = $_GET['startDate'] ?? null;
    $endDate = $_GET['endDate'] ?? null;

    $conditions = [];
    if ($startDate) {
        $conditions[] = "order_date >= '" . mysqli_real_escape_string($conn, $startDate) . " 00:00:00'";
    }
    if ($endDate) {
        $conditions[] = "order_date <= '" . mysqli_real_escape_string($conn, $endDate) . " 23:59:59'";
    }
<<<<<<< HEAD
=======

>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a
    $where_clause = '';
    if (!empty($conditions)) {
        $where_clause = 'WHERE ' . implode(' AND ', $conditions);
    }

<<<<<<< HEAD
=======
    // Query to get order count and total value by status
>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a
    $sql_status = "SELECT status, COUNT(*) as count, SUM(total_amount) as total_value FROM orders $where_clause GROUP BY status";
    $result_status = mysqli_query($conn, $sql_status);

    $statuses = [];
    if ($result_status) {
        while ($row = mysqli_fetch_assoc($result_status)) {
            $statuses[$row['status']] = [
                'count' => (int)$row['count'],
                'total_value' => (float)$row['total_value']
            ];
        }
    }

<<<<<<< HEAD
=======
    // Query to get total orders, total revenue, and average order value
>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a
    $sql_summary = "SELECT COUNT(*) as total_orders, SUM(total_amount) as total_revenue, AVG(total_amount) as avg_order_value FROM orders $where_clause";
    $result_summary = mysqli_query($conn, $sql_summary);
    $summary = mysqli_fetch_assoc($result_summary);

    $response = [
        'statuses' => $statuses,
        'totalOrders' => (int)$summary['total_orders'],
        'totalRevenue' => (float)$summary['total_revenue'],
        'averageOrderValue' => (float)$summary['avg_order_value']
    ];

    echo json_encode($response);
<<<<<<< HEAD
=======

>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a
    mysqli_close($conn);
    ?>
    */
    </script>
  </body>
</html>