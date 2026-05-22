<?php
/**
 * Smart Store API Suite
 * Database Connection & Auto-Migration Helper (PDO)
 */

class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $db_name = "smart_store";
    private $conn = null;

    public function getConnection() {
        if ($this->conn !== null) {
            return $this->conn;
        }

        try {
            // Step 1: Connect to MySQL server without database first to ensure db exists
            $dsn_no_db = "mysql:host=" . $this->host . ";charset=utf8mb4";
            $temp_pdo = new PDO($dsn_no_db, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);

            // Create database if not exists
            $temp_pdo->exec("CREATE DATABASE IF NOT EXISTS `{$this->db_name}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $temp_pdo = null; // Close connection

            // Step 2: Connect directly to the Smart Store database
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4";
            $this->conn = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);

            // Step 3: Run Auto-Migrations (Create tables if they don't exist)
            $this->autoMigrate();

        } catch (PDOException $e) {
            // Return failure in clean JSON format
            header('Content-Type: application/json; charset=utf-8');
            http_response_code(500);
            echo json_encode([
                "status" => "error",
                "code" => 500,
                "message" => "Database connection failed: " . $e->getMessage()
            ]);
            exit();
        }

        return $this->conn;
    }

    /**
     * Run migrations automatically to build database tables and seeds if missing.
     */
    private function autoMigrate() {
        if (!$this->conn) return;

        // 1. Users Table
        $this->conn->exec("CREATE TABLE IF NOT EXISTS `users` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `name` VARCHAR(100) NOT NULL,
            `email` VARCHAR(150) NOT NULL UNIQUE,
            `password` VARCHAR(255) NOT NULL,
            `role` VARCHAR(20) DEFAULT 'customer',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        // 2. Products Table
        $this->conn->exec("CREATE TABLE IF NOT EXISTS `products` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `name` VARCHAR(150) NOT NULL,
            `description` TEXT,
            `price` DECIMAL(10, 2) NOT NULL,
            `stock` INT NOT NULL DEFAULT 0,
            `sku` VARCHAR(50) UNIQUE NOT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        // 3. Orders Table
        $this->conn->exec("CREATE TABLE IF NOT EXISTS `orders` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `user_id` INT NOT NULL,
            `total_amount` DECIMAL(10, 2) NOT NULL,
            `status` VARCHAR(30) DEFAULT 'pending',
            `shipping_address` TEXT NOT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        // 4. Order Items Table
        $this->conn->exec("CREATE TABLE IF NOT EXISTS `order_items` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `order_id` INT NOT NULL,
            `product_id` INT NOT NULL,
            `quantity` INT NOT NULL,
            `price` DECIMAL(10, 2) NOT NULL,
            FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE,
            FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        // 5. Seed default products if empty
        $stmt = $this->conn->query("SELECT COUNT(*) FROM `products`");
        if ($stmt->fetchColumn() == 0) {
            $products = [
                ['Veloce Smart Watch', 'Premium AMOLED display smart watch with continuous heart-rate tracking, GPS, and a 14-day battery life.', 199.99, 45, 'VLC-SMW-01'],
                ['AeroBuds Pro', 'Active Noise Cancelling (ANC) true wireless earbuds with high-fidelity spatial audio and fast charging case.', 129.50, 80, 'AB-PRO-NC2'],
                ['Apex 5G Smartphone', 'Flagship 6.7" OLED display smartphone powered by the latest octa-core processor, 256GB storage, and a triple 108MP lens.', 899.00, 15, 'APX-5G-P256'],
                ['Horizon Tablet S8', 'Ultra-thin 11" productivity tablet with stylus support, 120Hz refresh rate, and octa-core chipset.', 499.00, 25, 'HRZ-TAB-S8'],
                ['Titan Charge Pad', '15W rapid wireless charging pad compatible with all Qi-enabled devices, featuring smart temperature control.', 39.99, 120, 'TTN-WCP-15']
            ];

            $insert = $this->conn->prepare("INSERT INTO `products` (`name`, `description`, `price`, `stock`, `sku`) VALUES (?, ?, ?, ?, ?)");
            foreach ($products as $p) {
                $insert->execute($p);
            }
        }

        // 6. Seed demo users if empty
        $stmt = $this->conn->query("SELECT COUNT(*) FROM `users`");
        if ($stmt->fetchColumn() == 0) {
            // Password Hash: $2y$10$w095tXk6dJ9B2r/GZepPnuwU7aGg/e5NlE3K4uEa.O5.aD88tG1Kq (which is "DemoPass123!")
            $hashed_pass = password_hash("DemoPass123!", PASSWORD_BCRYPT);
            
            $insert = $this->conn->prepare("INSERT INTO `users` (`name`, `email`, `password`, `role`) VALUES (?, ?, ?, ?)");
            $insert->execute(['Admin User', 'admin@smartstore.com', $hashed_pass, 'admin']);
            $insert->execute(['John Doe', 'john@gmail.com', $hashed_pass, 'customer']);
        }
    }
}
