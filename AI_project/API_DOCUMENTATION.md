# API Documentation - E-Commerce Backend

## 📌 Base URL
```
http://localhost:5000/api
```

---

## 🔐 Authentication Endpoints

### 1. User Registration
```
POST /auth/register
Content-Type: application/json

Request Body:
{
    "firstName": "John",
    "lastName": "Doe",
    "email": "john@example.com",
    "password": "SecurePassword123",
    "phone": "9876543210"
}

Response (201 Created):
{
    "success": true,
    "message": "User registered successfully",
    "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
    "user": {
        "id": 1,
        "firstName": "John",
        "lastName": "Doe",
        "email": "john@example.com"
    }
}
```

### 2. User Login
```
POST /auth/login
Content-Type: application/json

Request Body:
{
    "email": "john@example.com",
    "password": "SecurePassword123"
}

Response (200 OK):
{
    "success": true,
    "message": "Login successful",
    "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
    "user": {
        "id": 1,
        "firstName": "John",
        "email": "john@example.com"
    }
}

Error (401 Unauthorized):
{
    "success": false,
    "message": "Invalid credentials"
}
```

### 3. Logout
```
POST /auth/logout
Headers:
Authorization: Bearer {token}

Response (200 OK):
{
    "success": true,
    "message": "Logged out successfully"
}
```

### 4. Get Current User
```
GET /auth/me
Headers:
Authorization: Bearer {token}

Response (200 OK):
{
    "success": true,
    "user": {
        "id": 1,
        "firstName": "John",
        "lastName": "Doe",
        "email": "john@example.com",
        "phone": "9876543210"
    }
}
```

---

## 📦 Product Endpoints

### 1. Get All Products
```
GET /products?page=1&limit=20&sortBy=price&order=asc&categoryId=2
Headers:
Authorization: Bearer {token}

Query Parameters:
- page: Page number (default: 1)
- limit: Items per page (default: 20)
- sortBy: Sort field (price, rating, createdAt)
- order: asc or desc
- categoryId: Filter by category
- search: Search in product name/description
- minPrice: Minimum price filter
- maxPrice: Maximum price filter

Response (200 OK):
{
    "success": true,
    "products": [
        {
            "id": 1,
            "name": "iPhone 15 Pro",
            "description": "Latest Apple iPhone...",
            "price": 999.99,
            "discountPrice": 899.99,
            "discount": "10%",
            "categoryId": 2,
            "mainImage": "image.jpg",
            "stock": 50,
            "rating": 4.5,
            "reviewCount": 150
        }
    ],
    "totalProducts": 100,
    "totalPages": 5,
    "currentPage": 1
}
```

### 2. Get Product Details
```
GET /products/:productId
Headers:
Authorization: Bearer {token}

Response (200 OK):
{
    "success": true,
    "product": {
        "id": 1,
        "name": "iPhone 15 Pro",
        "description": "Latest Apple iPhone with A17 Pro chip...",
        "price": 999.99,
        "discountPrice": 899.99,
        "categoryId": 2,
        "mainImage": "main_image.jpg",
        "images": [
            "image1.jpg",
            "image2.jpg",
            "image3.jpg"
        ],
        "stock": 50,
        "rating": 4.5,
        "reviewCount": 150,
        "reviews": [
            {
                "id": 1,
                "userId": 2,
                "userName": "Jane",
                "rating": 5,
                "title": "Excellent Phone",
                "comment": "Amazing quality and performance",
                "createdAt": "2024-05-20T10:30:00Z"
            }
        ],
        "specifications": {
            "processor": "A17 Pro",
            "ram": "8GB",
            "storage": "256GB"
        }
    }
}
```

### 3. Search Products
```
GET /products/search?q=iphone&category=2
Headers:
Authorization: Bearer {token}

Query Parameters:
- q: Search query
- category: Filter by category

Response (200 OK):
{
    "success": true,
    "results": [
        {
            "id": 1,
            "name": "iPhone 15 Pro",
            "price": 899.99,
            "mainImage": "image.jpg"
        }
    ],
    "total": 5
}
```

### 4. Create Product (Admin Only)
```
POST /products
Headers:
Authorization: Bearer {token}
Content-Type: application/json

Request Body:
{
    "name": "New Product",
    "description": "Product description",
    "price": 99.99,
    "discountPrice": 79.99,
    "categoryId": 1,
    "stock": 100
}

Response (201 Created):
{
    "success": true,
    "message": "Product created successfully",
    "product": {
        "id": 5,
        "name": "New Product",
        ...
    }
}
```

### 5. Update Product (Admin Only)
```
PUT /products/:productId
Headers:
Authorization: Bearer {token}
Content-Type: application/json

Request Body:
{
    "price": 89.99,
    "stock": 150
}

Response (200 OK):
{
    "success": true,
    "message": "Product updated successfully",
    "product": {...}
}
```

