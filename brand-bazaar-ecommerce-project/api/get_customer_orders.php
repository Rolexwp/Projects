<?php
// Database configuration
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'brand_bazaar';

// Create connection
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// In a real application, you would get the customer_id from a secure session variable
// or JWT after authentication. For demonstration, we get it from GET parameter.
// IMPORTANT: Never rely solely on GET parameters for customer ID in production for security!
$customer_id = $_GET['customer_id'] ?? null;

if (empty($customer_id)) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Customer ID is required.']);
    mysqli_close($conn);
    exit();
}

/**
 * Function to fetch customer orders with detailed items for API response.
 * @param mysqli $conn The database connection object.
 * @param string $customer_id The ID of the customer.
 * @return array An array of detailed order information, formatted for JSON.
 */
function getCustomerOrdersDetailedForApi($conn, $customer_id) {
    $orders = [];

    // SQL to fetch main order details
    $query = "SELECT
                o.order_id as id,
                o.order_date as time,
                o.total_amount as total,
                o.order_status as status,
                o.payment_method,
                o.shipping_address,
                c.name as customer_name,
                c.email as customer_email,
                c.phone as customer_phone
              FROM customer_orders o
              JOIN site_customers c ON o.customer_id = c.customer_id
              WHERE o.customer_id = ?
              ORDER BY o.order_date DESC";

    $stmt = mysqli_prepare($conn, $query);
    if (!$stmt) {
        error_log("Prepare failed in getCustomerOrdersDetailedForApi: " . mysqli_error($conn));
        return [];
    }
    mysqli_stmt_bind_param($stmt, "s", $customer_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            // SQL to get order items for each order
            $itemsQuery = "SELECT
                            aop.order_product_id,
                            aop.name,
                            aop.description,
                            aop.price,
                            aop.image_url as img,
                            oi.quantity
                          FROM customer_order_items oi
                          JOIN archived_order_products aop ON oi.order_product_id = aop.order_product_id
                          WHERE oi.order_id = ?";

            $stmtItems = mysqli_prepare($conn, $itemsQuery);
            if (!$stmtItems) {
                error_log("Prepare items failed in getCustomerOrdersDetailedForApi: " . mysqli_error($conn));
                continue; // Skip to next order if item query fails
            }
            mysqli_stmt_bind_param($stmtItems, "s", $row['id']);
            mysqli_stmt_execute($stmtItems);
            $itemsResult = mysqli_stmt_get_result($stmtItems);

            $cart = [];
            if ($itemsResult) {
                while ($item = mysqli_fetch_assoc($itemsResult)) {
                    $cart[] = [
                        'name' => $item['name'],
                        'price' => (float)$item['price'], // Cast to float for JSON
                        'img' => $item['img'],
                        'qty' => (int)$item['quantity'] // Cast to int for JSON
                    ];
                }
            }
            mysqli_stmt_close($stmtItems);

            // Decode shipping address JSON, or use fallback if not valid JSON
            $address = json_decode($row['shipping_address'], true);
            if (!is_array($address)) {
                $address = [
                    'name' => $row['customer_name'],
                    'address' => $row['shipping_address'],
                    'phone' => $row['customer_phone']
                ];
            }

            // Add cart and parsed address to the order array
            $row['cart'] = $cart;
            $row['address_parsed'] = $address;
            $row['total'] = (float)$row['total']; // Ensure total is a float

            $orders[] = $row;
        }
    }
    mysqli_stmt_close($stmt);
    return $orders;
}

// Fetch orders using the API function
$customerOrders = getCustomerOrdersDetailedForApi($conn, $customer_id);

// Close database connection
mysqli_close($conn);

// Encode and output the orders as JSON
echo json_encode($customerOrders);
?>
