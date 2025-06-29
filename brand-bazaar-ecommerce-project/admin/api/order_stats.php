<?php
require_once '../config.php';
header('Content-Type: application/json');
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;

$conditions = [];
if ($startDate) {
    $conditions[] = "order_date >= '" . mysqli_real_escape_string($conn, $startDate) . " 00:00:00'";
}
if ($endDate) {
    $conditions[] = "order_date <= '" . mysqli_real_escape_string($conn, $endDate) . " 23:59:59'";
}
$where_clause = '';
if (!empty($conditions)) {
    $where_clause = 'WHERE ' . implode(' AND ', $conditions);
}

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
mysqli_close($conn);
?>