<?php
/**
 * Helper Functions
 */

/**
 * Check if user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Get current user ID
 */
function getCurrentUserId() {
    return $_SESSION['user_id'] ?? null;
}

/**
 * Get current user
 */
function getCurrentUser() {
    if (isLoggedIn()) {
        $user = new User();
        return $user->getUserById(getCurrentUserId());
    }
    return null;
}

/**
 * Sanitize input
 */
function sanitize($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

/**
 * Validate email
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Format price
 */
function formatPrice($price) {
    return '₹' . number_format($price, 2);
}

/**
 * Calculate discount percentage
 */
function getDiscountPercent($originalPrice, $discountPrice) {
    if ($originalPrice <= 0) return 0;
    return round((($originalPrice - $discountPrice) / $originalPrice) * 100);
}

/**
 * Redirect to page
 */
function redirect($page) {
    $config = require APP_ROOT . '/config/app.php';
    header('Location: ' . $config['app_url'] . '/?page=' . $page);
    exit;
}

/**
 * Set flash message
 */
function setFlash($type, $message) {
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message
    ];
}

/**
 * Get and clear flash message
 */
function getFlash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

/**
 * Load model class
 */
function loadModel($modelName) {
    $modelPath = APP_ROOT . '/app/models/' . $modelName . '.php';
    if (file_exists($modelPath)) {
        require_once $modelPath;
        return new $modelName();
    }
    return null;
}

/**
 * Get app configuration
 */
function getConfig($key = null) {
    static $config;
    
    if (!$config) {
        $config = require APP_ROOT . '/config/app.php';
    }
    
    if ($key) {
        return $config[$key] ?? null;
    }
    
    return $config;
}

/**
 * Check CSRF token
 */
function verifyCsrf($token) {
    return isset($_SESSION['csrf_token']) && $_SESSION['csrf_token'] === $token;
}

/**
 * Generate CSRF token
 */
function generateCsrf() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Log errors
 */
function logError($message) {
    $logFile = APP_ROOT . '/logs/error.log';
    @mkdir(dirname($logFile), 0755, true);
    error_log('[' . date('Y-m-d H:i:s') . '] ' . $message . PHP_EOL, 3, $logFile);
}
?>
