-- Smart Store API Suite Database Schema
-- Optimized for MySQL / MariaDB (XAMPP compatibility)

CREATE DATABASE IF NOT EXISTS `smart_store` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `smart_store`;

-- 1. Users Table
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` VARCHAR(20) DEFAULT 'customer',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Products Table
CREATE TABLE IF NOT EXISTS `products` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL,
  `description` TEXT,
  `price` DECIMAL(10, 2) NOT NULL,
  `stock` INT NOT NULL DEFAULT 0,
  `sku` VARCHAR(50) UNIQUE NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Orders Table
CREATE TABLE IF NOT EXISTS `orders` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `total_amount` DECIMAL(10, 2) NOT NULL,
  `status` VARCHAR(30) DEFAULT 'pending',
  `shipping_address` TEXT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Order Items Table
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `order_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  `quantity` INT NOT NULL,
  `price` DECIMAL(10, 2) NOT NULL,
  FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Seed Core Products
INSERT INTO `products` (`name`, `description`, `price`, `stock`, `sku`) VALUES
('Veloce Smart Watch', 'Premium AMOLED display smart watch with continuous heart-rate tracking, GPS, and a 14-day battery life.', 199.99, 45, 'VLC-SMW-01'),
('AeroBuds Pro', 'Active Noise Cancelling (ANC) true wireless earbuds with high-fidelity spatial audio and fast charging case.', 129.50, 80, 'AB-PRO-NC2'),
('Apex 5G Smartphone', 'Flagship 6.7" OLED display smartphone powered by the latest octa-core processor, 256GB storage, and a triple 108MP lens.', 899.00, 15, 'APX-5G-P256'),
('Horizon Tablet S8', 'Ultra-thin 11" productivity tablet with stylus support, 120Hz refresh rate, and octa-core chipset.', 499.00, 25, 'HRZ-TAB-S8'),
('Titan Charge Pad', '15W rapid wireless charging pad compatible with all Qi-enabled devices, featuring smart temperature control.', 39.99, 120, 'TTN-WCP-15')
ON DUPLICATE KEY UPDATE `sku` = `sku`;

-- 6. Seed Demo Users (Password: DemoPass123! hashed with bcrypt)
-- Password Hash: $2y$10$w095tXk6dJ9B2r/GZepPnuwU7aGg/e5NlE3K4uEa.O5.aD88tG1Kq
INSERT INTO `users` (`name`, `email`, `password`, `role`) VALUES
('Admin User', 'admin@smartstore.com', '$2y$10$w095tXk6dJ9B2r/GZepPnuwU7aGg/e5NlE3K4uEa.O5.aD88tG1Kq', 'admin'),
('John Doe', 'john@gmail.com', '$2y$10$w095tXk6dJ9B2r/GZepPnuwU7aGg/e5NlE3K4uEa.O5.aD88tG1Kq', 'customer')
ON DUPLICATE KEY UPDATE `email` = `email`;
