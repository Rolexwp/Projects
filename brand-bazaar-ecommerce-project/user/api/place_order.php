<?php
require_once '../config.php';
session_start();

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];
$customer_name = mysqli_real_escape_string($conn, $input['fullName']);
$customer_email = mysqli_real_escape_string($conn, $input['email']);
$customer_phone = mysqli_real_escape_string($conn, $input['phone']);
$shipping_address = mysqli_real_escape_string($conn, $input['address']);
$payment_method = mysqli_real_escape_string($conn, $input['paymentMethod']);
$status = mysqli_real_escape_string($conn, $input['status']);
$payment_status = mysqli_real_escape_string($conn, $input['paymentStatus']);

$subtotal = isset($input['subtotal']) ? floatval($input['subtotal']) : 0;
$shipping_cost = isset($input['shippingCost']) ? floatval($input['shippingCost']) : 0;
$tax_amount = isset($input['taxAmount']) ? floatval($input['taxAmount']) : 0;
$discount_amount = isset($input['discountAmount']) ? floatval($input['discountAmount']) : 0;
$total_amount = isset($input['totalAmount']) ? floatval($input['totalAmount']) : 0;

mysqli_begin_transaction($conn);

try {
    $order_sql = "INSERT INTO orders (user_id, customer_name, customer_email, customer_phone, shipping_address, subtotal, shipping_cost, tax_amount, discount_amount, total_amount, status, payment_method, payment_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($conn, $order_sql)) {
        mysqli_stmt_bind_param($stmt, "isssddddddsss", $user_id, $customer_name, $customer_email, $customer_phone, $shipping_address, $subtotal, $shipping_cost, $tax_amount, $discount_amount, $total_amount, $status, $payment_method, $payment_status);
        mysqli_stmt_execute($stmt);
        $order_id = mysqli_insert_id($conn);
        mysqli_stmt_close($stmt);
    } else {
        throw new Exception("Order insertion failed: " . mysqli_error($conn));
    }

    $item_sql = "INSERT INTO order_items (order_id, product_id, product_name, quantity, price) VALUES (?, ?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($conn, $item_sql)) {
        foreach ($input['cartItems'] as $item) {
            $product_id = isset($item['id']) ? intval($item['id']) : 0;
            $product_name = mysqli_real_escape_string($conn, $item['name']);
            $quantity = intval($item['quantity']);
            $price = floatval($item['price']);
            mysqli_stmt_bind_param($stmt, "iisid", $order_id, $product_id, $product_name, $quantity, $price);
            mysqli_stmt_execute($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        throw new Exception("Order item insertion failed: " . mysqli_error($conn));
    }

    mysqli_commit($conn);
    echo json_encode(['success' => true, 'message' => 'Order placed successfully!', 'orderId' => $order_id]);

} catch (Exception $e) {
    mysqli_rollback($conn);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

mysqli_close($conn);
?>