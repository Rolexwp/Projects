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

// Handle order status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id']) && isset($_POST['status'])) {
    $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $update_query = "UPDATE orders SET status = '$status' WHERE id = '$order_id'";
    if (mysqli_query($conn, $update_query)) {
<<<<<<< HEAD
=======
        // Status updated successfully
>>>>>>> 22151942540414ef8b88569e0a0b797ee6aad75a
        header("Location: orders.php?status_updated=true");
        exit;
    } else {
        echo "Error updating status: " . mysqli_error($conn);
    }
}

// Fetch orders from the database
$sql = "SELECT id, user_id, customer_name, customer_email, total_amount, status, order_date FROM orders ORDER BY order_date DESC";
$result = mysqli_query($conn, $sql);

$orders = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $orders[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brand Bazaar - Orders Management</title>
    <link rel="icon" type="image/x-icon" href="/icons/favicon.ico">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-warning {
            background-color: #fff3cd;
            color: #856404;
        }
        .badge-primary {
            background-color: #cce5ff;
            color: #004085;
        }
        .badge-success {
            background-color: #d4edda;
            color: #155724;
        }
        .badge-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
        .badge-info { /* New badge style for 'processing' */
            background-color: #d1ecf1;
            color: #0c5460;
        }
        .order-actions .btn {
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            margin-right: 5px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .order-actions .btn-info {
            background-color: #17a2b8;
            color: white;
            border: none;
        }
        .order-actions .btn-info:hover {
            background-color: #117a8b;
        }
        .order-actions .btn-primary {
            background-color: #007bff;
            color: white;
            border: none;
        }
        .order-actions .btn-primary:hover {
            background-color: #0056b3;
        }
        .status-select {
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
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
            <h1>Orders Management</h1>

            <div class="admin-card">
                <div class="admin-card-header">
                    <span>All Orders</span>
                    <div class="filter-controls">
                        <select id="orderStatusFilter" class="status-select">
                            <option value="all">All Statuses</option>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                        <input type="date" id="orderDateFilter" class="date-select">
                    </div>
                </div>
                <div class="admin-card-body">
                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer Name</th>
                                    <th>Order Date</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="ordersTableBody">
                                <?php if (!empty($orders)): ?>
                                    <?php foreach ($orders as $order): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($order['id']); ?></td>
                                            <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                            <td><?php echo htmlspecialchars(date('Y-m-d H:i', strtotime($order['order_date']))); ?></td>
                                            <td>₹<?php echo htmlspecialchars(number_format($order['total_amount'], 2)); ?></td>
                                            <td>
                                                <span class="badge badge-<?php
                                                    switch ($order['status']) {
                                                        case 'pending': echo 'warning'; break;
                                                        case 'processing': echo 'info'; break; // New badge-info for processing
                                                        case 'completed': echo 'success'; break;
                                                        case 'cancelled': echo 'danger'; break;
                                                        default: echo 'secondary'; break;
                                                    }
                                                ?>">
                                                    <?php echo ucfirst(htmlspecialchars($order['status'])); ?>
                                                </span>
                                            </td>
                                            <td class="order-actions">
                                                <a href="order_details.php?id=<?php echo htmlspecialchars($order['id']); ?>" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                <button class="btn btn-primary btn-sm print-order-btn" data-order-id="<?php echo htmlspecialchars($order['id']); ?>">
                                                    <i class="fas fa-print"></i> Print
                                                </button>
                                                <form action="orders.php" method="POST" style="display:inline-block;">
                                                    <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['id']); ?>">
                                                    <select name="status" class="status-select" onchange="this.form.submit()">
                                                        <option value="pending" <?php echo ($order['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                                        <option value="processing" <?php echo ($order['status'] == 'processing') ? 'selected' : ''; ?>>Processing</option>
                                                        <option value="completed" <?php echo ($order['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                                                        <option value="cancelled" <?php echo ($order['status'] == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                                                    </select>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" style="text-align: center;">No orders found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="js/admin.js"></script>
    <script>
        // Print order functionality
        document.querySelectorAll('.print-order-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const orderId = this.getAttribute('data-order-id');
                // Assuming print-order.php is in the same admin directory
                window.open(`print-order.php?id=${orderId}`, '_blank');
            });
        });

        // Filter orders
        document.getElementById('orderStatusFilter').addEventListener('change', filterOrders);
        document.getElementById('orderDateFilter').addEventListener('change', filterOrders);

        function filterOrders() {
            const status = document.getElementById('orderStatusFilter').value;
            const date = document.getElementById('orderDateFilter').value;
            const tableBody = document.getElementById('ordersTableBody');
            const rows = tableBody.querySelectorAll('tr');

            rows.forEach(row => {
                const rowStatusElement = row.querySelector('td:nth-child(5) span');
                const rowDateElement = row.querySelector('td:nth-child(3)');

                if (!rowStatusElement || !rowDateElement) {
                    row.style.display = 'none'; // Hide rows that don't match expected structure
                    return;
                }

                const rowStatus = rowStatusElement.textContent.toLowerCase();
                const rowDate = rowDateElement.textContent.split(' ')[0]; // Get only the date part

                const statusMatch = status === 'all' || rowStatus.includes(status);
                const dateMatch = !date || rowDate === date;

                row.style.display = statusMatch && dateMatch ? '' : 'none';
            });
        }

        // Global Search (if implemented in admin.js or similar)
        document.getElementById('globalSearch').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const tableBody = document.getElementById('ordersTableBody');
            const rows = tableBody.querySelectorAll('tr');

            rows.forEach(row => {
                const orderId = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                const customerName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const display = orderId.includes(searchTerm) || customerName.includes(searchTerm) ? '' : 'none';
                row.style.display = display;
            });
        });
    </script>
</body>
</html>