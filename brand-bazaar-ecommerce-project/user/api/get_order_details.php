<?php
require_once '../config.php'; // Adjust path as necessary
session_start();

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

$user_id = $_SESSION['user_id'];
$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($order_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid order ID.']);
    exit;
}

$order = null;
$order_items = [];

// Fetch order details, ensuring it belongs to the logged-in user
$order_sql = "SELECT * FROM orders WHERE id = ? AND user_id = ?";
if ($stmt = mysqli_prepare($conn, $order_sql)) {
    mysqli_stmt_bind_param($stmt, "ii", $order_id, $user_id);
    mysqli_stmt_execute($stmt);
    $order_result = mysqli_stmt_get_result($stmt);

    if ($order_result && mysqli_num_rows($order_result) > 0) {
        $order = mysqli_fetch_assoc($order_result);

        // Fetch order items for this order
        $items_sql = "SELECT oi.*, p.image_path
                      FROM order_items oi
                      LEFT JOIN products p ON oi.product_id = p.id
                      WHERE oi.order_id = ?";
        if ($item_stmt = mysqli_prepare($conn, $items_sql)) {
            mysqli_stmt_bind_param($item_stmt, "i", $order_id);
            mysqli_stmt_execute($item_stmt);
            $items_result = mysqli_stmt_get_result($item_stmt);

            while ($item_row = mysqli_fetch_assoc($items_result)) {
                $order_items[] = $item_row;
            }
            mysqli_stmt_close($item_stmt);
        }
    }
    mysqli_stmt_close($stmt);
} else {
    echo json_encode(['success' => false, 'message' => 'Database query failed: ' . mysqli_error($conn)]);
    exit;
}

if ($order) {
    echo json_encode(['success' => true, 'order' => $order, 'items' => $order_items]);
} else {
    echo json_encode(['success' => false, 'message' => 'Order not found or does not belong to user.']);
}

mysqli_close($conn);
?>