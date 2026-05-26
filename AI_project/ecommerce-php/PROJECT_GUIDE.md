# PHP E-Commerce Project Structure Guide

## 📁 Complete Folder Structure Created

```
C:\xampp\htdocs\php_2025\AI_project\ecommerce-php/
│
├── 📂 public/                          # Web Root (Server entry point)
│   ├── index.php                       # Main router file
│   ├── .htaccess                       # URL rewriting rules
│   ├── 📂 css/                         # Stylesheets
│   ├── 📂 js/                          # JavaScript files
│   ├── 📂 images/                      # Product images
│   └── 📂 uploads/                     # User uploads
│
├── 📂 app/                             # Application logic
│   ├── helpers.php                     # Helper functions
│   │
│   ├── 📂 models/                      # Database models (MVC pattern)
│   │   ├── User.php                    # User operations
│   │   ├── Product.php                 # Product operations
│   │   ├── Cart.php                    # Shopping cart
│   │   └── Order.php                   # Order management
│   │
│   ├── 📂 controllers/                 # Controllers (for future use)
│   │
│   └── 📂 views/                       # HTML templates
│       ├── 📂 layouts/
│       │   └── main.php                # Master layout template
│       ├── home.php                    # Homepage
│       ├── 📂 products/
│       │   ├── list.php                # Products listing page
│       │   └── detail.php              # Product details page
│       ├── 📂 cart/
│       │   └── index.php               # Shopping cart page
│       ├── 📂 auth/
│       │   ├── login.php               # Login page
│       │   └── register.php            # Registration page
│       ├── 📂 orders/                  # Orders pages
│       └── profile.php                 # User profile page
│
├── 📂 config/                          # Configuration files
│   ├── database.php                    # Database credentials
│   ├── app.php                         # App settings
│   └── database_class.php              # Database connection class
│
├── 📂 database/                        # Database scripts
│   └── schema.sql                      # SQL schema & sample data
│
└── README.md                           # Documentation
```

---

## 🎯 Key Components

### 1. **Configuration Files** (`config/`)
- **database.php** - MySQL connection details
- **app.php** - Application settings (timezone, currency, etc.)
- **database_class.php** - Database connection handler

### 2. **Models** (`app/models/`)
Database interaction classes:
- **User.php** - Registration, login, profile
- **Product.php** - Product CRUD, search, filtering
- **Cart.php** - Add/remove items, totals
- **Order.php** - Order creation, tracking

### 3. **Views** (`app/views/`)
HTML templates:
- **layouts/main.php** - Header, footer, navbar
- **home.php** - Homepage with featured products
- **products/list.php** - Product catalog with pagination
- **products/detail.php** - Individual product page
- **cart/index.php** - Shopping cart
- **auth/login.php** - Login form
- **auth/register.php** - Registration form

### 4. **Helper Functions** (`app/helpers.php`)
Utility functions:
- `isLoggedIn()` - Check user session
- `sanitize()` - Input sanitization
- `formatPrice()` - Price formatting
- `redirect()` - Page redirection
- `setFlash()` / `getFlash()` - Flash messages

### 5. **Entry Point** (`public/index.php`)
Router that:
- Loads configuration
- Handles URL routing
- Loads models and helpers
- Renders templates

---

## 🚀 Quick Start

### Step 1: Database Setup
```bash
# Open phpMyAdmin
http://localhost/phpmyadmin/

# Create database
CREATE DATABASE ecommerce_db;

# Import schema
Open database/schema.sql and run all queries
```

### Step 2: Configure Database
Edit `config/database.php`:
```php
return [
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',  // XAMPP default
    'database' => 'ecommerce_db',
    'port' => 3306,
    'charset' => 'utf8mb4'
];
```

### Step 3: Access Application
```
http://localhost/php_2025/AI_project/ecommerce-php/public/
```

---

## 📝 Implemented Features

### ✅ Authentication System
- User registration with validation
- Secure login with password hashing
- Session management
- Helper functions for user checks

### ✅ Product Management
- View all products with pagination
- Product filtering by category
- Product search functionality
- Detailed product page
- Stock management
- Rating and reviews count

### ✅ Shopping Cart
- Add items to cart
- Update quantities
- Remove items
- View cart total
- Prevent duplicate items

