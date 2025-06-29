<?php
require_once 'C:/xampp/htdocs/brand-bazaar-ecommerce-project/admin/config.php';

header('Content-Type: application/json');

// Simple authentication (you might want more robust auth)
// if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
//     echo json_encode(['error' => 'Unauthorized access']);
//     exit;
// }

$response = [
    'overall_stats' => [],
    'status_distribution' => [],
    'total_revenue' => 0,
    'average_order_value' => 0
];

// Total Orders by Status
$status_query = "SELECT status, COUNT(*) AS count, SUM(total_amount) AS total_value FROM orders GROUP BY status";
$status_result = mysqli_query($conn, $status_query);

if ($status_result) {
    while ($row = mysqli_fetch_assoc($status_result)) {
        $response['status_distribution'][] = [
            'status' => $row['status'],
            'count' => (int)$row['count'],
            'total_value' => (float)$row['total_value']
        ];
    }
} else {
    $response['error'] = 'Database error fetching status distribution: ' . mysqli_error($conn);
    echo json_encode($response);
    exit;
}

// Overall Stats (Total Revenue, Average Order Value, Total Orders)
$overall_query = "SELECT 
                    COUNT(*) AS total_orders, 
                    SUM(total_amount) AS total_revenue, 
                    AVG(total_amount) AS average_order_value 
                  FROM orders";
$overall_result = mysqli_query($conn, $overall_query);

if ($overall_result && mysqli_num_rows($overall_result) > 0) {
    $overall_data = mysqli_fetch_assoc($overall_result);
    $response['overall_stats'] = [
        'total_orders' => (int)$overall_data['total_orders'],
        'total_revenue' => (float)$overall_data['total_revenue'],
        'average_order_value' => (float)$overall_data['average_order_value']
    ];
    $response['total_revenue'] = (float)$overall_data['total_revenue'];
    $response['average_order_value'] = (float)$overall_data['average_order_value'];
} else {
    $response['error'] = 'Database error fetching overall stats: ' . mysqli_error($conn);
    echo json_encode($response);
    exit;
}

echo json_encode($response);

mysqli_close($conn);
?>