# Database Schema - SQL (MySQL)

## Create Tables

```sql
-- Users Table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    firstName VARCHAR(100) NOT NULL,
    lastName VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(15),
    profileImage VARCHAR(500),
    isAdmin BOOLEAN DEFAULT FALSE,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email)
);

-- Categories Table
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) UNIQUE NOT NULL,
    description TEXT,
    image VARCHAR(500),
    parentCategoryId INT,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (parentCategoryId) REFERENCES categories(id) ON DELETE SET NULL
);

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
    isActive BOOLEAN DEFAULT TRUE,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (categoryId) REFERENCES categories(id) ON DELETE CASCADE,
    INDEX idx_category (categoryId),
    INDEX idx_price (price),
    INDEX idx_active (isActive)
);

-- Product Images Table
CREATE TABLE product_images (
    id INT PRIMARY KEY AUTO_INCREMENT,
    productId INT NOT NULL,
    imageUrl VARCHAR(500) NOT NULL,
    displayOrder INT DEFAULT 0,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (productId) REFERENCES products(id) ON DELETE CASCADE,
    INDEX idx_product (productId)
);

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
);

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
    shippingCountry VARCHAR(100),
    paymentId INT,
    notes TEXT,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (userId) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_orderNumber (orderNumber),
    INDEX idx_user (userId),
    INDEX idx_status (status),
    INDEX idx_date (createdAt)
);

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
);

-- Payments Table
CREATE TABLE payments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    orderId INT NOT NULL UNIQUE,
    paymentMethod ENUM('credit_card', 'debit_card', 'upi', 'net_banking', 'wallet') NOT NULL,
    transactionId VARCHAR(200) UNIQUE,
    amount DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'completed', 'failed', 'refunded') DEFAULT 'pending',
    paymentGateway VARCHAR(50),
    failureReason TEXT,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (orderId) REFERENCES orders(id) ON DELETE CASCADE,
    INDEX idx_status (status),
    INDEX idx_transaction (transactionId)
);

-- Reviews Table
CREATE TABLE reviews (
    id INT PRIMARY KEY AUTO_INCREMENT,
    productId INT NOT NULL,
    userId INT NOT NULL,
    rating INT CHECK (rating >= 1 AND rating <= 5) NOT NULL,
    title VARCHAR(200),
    comment TEXT,
    isVerified BOOLEAN DEFAULT FALSE,
    helpful INT DEFAULT 0,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (productId) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (userId) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_review (productId, userId),
    INDEX idx_product (productId),
    INDEX idx_rating (rating)
);

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
);

-- Addresses Table
CREATE TABLE addresses (
    id INT PRIMARY KEY AUTO_INCREMENT,
    userId INT NOT NULL,
    fullName VARCHAR(150) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    addressLine1 VARCHAR(255) NOT NULL,
    addressLine2 VARCHAR(255),
    city VARCHAR(100) NOT NULL,
    state VARCHAR(100) NOT NULL,
    postalCode VARCHAR(20) NOT NULL,
    country VARCHAR(100) NOT NULL,
    isDefault BOOLEAN DEFAULT FALSE,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (userId) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user (userId)
);
```

---

## Sample Data Insert

```sql
-- Insert Categories
INSERT INTO categories (name, description) VALUES 
('Electronics', 'Electronic gadgets and devices'),
('Mobiles', 'Mobile phones and accessories'),
('Fashion', 'Clothing, shoes, and accessories'),
('Home & Kitchen', 'Home appliances and kitchen items'),
('Books', 'Books and e-books'),
('Beauty & Personal Care', 'Beauty products and personal care items');

-- Insert Sample Products
INSERT INTO products (name, description, price, discountPrice, categoryId, mainImage, stock) VALUES 
('iPhone 15 Pro', 'Latest Apple iPhone 15 Pro with A17 Pro chip', 999.99, 899.99, 2, 'phone1.jpg', 50),
('Samsung Galaxy S24', 'High-end Android smartphone', 899.99, 799.99, 2, 'phone2.jpg', 60),
('Running Shoes', 'Comfortable running shoes', 79.99, 59.99, 3, 'shoes1.jpg', 100),
('Wireless Headphones', 'Noise cancelling wireless headphones', 199.99, 149.99, 1, 'headphones1.jpg', 40),
('Microwave Oven', 'Digital microwave oven 30L', 299.99, 249.99, 4, 'microwave1.jpg', 25);

-- Insert Sample User
INSERT INTO users (firstName, lastName, email, password, phone) VALUES 
('Raj', 'Kumar', 'raj@example.com', 'hashed_password_here', '9876543210');
```

---

## Key Relationships

```
users
  ├── cart (1:N)
  ├── orders (1:N)
  ├── reviews (1:N)
  ├── wishlist (1:N)
  └── addresses (1:N)

products
  ├── cart (1:N)
  ├── reviews (1:N)
  ├── wishlist (1:N)
  ├── product_images (1:N)
  └── order_items (1:N)

categories
  └── products (1:N)

orders
  ├── order_items (1:N)
  └── payments (1:1)
```

---

## Indexes for Performance

```
-- Frequently searched columns
INDEX idx_email (users.email)
INDEX idx_category (products.categoryId)
INDEX idx_price (products.price)
INDEX idx_status (orders.status)
INDEX idx_rating (reviews.rating)
INDEX idx_user (cart.userId)
```

---

## Notes

- All passwords should be hashed using bcrypt before storing
- Timestamps are automatically managed by MySQL
- Foreign keys maintain data integrity
- Indexes improve query performance
- Use transactions for multi-step operations (e.g., creating orders)

---

**Database Design Complete! ✅**
