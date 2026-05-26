-- E-Commerce Database Schema (MySQL)
-- Created for FlipClone PHP Application

-- Drop existing tables if they exist
DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS cart;
DROP TABLE IF EXISTS reviews;
DROP TABLE IF EXISTS wishlist;
DROP TABLE IF EXISTS product_images;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;

-- Users Table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    firstName VARCHAR(100) NOT NULL,
    lastName VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(15),
    profileImage VARCHAR(500),
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Categories Table
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) UNIQUE NOT NULL,
    description TEXT,
    image VARCHAR(500),
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Products Table
CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    discountPrice DECIMAL(10, 2),
    categoryId INT NOT NULL,
    mainImage VARCHAR(500),
    stock INT DEFAULT 0,
    rating DECIMAL(3, 2) DEFAULT 0,
    reviewCount INT DEFAULT 0,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (categoryId) REFERENCES categories(id) ON DELETE CASCADE,
    INDEX idx_category (categoryId),
    INDEX idx_price (price)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Product Images Table
CREATE TABLE product_images (
    id INT PRIMARY KEY AUTO_INCREMENT,
    productId INT NOT NULL,
    imageUrl VARCHAR(500) NOT NULL,
    displayOrder INT DEFAULT 0,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (productId) REFERENCES products(id) ON DELETE CASCADE,
    INDEX idx_product (productId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Cart Table
CREATE TABLE cart (
    id INT PRIMARY KEY AUTO_INCREMENT,
    userId INT NOT NULL,
    productId INT NOT NULL,
    quantity INT DEFAULT 1,
    addedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (userId) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (productId) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_cart (userId, productId),
    INDEX idx_user (userId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Orders Table
CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    userId INT NOT NULL,
    orderNumber VARCHAR(50) UNIQUE NOT NULL,
    totalAmount DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'confirmed', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    shippingAddress TEXT NOT NULL,
    shippingCity VARCHAR(100),
    shippingState VARCHAR(100),
    shippingPostalCode VARCHAR(20),
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (userId) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user (userId),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Order Items Table
CREATE TABLE order_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    orderId INT NOT NULL,
    productId INT NOT NULL,
    quantity INT NOT NULL,
    priceAtOrder DECIMAL(10, 2) NOT NULL,
    totalPrice DECIMAL(10, 2) NOT NULL,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (orderId) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (productId) REFERENCES products(id) ON DELETE RESTRICT,
    INDEX idx_order (orderId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Reviews Table
CREATE TABLE reviews (
    id INT PRIMARY KEY AUTO_INCREMENT,
    productId INT NOT NULL,
    userId INT NOT NULL,
    rating INT NOT NULL,
    title VARCHAR(200),
    comment TEXT,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (productId) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (userId) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_review (productId, userId),
    INDEX idx_product (productId),
    CHECK (rating >= 1 AND rating <= 5)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Wishlist Table
CREATE TABLE wishlist (
    id INT PRIMARY KEY AUTO_INCREMENT,
    userId INT NOT NULL,
    productId INT NOT NULL,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (userId) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (productId) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_wishlist (userId, productId),
    INDEX idx_user (userId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert Sample Categories
INSERT INTO categories (name, description) VALUES 
('Electronics', 'Electronic gadgets and devices'),
('Mobile Phones', 'Latest mobile phones and accessories'),
('Fashion', 'Clothing, shoes, and fashion accessories'),
('Home & Kitchen', 'Home appliances and kitchen items'),
('Books', 'Books and educational materials'),
('Beauty & Personal Care', 'Beauty products and personal care items');

-- Insert Sample Products
INSERT INTO products (name, description, price, discountPrice, categoryId, mainImage, stock, rating, reviewCount) VALUES 
('iPhone 15 Pro', 'Latest Apple iPhone 15 Pro with A17 Pro chip, 6.1 inch Retina display', 999.99, 899.99, 2, 'iphone15.jpg', 50, 4.8, 245),
('Samsung Galaxy S24', 'High-end Android smartphone with latest features', 899.99, 799.99, 2, 'galaxy24.jpg', 60, 4.7, 189),
('Running Shoes Premium', 'Comfortable running shoes with latest technology', 79.99, 59.99, 3, 'shoes.jpg', 100, 4.5, 312),
('Wireless Headphones Pro', 'Noise cancelling wireless headphones with 30hr battery', 199.99, 149.99, 1, 'headphones.jpg', 40, 4.6, 178),
('Microwave Oven Digital', 'Digital microwave oven 30L with multiple settings', 299.99, 249.99, 4, 'microwave.jpg', 25, 4.4, 95),
('Leather Jacket', 'Premium leather jacket for all seasons', 129.99, 99.99, 3, 'jacket.jpg', 35, 4.3, 67),
('Smart Watch X', 'Latest smartwatch with health tracking and notifications', 249.99, 199.99, 1, 'smartwatch.jpg', 45, 4.6, 234),
('Coffee Maker Deluxe', 'Automatic coffee maker with programmable features', 89.99, 69.99, 4, 'coffee.jpg', 30, 4.2, 78);

-- Insert Sample User
INSERT INTO users (firstName, lastName, email, password, phone) VALUES 
('Raj', 'Kumar', 'raj@example.com', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36P4/R66', '9876543210');
-- Password: 12345

-- Insert Sample Cart Items
INSERT INTO cart (userId, productId, quantity) VALUES 
(1, 1, 1),
(1, 4, 2);

-- Insert Sample Orders
INSERT INTO orders (userId, orderNumber, totalAmount, status, shippingAddress, shippingCity, shippingState, shippingPostalCode) VALUES 
(1, 'ORD-2024-05-001', 1299.98, 'delivered', '123 Main Street', 'Mumbai', 'Maharashtra', '400001'),
(1, 'ORD-2024-05-002', 799.99, 'pending', '456 Secondary Road', 'Bangalore', 'Karnataka', '560001');

-- Insert Sample Order Items
INSERT INTO order_items (orderId, productId, quantity, priceAtOrder, totalPrice) VALUES 
(1, 1, 1, 899.99, 899.99),
(1, 4, 1, 149.99, 149.99),
(2, 2, 1, 799.99, 799.99);

-- Insert Sample Reviews
INSERT INTO reviews (productId, userId, rating, title, comment) VALUES 
(1, 1, 5, 'Excellent Product', 'Amazing phone with great features'),
(4, 1, 4, 'Good Sound Quality', 'Very good headphones, comfortable to wear');

-- Insert Sample Wishlist
INSERT INTO wishlist (userId, productId) VALUES 
(1, 3),
(1, 7);

-- Display all data to verify
SELECT 'Users' as table_name;
SELECT COUNT(*) as count FROM users;

SELECT 'Products' as table_name;
SELECT COUNT(*) as count FROM products;

SELECT 'Orders' as table_name;
SELECT COUNT(*) as count FROM orders;