### 6. Delete Product (Admin Only)
```
DELETE /products/:productId
Headers:
Authorization: Bearer {token}

Response (200 OK):
{
    "success": true,
    "message": "Product deleted successfully"
}
```

---

## 🛒 Cart Endpoints

### 1. Get Cart
```
GET /cart
Headers:
Authorization: Bearer {token}

Response (200 OK):
{
    "success": true,
    "cart": {
        "id": 1,
        "userId": 1,
        "items": [
            {
                "id": 1,
                "productId": 1,
                "productName": "iPhone 15 Pro",
                "quantity": 1,
                "price": 899.99,
                "mainImage": "image.jpg",
                "totalPrice": 899.99
            }
        ],
        "totalItems": 1,
        "totalAmount": 899.99,
        "discount": 0,
        "finalAmount": 899.99
    }
}
```

### 2. Add to Cart
```
POST /cart
Headers:
Authorization: Bearer {token}
Content-Type: application/json

Request Body:
{
    "productId": 1,
    "quantity": 1
}

Response (201 Created):
{
    "success": true,
    "message": "Product added to cart",
    "cartItem": {
        "id": 1,
        "productId": 1,
        "quantity": 1,
        "price": 899.99
    }
}
```

### 3. Update Cart Item
```
PUT /cart/:cartItemId
Headers:
Authorization: Bearer {token}
Content-Type: application/json

Request Body:
{
    "quantity": 2
}

Response (200 OK):
{
    "success": true,
    "message": "Cart updated",
    "cartItem": {...}
}
```

### 4. Remove from Cart
```
DELETE /cart/:cartItemId
Headers:
Authorization: Bearer {token}

Response (200 OK):
{
    "success": true,
    "message": "Item removed from cart"
}
```

### 5. Clear Cart
```
DELETE /cart
Headers:
Authorization: Bearer {token}

Response (200 OK):
{
    "success": true,
    "message": "Cart cleared"
}
```

---

## 📋 Order Endpoints

### 1. Create Order
```
POST /orders
Headers:
Authorization: Bearer {token}
Content-Type: application/json

Request Body:
{
    "shippingAddressId": 1,
    "paymentMethod": "credit_card",
    "notes": "Deliver after 5 PM"
}

Response (201 Created):
{
    "success": true,
    "message": "Order created successfully",
    "order": {
        "id": 1,
        "orderNumber": "ORD-2024-001",
        "userId": 1,
        "totalAmount": 899.99,
        "status": "pending",
        "items": [
            {
                "productId": 1,
                "productName": "iPhone 15 Pro",
                "quantity": 1,
                "price": 899.99
            }
        ],
        "createdAt": "2024-05-23T10:30:00Z"
    }
}
```

### 2. Get All Orders (User)
```
GET /orders?page=1&status=delivered
Headers:
Authorization: Bearer {token}

Query Parameters:
- page: Page number
- status: Filter by status (pending, confirmed, shipped, delivered)

Response (200 OK):
{
    "success": true,
    "orders": [
        {
            "id": 1,
            "orderNumber": "ORD-2024-001",
            "totalAmount": 899.99,
            "status": "delivered",
            "createdAt": "2024-05-23T10:30:00Z",
            "itemCount": 1
        }
    ],
    "totalOrders": 5,
    "totalPages": 1
}
```

### 3. Get Order Details
```
GET /orders/:orderId
Headers:
Authorization: Bearer {token}

Response (200 OK):
{
    "success": true,
    "order": {
        "id": 1,
        "orderNumber": "ORD-2024-001",
        "userId": 1,
        "totalAmount": 899.99,
        "status": "delivered",
        "shippingAddress": "123 Main St...",
        "items": [
            {
                "productId": 1,
                "productName": "iPhone 15 Pro",
                "quantity": 1,
                "priceAtOrder": 899.99,
                "totalPrice": 899.99
            }
        ],
        "payment": {
            "status": "completed",
            "method": "credit_card",
            "transactionId": "txn_123456"
        },
        "timeline": [
            {
                "status": "confirmed",
                "timestamp": "2024-05-23T10:35:00Z"
            },
            {
                "status": "shipped",
                "timestamp": "2024-05-24T15:00:00Z"
            }
        ],
        "createdAt": "2024-05-23T10:30:00Z"
    }
}
```

### 4. Cancel Order
```
PUT /orders/:orderId/cancel
Headers:
Authorization: Bearer {token}

Response (200 OK):
{
    "success": true,
    "message": "Order cancelled successfully"
}
```

