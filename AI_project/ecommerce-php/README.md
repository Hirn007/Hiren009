# 🛒 FlipClone - E-Commerce Platform (PHP Version)

PHP main likha hua complete e-commerce website project

---

## 📁 Folder Structure

```
ecommerce-php/
│
├── public/                      # Web Root (XAMPP)
│   ├── index.php               # Main entry point
│   ├── .htaccess               # URL rewriting rules
│   ├── css/                    # CSS stylesheets
│   ├── js/                     # JavaScript files
│   ├── images/                 # Product images
│   └── uploads/                # User uploads
│
├── app/
│   ├── controllers/            # Controllers (optional)
│   ├── models/                 # Database models
│   │   ├── User.php           # User model
│   │   ├── Product.php        # Product model
│   │   ├── Cart.php           # Cart model
│   │   └── Order.php          # Order model
│   │
│   ├── views/                  # View templates
│   │   ├── layouts/
│   │   │   └── main.php       # Main layout template
│   │   ├── home.php           # Home page
│   │   ├── products/
│   │   │   ├── list.php       # Products listing
│   │   │   └── detail.php     # Product details
│   │   ├── cart/
│   │   │   └── index.php      # Shopping cart
│   │   ├── auth/
│   │   │   ├── login.php      # Login page
│   │   │   └── register.php   # Registration page
│   │   └── orders/            # Orders pages
│   │
│   └── helpers.php             # Helper functions
│
├── config/
│   ├── database.php           # Database configuration
│   ├── app.php                # App configuration
│   └── database_class.php     # Database connection class
│
├── database/
│   └── schema.sql             # Database schema
│
└── README.md                  # This file
```

---

## ⚙️ Setup Instructions

### Step 1: Copy to XAMPP

```bash
# Copy the ecommerce-php folder to XAMPP htdocs
cp -r ecommerce-php C:\xampp\htdocs\
```

### Step 2: Create Database

```sql
-- Create database
CREATE DATABASE ecommerce_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Use database
USE ecommerce_db;

-- Run schema
-- (See database/schema.sql)
```

Or run this in phpMyAdmin:
1. Open phpMyAdmin (http://localhost/phpmyadmin/)
2. Create new database: `ecommerce_db`
3. Import `database/schema.sql`

### Step 3: Configure Database

Edit `config/database.php`:

```php
return [
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',  // XAMPP default is empty
    'database' => 'ecommerce_db',
    'port' => 3306,
    'charset' => 'utf8mb4'
];
```

### Step 4: Start XAMPP

```bash
# Windows
C:\xampp\xampp-control.exe

# Start Apache and MySQL
```

### Step 5: Access Application

```
http://localhost/ecommerce-php/public/
```

---

## 🗄️ Database Schema

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
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Categories Table
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) UNIQUE NOT NULL,
    description TEXT,
    image VARCHAR(500),
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
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
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (categoryId) REFERENCES categories(id) ON DELETE CASCADE,
    INDEX idx_category (categoryId),
    INDEX idx_price (price)
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
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (userId) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user (userId),
    INDEX idx_status (status)
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
```

---

## 📝 Key Features Implemented

### ✅ Authentication
- User Registration
- User Login
- Session Management
- Password Hashing (bcrypt)

### ✅ Products
- View all products
- Product search
- Product filtering
- Product details page
- Stock management

### ✅ Shopping Cart
- Add to cart
- Update quantity
- Remove items
- View cart total

### ✅ Orders (Partial)
- Create orders
- View order history
- Order details

### ✅ Security
- SQL injection prevention (prepared statements)
- XSS protection (output escaping)
- CSRF tokens
- Password hashing
- Session management

---

## 🚀 Features to Add

### Phase 2
- [ ] Complete checkout process
- [ ] Payment integration (Razorpay)
- [ ] Order confirmation emails
- [ ] Order tracking

### Phase 3
- [ ] Product reviews & ratings
- [ ] Wishlist functionality
- [ ] User profile management
- [ ] Address management

### Phase 4
- [ ] Admin dashboard
- [ ] Product management
- [ ] Order management
- [ ] User management

### Phase 5
- [ ] Advanced search & filters
- [ ] Recommendations engine
- [ ] Analytics & reports
- [ ] Performance optimization

---

## 💻 Code Examples

### Register User

```php
<?php
$userModel = new User();
$result = $userModel->register(
    'John',
    'Doe',
    'john@example.com',
    'password123',
    '9876543210'
);

