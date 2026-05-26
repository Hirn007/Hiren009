<?php
/**
 * Application Configuration
 */

return [
    'app_name' => 'FlipClone - E-Commerce Platform',
    'app_url' => 'http://localhost/php_2025/AI_project/ecommerce-php/public',
    'currency' => '₹',
    'default_timezone' => 'Asia/Kolkata',
    'items_per_page' => 20,
    'jwt_secret' => 'your_secret_key_change_in_production',
    'session_timeout' => 3600, // 1 hour
    'upload_path' => __DIR__ . '/../public/uploads/',
    'max_file_size' => 5242880 // 5MB
];
?>