### 5. Update Order Status (Admin)
```
PUT /orders/:orderId/status
Headers:
Authorization: Bearer {token}
Content-Type: application/json

Request Body:
{
    "status": "shipped",
    "trackingNumber": "TRACK123"
}

Response (200 OK):
{
    "success": true,
    "message": "Order status updated"
}
```

---

## 💳 Payment Endpoints

### 1. Initiate Payment
```
POST /payments/initiate
Headers:
Authorization: Bearer {token}
Content-Type: application/json

Request Body:
{
    "orderId": 1,
    "amount": 899.99,
    "paymentMethod": "credit_card"
}

Response (200 OK):
{
    "success": true,
    "paymentUrl": "https://checkout.razorpay.com/...",
    "orderId": "order_123456",
    "amount": 899.99
}
```

### 2. Verify Payment
```
POST /payments/verify
Headers:
Authorization: Bearer {token}
Content-Type: application/json

Request Body:
{
    "razorpay_order_id": "order_123456",
    "razorpay_payment_id": "pay_123456",
    "razorpay_signature": "signature_hash"
}

Response (200 OK):
{
    "success": true,
    "message": "Payment verified successfully",
    "orderId": 1,
    "status": "completed"
}
```

---

## 👤 User Endpoints

### 1. Get Profile
```
GET /users/profile
Headers:
Authorization: Bearer {token}

Response (200 OK):
{
    "success": true,
    "user": {
        "id": 1,
        "firstName": "John",
        "lastName": "Doe",
        "email": "john@example.com",
        "phone": "9876543210",
        "profileImage": "profile.jpg"
    }
}
```

### 2. Update Profile
```
PUT /users/profile
Headers:
Authorization: Bearer {token}
Content-Type: application/json

Request Body:
{
    "firstName": "John",
    "phone": "9876543210"
}

Response (200 OK):
{
    "success": true,
    "message": "Profile updated successfully"
}
```

### 3. Add Address
```
POST /users/addresses
Headers:
Authorization: Bearer {token}
Content-Type: application/json

Request Body:
{
    "fullName": "John Doe",
    "phone": "9876543210",
    "addressLine1": "123 Main Street",
    "city": "New York",
    "state": "NY",
    "postalCode": "10001",
    "country": "USA",
    "isDefault": true
}

Response (201 Created):
{
    "success": true,
    "address": {...}
}
```

### 4. Get Addresses
```
GET /users/addresses
Headers:
Authorization: Bearer {token}

Response (200 OK):
{
    "success": true,
    "addresses": [
        {
            "id": 1,
            "fullName": "John Doe",
            "addressLine1": "123 Main Street",
            "city": "New York",
            "isDefault": true
        }
    ]
}
```

---

## ⭐ Review Endpoints

### 1. Add Review
```
POST /reviews
Headers:
Authorization: Bearer {token}
Content-Type: application/json

Request Body:
{
    "productId": 1,
    "rating": 5,
    "title": "Excellent Product",
    "comment": "Very satisfied with this product"
}

Response (201 Created):
{
    "success": true,
    "message": "Review added successfully",
    "review": {...}
}
```

### 2. Get Product Reviews
```
GET /reviews/product/:productId?page=1&limit=10&sortBy=recent
Headers:
Authorization: Bearer {token}

Response (200 OK):
{
    "success": true,
    "reviews": [
        {
            "id": 1,
            "productId": 1,
            "userId": 2,
            "userName": "Jane",
            "rating": 5,
            "title": "Excellent",
            "comment": "Very satisfied",
            "createdAt": "2024-05-20T10:30:00Z"
        }
    ],
    "averageRating": 4.5,
    "totalReviews": 150
}
```

---

## ❌ Error Responses

### 400 Bad Request
```json
{
    "success": false,
    "message": "Validation error",
    "errors": {
        "email": "Invalid email format"
    }
}
```

### 401 Unauthorized
```json
{
    "success": false,
    "message": "No token provided or token expired"
}
```

### 403 Forbidden
```json
{
    "success": false,
    "message": "You don't have permission to access this resource"
}
```

### 404 Not Found
```json
{
    "success": false,
    "message": "Resource not found"
}
```

### 500 Internal Server Error
```json
{
    "success": false,
    "message": "Internal server error"
}
```

---

## 🔑 Token Format

All authenticated requests require the token in the Authorization header:

```
Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MSwiZW1haWwiOiJqb2huQGV4YW1wbGUuY29tIiwiaWF0IjoxNjE2MjM5MDIyLCJleHAiOjE2MTYzMjU0MjJ9.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c
```

---

## 📝 Rate Limiting

```
Rate Limit: 100 requests per 15 minutes per IP
Headers:
X-RateLimit-Limit: 100
X-RateLimit-Remaining: 99
X-RateLimit-Reset: 1234567890
```

---

**API Documentation Complete! ✅**