if ($result['success']) {
    echo "User registered successfully!";
}
?>
```

### Get Products

```php
<?php
$productModel = new Product();
$products = $productModel->getAllProducts(
    $page = 1,
    $limit = 20,
    $categoryId = null,
    $sortBy = 'rating',
    $order = 'DESC'
);

foreach ($products as $product) {
    echo $product['name'] . " - " . $product['price'];
}
?>
```

### Add to Cart

```php
<?php
if (isLoggedIn()) {
    $cartModel = new Cart();
    $cartModel->addItem(
        getCurrentUserId(),
        $productId = 1,
        $quantity = 1
    );
}
?>
```

---

## 🔑 Helper Functions

```php
// Check if user is logged in
isLoggedIn()

// Get current user ID
getCurrentUserId()

// Get current user object
getCurrentUser()

// Sanitize input
sanitize($input)

// Validate email
isValidEmail($email)

// Format price
formatPrice($price)

// Calculate discount
getDiscountPercent($original, $discounted)

// Redirect to page
redirect('page-name')

// Flash messages
setFlash('success', 'Message')
getFlash()

// Load model
loadModel('ModelName')
```

---

## 🗂️ Database Model Classes

### User Model
```php
$user = new User();

// Register
$user->register($firstName, $lastName, $email, $password, $phone);

// Login
$user->login($email, $password);

// Get user
$user->getUserById($userId);

// Update profile
$user->updateProfile($userId, $firstName, $lastName, $phone);

// Check email exists
$user->emailExists($email);
```

### Product Model
```php
$product = new Product();

// Get all products
$product->getAllProducts($page, $limit, $categoryId, $sortBy, $order);

// Get by ID
$product->getProductById($productId);

// Search
$product->searchProducts($query);

// Get by category
$product->getByCategory($categoryId);

// Featured products
$product->getFeaturedProducts();

// Create (admin)
$product->createProduct($name, $description, $price, $discountPrice, $categoryId, $stock);
```

### Cart Model
```php
$cart = new Cart();

// Get cart items
$cart->getCartItems($userId);

// Get total
$cart->getCartTotal($userId);

// Add item
$cart->addItem($userId, $productId, $quantity);

// Update quantity
$cart->updateQuantity($userId, $productId, $quantity);

// Remove item
$cart->removeItem($userId, $productId);

// Clear cart
$cart->clearCart($userId);

// Get count
$cart->getCartCount($userId);
```

### Order Model
```php
$order = new Order();

// Create order
$order->createOrder($userId, $totalAmount, $shippingAddress, $city, $state, $postalCode);

// Add order item
$order->addOrderItem($orderId, $productId, $quantity, $price, $totalPrice);

// Get user orders
$order->getUserOrders($userId);

// Get order details
$order->getOrderById($orderId);

// Get items
$order->getOrderItems($orderId);

// Update status
$order->updateStatus($orderId, $status);
```

---

## 🔄 URL Structure

```
Home Page:
http://localhost/ecommerce-php/public/?page=home

Products:
http://localhost/ecommerce-php/public/?page=products

Product Detail:
http://localhost/ecommerce-php/public/?page=product&id=1

Shopping Cart:
http://localhost/ecommerce-php/public/?page=cart

Login:
http://localhost/ecommerce-php/public/?page=login

Register:
http://localhost/ecommerce-php/public/?page=register

Profile:
http://localhost/ecommerce-php/public/?page=profile

