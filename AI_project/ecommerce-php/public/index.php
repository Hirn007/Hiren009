<?php
/**
 * Main Application Entry Point
 * All requests are routed through this file
 */

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define app root
define('APP_ROOT', dirname(dirname(__FILE__)));
define('PUBLIC_ROOT', __DIR__);

// Start session
session_start();

// Load configuration
$config = require APP_ROOT . '/config/app.php';
$dbConfig = require APP_ROOT . '/config/database.php';

// Set timezone
date_default_timezone_set($config['default_timezone']);

// Load database class
require APP_ROOT . '/config/database_class.php';

// Load all model classes
require APP_ROOT . '/app/models/User.php';
require APP_ROOT . '/app/models/Product.php';
require APP_ROOT . '/app/models/Cart.php';
require APP_ROOT . '/app/models/Order.php';

// Handle logout
if (isset($_GET['page']) && $_GET['page'] === 'logout') {
    session_destroy();
    header('Location: ' . $config['app_url'] . '/?page=home');
    exit;
}

// Get the page request
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$page = preg_replace('/[^a-zA-Z0-9_-]/', '', $page);

// Sanitize input
if (empty($page)) {
    $page = 'home';
}

// Define route paths
$routes = [
    'home' => APP_ROOT . '/app/views/home.php',
    'products' => APP_ROOT . '/app/views/products/list.php',
    'product' => APP_ROOT . '/app/views/products/detail.php',
    'cart' => APP_ROOT . '/app/views/cart/index.php',
    'checkout' => APP_ROOT . '/app/views/cart/checkout.php',
    'login' => APP_ROOT . '/app/views/auth/login.php',
    'register' => APP_ROOT . '/app/views/auth/register.php',
    'profile' => APP_ROOT . '/app/views/profile.php',
    'orders' => APP_ROOT . '/app/views/orders/list.php',
    'order-detail' => APP_ROOT . '/app/views/orders/detail.php',
];

// Check if route exists
if (array_key_exists($page, $routes) && file_exists($routes[$page])) {
    include $routes[$page];
} else {
    // Default to home if page not found
    include APP_ROOT . '/app/views/home.php';
}
?>
