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

// Set timezone
// date_default_timezone_set('UTC');

// Start session
// session_start();

// // Simple authentication check
// function isAdminLoggedIn() {
//     return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
// }

// Redirect if not logged in
// if (!isAdminLoggedIn() && basename($_SERVER['PHP_SELF']) != 'login.php') {
//     header("Location: login.php");
//     exit;
// }
?>