Orders:
http://localhost/ecommerce-php/public/?page=orders
```

---

## ⚠️ Security Checklist

- ✅ Prepared statements (SQL injection prevention)
- ✅ Output escaping (XSS prevention)
- ✅ Password hashing (bcrypt)
- ✅ Session management
- ✅ Input validation
- ⚠️ TODO: CSRF tokens in forms
- ⚠️ TODO: HTTPS in production
- ⚠️ TODO: Rate limiting

---

## 🐛 Troubleshooting

### Database Connection Error
```
Error: Database Connection Failed

Solution:
1. Check XAMPP MySQL is running
2. Verify config/database.php credentials
3. Check database name is correct
```

### 404 Not Found
```
Error: Page not found

Solution:
1. Check mod_rewrite is enabled in Apache
2. Verify .htaccess file exists
3. Restart Apache
```

### Session not working
```
Error: User not logged in after login

Solution:
1. Check PHP session.save_path is writable
2. Verify cookies are enabled in browser
3. Check session.auto_start in php.ini
```

---

## 📚 File Descriptions

### Core Files
- **public/index.php** - Main entry point, router
- **config/database.php** - Database configuration
- **config/database_class.php** - Database connection class
- **app/helpers.php** - Helper functions

### Models
- **app/models/User.php** - User operations
- **app/models/Product.php** - Product operations
- **app/models/Cart.php** - Cart operations
- **app/models/Order.php** - Order operations

### Views
- **app/views/layouts/main.php** - Master layout
- **app/views/home.php** - Homepage
- **app/views/products/list.php** - Products listing
- **app/views/products/detail.php** - Product details
- **app/views/cart/index.php** - Shopping cart
- **app/views/auth/login.php** - Login page
- **app/views/auth/register.php** - Registration page

---

## 📊 Database Tables

| Table | Rows | Description |
|-------|------|-------------|
| users | - | User accounts |
| categories | - | Product categories |
| products | - | Product listings |
| cart | - | Shopping carts |
| orders | - | Customer orders |
| order_items | - | Order line items |

---

## 🎯 Next Steps

1. ✅ Setup XAMPP and database
2. ✅ Create folder structure
3. ✅ Build models and helpers
4. ✅ Create views and templates
5. ⏭️ Add checkout process
6. ⏭️ Integrate payment gateway
7. ⏭️ Build admin panel
8. ⏭️ Add advanced features

---

## 📞 API Routes (for future REST API)

```
POST   /api/auth/register
POST   /api/auth/login
GET    /api/products
GET    /api/products/:id
GET    /api/cart
POST   /api/cart
PUT    /api/cart/:id
DELETE /api/cart/:id
POST   /api/orders
GET    /api/orders
GET    /api/orders/:id
```

---

## 🎓 Learning Resources

- [PHP Documentation](https://www.php.net/docs.php)
- [MySQL Tutorial](https://www.w3schools.com/mysql/)
- [Object Oriented PHP](https://www.w3schools.com/php/php_oop_intro.asp)
- [Security Best Practices](https://www.php.net/manual/en/security.php)

---

## 📝 Tips for Development

1. **Always use prepared statements** for database queries
2. **Escape output** to prevent XSS attacks
3. **Hash passwords** before storing
4. **Validate inputs** on both client and server
5. **Use transactions** for multi-step operations
6. **Log errors** for debugging
7. **Test thoroughly** before deployment
8. **Keep sensitive data** in environment variables

---

## ✨ Features Highlights

- 🔐 Secure authentication system
- 🛒 Full shopping cart functionality
- 📦 Order management system
- 🔍 Product search and filtering
- 💳 Payment-ready architecture
- 📱 Responsive design
- ⚡ Fast and efficient
- 🛡️ Security-focused code

---

## 🚀 Deployment

### XAMPP (Local)
```bash
http://localhost/ecommerce-php/public/
```

### Production Server (Apache)
```bash
1. Copy files to web root
2. Set permissions (755 for folders, 644 for files)
3. Create database
4. Update config files
5. Enable mod_rewrite
6. Set HTTPS
7. Update app_url in config
```

---

## 📄 License

This project is for educational purposes. Feel free to modify and use.

---

**Created:** May 23, 2024
**Version:** 1.0.0
**Status:** Active Development

Happy Coding! 🎉