### ✅ Order System (Partial)
- Create orders from cart
- View order history
- Order status tracking

### ✅ Security Features
- SQL injection prevention (prepared statements)
- XSS protection (HTML escaping)
- Password hashing (bcrypt)
- Session validation
- CSRF token support

### ✅ User Interface
- Responsive design
- Product grid layout
- Navigation menu
- Flash messages
- Form validation

---

## 🔌 Database Models

### User Model Methods
```php
register()          // Create new user
login()            // Authenticate user
getUserById()      // Fetch user data
updateProfile()    // Update user info
emailExists()      // Check email availability
```

### Product Model Methods
```php
getAllProducts()   // Get products with pagination
getProductById()   // Get single product
searchProducts()   // Search functionality
getByCategory()    // Filter by category
getFeaturedProducts() // Get top products
getTotalCount()    // Get total products
```

### Cart Model Methods
```php
getCartItems()     // Get user's cart
getCartTotal()     // Calculate total
addItem()         // Add product to cart
updateQuantity()  // Change quantity
removeItem()      // Delete from cart
clearCart()       // Empty cart
getCartCount()    // Item count
```

### Order Model Methods
```php
createOrder()     // Create new order
addOrderItem()    // Add items to order
getUserOrders()   // Get user's orders
getOrderById()    // Get order details
getOrderItems()   // Get order items
updateStatus()    // Update order status
```

---

## 🔄 URL Routing

```
/?page=home                 → Homepage
/?page=products            → Products listing
/?page=product&id=1        → Product details
/?page=cart                → Shopping cart
/?page=login               → Login page
/?page=register            → Registration page
/?page=profile             → User profile
/?page=orders              → Order history
```

---

## 🛡️ Security Implementation

### SQL Injection Prevention
```php
// Using prepared statements
$stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param('s', $email);
$stmt->execute();
```

### XSS Protection
```php
// Output escaping
echo sanitize($user_input);
echo htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
```

### Password Security
```php
// Hashing
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Verification
password_verify($inputPassword, $hashedPassword)
```

---

## 📊 Database Schema

**8 Tables Created:**
1. **users** - User accounts
2. **categories** - Product categories
3. **products** - Product listings
4. **product_images** - Multiple images per product
5. **cart** - Shopping cart items
6. **orders** - Customer orders
7. **order_items** - Order line items
8. **reviews** - Product reviews
9. **wishlist** - User wishlists

---

## 🎓 How to Extend

### Add New Page
```php
1. Create view in app/views/
2. Add route in public/index.php
3. Create model if needed
4. Use helper functions
```

### Add New Model
```php
1. Create class in app/models/
2. Extend with database methods
3. Use Database singleton
4. Return formatted results
```

### Add New Feature
```php
1. Design database schema
2. Create database migrations
3. Build model class
4. Create views
5. Add routes
6. Implement security
```

---

## ⚠️ Things to Remember

- Always use prepared statements
- Sanitize all inputs
- Hash passwords with bcrypt
- Validate on server-side
- Use SSL/HTTPS in production
- Never expose sensitive data
- Keep credentials in config files
- Log errors for debugging

---

## 📚 File Descriptions

| File | Purpose |
|------|---------|
| index.php | Main router and entry point |
| helpers.php | Utility functions |
| User.php | User database operations |
| Product.php | Product database operations |
| Cart.php | Shopping cart operations |
| Order.php | Order management |
| main.php | Layout template |
| home.php | Homepage template |
| database.php | DB configuration |
| schema.sql | Database structure |

---

## 🚀 Next Steps

1. ✅ Database setup
2. ✅ Folder structure
3. ✅ Core models created
4. ✅ Views implemented
5. ⏭️ Payment integration
6. ⏭️ Admin panel
7. ⏭️ Email notifications
8. ⏭️ Advanced features

---

## 💡 Tips for Development

1. **Use Models** - Keep database logic separated
2. **Template Reuse** - Use layouts for consistency
3. **Error Handling** - Always check results
4. **Security First** - Validate everything
5. **Comments** - Document your code
6. **Testing** - Test each feature
7. **Logging** - Log errors for debugging
8. **Performance** - Use indexes in database

---

**Project Status: Basic Features Complete ✅**
Ready for checkout, payment, and admin features!

---

Created: May 23, 2024
Version: 1.0.0
License: Educational Use
