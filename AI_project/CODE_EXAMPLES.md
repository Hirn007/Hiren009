# Frontend Components & Code Examples

Quick start code samples aur component structure ke liye!

---

## 🎨 Frontend Components Overview

### Layout Components
```
Header
├── Logo
├── Search Bar
├── Categories Menu
├── Cart Icon
├── Login/Profile
└── Notifications

Footer
├── About Links
├── Customer Service
├── Policies
├── Social Links
└── Newsletter

Navigation Sidebar
├── Categories
├── Brands
├── Filters (Price, Rating, Stock)
└── Sorting Options
```

### Product Components
```
Product Grid
└── Product Card (Repeating)
    ├── Image
    ├── Name
    ├── Price & Discount
    ├── Rating
    └── Add to Cart Button

Product Details Page
├── Image Gallery
├── Product Info
│   ├── Name
│   ├── Price
│   ├── Stock Status
│   └── Specifications
├── Reviews Section
├── Related Products
└── Add to Cart Form
```

### User Flow Components
```
Auth Components
├── Login Form
├── Registration Form
└── Forgot Password

Cart & Checkout
├── Cart Page
│   ├── Cart Items
│   ├── Quantity Controls
│   ├── Price Breakdown
│   └── Checkout Button
│
├── Checkout Page
│   ├── Shipping Address
│   ├── Payment Method Selection
│   ├── Order Review
│   └── Place Order Button
│
└── Order Confirmation
    ├── Order Details
    ├── Order Tracking
    └── Continue Shopping

User Profile
├── Profile Info
├── Orders History
├── Addresses
├── Reviews
└── Wishlist
```

---

## 💻 Code Examples

### 1. React Component - Product Card

```jsx
import React from 'react';
import { useDispatch } from 'react-redux';
import { Link } from 'react-router-dom';
import { addToCart } from '../redux/actions/cartActions';

function ProductCard({ product }) {
    const dispatch = useDispatch();
    const discount = Math.round(
        ((product.price - product.discountPrice) / product.price) * 100
    );

    const handleAddToCart = () => {
        dispatch(addToCart(product.id, 1));
        alert('Product added to cart!');
    };

    return (
        <div className="border rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300 bg-white">
            {/* Image Container */}
            <Link to={`/product/${product.id}`}>
                <div className="relative">
                    <img 
                        src={product.mainImage} 
                        alt={product.name}
                        className="w-full h-48 object-cover hover:scale-105 transition-transform duration-300"
                    />
                    {discount > 0 && (
                        <span className="absolute top-2 right-2 bg-red-600 text-white px-2 py-1 rounded text-sm font-bold">
                            {discount}% OFF
                        </span>
                    )}
                </div>
            </Link>

            {/* Content Container */}
            <div className="p-4">
                {/* Product Name */}
                <Link to={`/product/${product.id}`}>
                    <h3 className="font-bold text-lg truncate hover:text-blue-600">
                        {product.name}
                    </h3>
                </Link>

                {/* Rating */}
                <div className="flex items-center mt-2">
                    <span className="text-yellow-500">★</span>
                    <span className="ml-2 text-sm text-gray-600">
                        {product.rating} ({product.reviewCount} reviews)
                    </span>
                </div>

                {/* Price Section */}
                <div className="mt-3 flex items-center gap-2">
                    <span className="text-gray-500 line-through text-sm">
                        ₹{product.price.toFixed(2)}
                    </span>
                    <span className="text-green-600 font-bold text-lg">
                        ₹{product.discountPrice.toFixed(2)}
                    </span>
                </div>

                {/* Stock Status */}
                <div className="mt-3">
                    {product.stock > 0 ? (
                        <p className="text-green-600 text-sm font-semibold">
                            In Stock ({product.stock})
                        </p>
                    ) : (
                        <p className="text-red-600 text-sm font-semibold">
                            Out of Stock
                        </p>
                    )}
                </div>

                {/* Add to Cart Button */}
                <button 
                    onClick={handleAddToCart}
                    disabled={product.stock === 0}
                    className={`mt-4 w-full py-2 rounded font-bold transition-colors duration-300 ${
                        product.stock > 0 
                            ? 'bg-orange-500 hover:bg-orange-600 text-white cursor-pointer' 
                            : 'bg-gray-300 text-gray-600 cursor-not-allowed'
                    }`}
                >
                    {product.stock > 0 ? 'Add to Cart' : 'Out of Stock'}
                </button>
            </div>
        </div>
    );
}

export default ProductCard;
```

---

### 2. React Component - Shopping Cart

```jsx
import React, { useEffect } from 'react';
import { useSelector, useDispatch } from 'react-redux';
import { Link } from 'react-router-dom';
import { 
    removeFromCart, 
    updateCartQuantity 
} from '../redux/actions/cartActions';

function CartPage() {
    const dispatch = useDispatch();
    const cartItems = useSelector(state => state.cart.items);
    const cartTotal = useSelector(state => state.cart.total);

    const handleQuantityChange = (productId, newQuantity) => {
        if (newQuantity > 0) {
            dispatch(updateCartQuantity(productId, newQuantity));
        }
    };

    const handleRemove = (productId) => {
        dispatch(removeFromCart(productId));
    };

    if (cartItems.length === 0) {
        return (
            <div className="container mx-auto py-10 text-center">
                <h2 className="text-2xl font-bold mb-4">Your Cart is Empty</h2>
                <Link to="/" className="text-blue-600 hover:underline">
                    Continue Shopping
                </Link>
            </div>
        );
    }

    return (
        <div className="container mx-auto py-10">
            <h1 className="text-3xl font-bold mb-6">Shopping Cart</h1>

            <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {/* Cart Items */}
                <div className="lg:col-span-2">
                    <div className="border rounded-lg">
                        {cartItems.map(item => (
                            <div 
                                key={item.productId} 
                                className="flex gap-4 p-4 border-b last:border-b-0"
                            >
                                {/* Product Image */}
                                <img 
                                    src={item.mainImage}
                                    alt={item.productName}
                                    className="w-24 h-24 object-cover rounded"
                                />

                                {/* Product Details */}
                                <div className="flex-1">
                                    <h3 className="font-bold text-lg">
                                        {item.productName}
                                    </h3>
                                    <p className="text-gray-600">
                                        ₹{item.price.toFixed(2)}
                                    </p>

                                    {/* Quantity Control */}
                                    <div className="flex items-center gap-2 mt-3">
                                        <button 
                                            onClick={() => handleQuantityChange(
                                                item.productId, 
                                                item.quantity - 1
                                            )}
                                            className="border px-3 py-1 hover:bg-gray-100"
                                        >
                                            −
                                        </button>
                                        <span className="w-8 text-center">
                                            {item.quantity}
                                        </span>
                                        <button 
                                            onClick={() => handleQuantityChange(
                                                item.productId, 
                                                item.quantity + 1
                                            )}
                                            className="border px-3 py-1 hover:bg-gray-100"
                                        >
                                            +
                                        </button>
                                    </div>
                                </div>

                                {/* Price & Remove */}
                                <div className="text-right">
                                    <p className="font-bold text-lg">
                                        ₹{(item.price * item.quantity).toFixed(2)}
                                    </p>
                                    <button 
                                        onClick={() => handleRemove(item.productId)}
                                        className="text-red-600 hover:text-red-800 mt-2"
                                    >
                                        Remove
                                    </button>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>

                {/* Cart Summary */}
                <div className="border rounded-lg p-4 h-fit sticky top-4">
                    <h2 className="text-xl font-bold mb-4">Order Summary</h2>
                    
                    <div className="space-y-3 border-b pb-4 mb-4">
                        <div className="flex justify-between">
                            <span>Subtotal:</span>
                            <span>₹{cartTotal.toFixed(2)}</span>
                        </div>
                        <div className="flex justify-between">
                            <span>Shipping:</span>
                            <span className="text-green-600">Free</span>
                        </div>
                        <div className="flex justify-between">
                            <span>Tax:</span>
                            <span>₹{(cartTotal * 0.18).toFixed(2)}</span>
                        </div>
                    </div>

                    <div className="flex justify-between font-bold text-lg mb-6">
                        <span>Total:</span>
                        <span>₹{(cartTotal * 1.18).toFixed(2)}</span>
                    </div>

                    <Link to="/checkout">
                        <button className="w-full bg-orange-500 text-white py-3 rounded font-bold hover:bg-orange-600 transition-colors">
                            Proceed to Checkout
                        </button>
                    </Link>

                    <Link to="/">
                        <button className="w-full border py-2 mt-2 rounded font-semibold hover:bg-gray-100 transition-colors">
                            Continue Shopping
                        </button>
                    </Link>
                </div>
            </div>
        </div>
    );
}

export default CartPage;
```

---

### 3. Express Backend - Product Routes

```javascript
// routes/products.js
const express = require('express');
const router = express.Router();
const productController = require('../controllers/productController');
const authMiddleware = require('../middleware/auth');
const adminMiddleware = require('../middleware/admin');

// Public Routes
router.get('/', productController.getAllProducts);
router.get('/search', productController.searchProducts);
router.get('/:id', productController.getProductById);

// Protected Routes - Admin Only
router.post('/', 
    authMiddleware, 
    adminMiddleware, 
    productController.createProduct
);

router.put('/:id', 
    authMiddleware, 
    adminMiddleware, 
    productController.updateProduct
);

router.delete('/:id', 
    authMiddleware, 
    adminMiddleware, 
    productController.deleteProduct
);

module.exports = router;
```

---

### 4. Express Backend - Product Controller

```javascript
// controllers/productController.js
const Product = require('../models/Product');

// Get All Products with Filters
exports.getAllProducts = async (req, res) => {
    try {
        const { page = 1, limit = 20, sortBy = 'createdAt', order = 'desc', categoryId, minPrice, maxPrice } = req.query;

        // Build filter object
        const filter = {};
        if (categoryId) filter.categoryId = categoryId;
        if (minPrice || maxPrice) {
            filter.discountPrice = {};
            if (minPrice) filter.discountPrice.$gte = minPrice;
            if (maxPrice) filter.discountPrice.$lte = maxPrice;
        }

        // Calculate pagination
        const skip = (page - 1) * limit;

        // Get products
        const products = await Product.find(filter)
            .sort({ [sortBy]: order === 'asc' ? 1 : -1 })
            .skip(skip)
            .limit(parseInt(limit));

        // Get total count
        const total = await Product.countDocuments(filter);

        res.json({
            success: true,
            products,
            totalProducts: total,
            totalPages: Math.ceil(total / limit),
            currentPage: parseInt(page)
        });
    } catch (error) {
        res.status(500).json({ success: false, message: error.message });
    }
};

// Get Product By ID
exports.getProductById = async (req, res) => {
    try {
        const product = await Product.findById(req.params.id)
            .populate('reviews');

        if (!product) {
            return res.status(404).json({ 
                success: false, 
                message: 'Product not found' 
            });
        }

        res.json({ success: true, product });
    } catch (error) {
        res.status(500).json({ success: false, message: error.message });
    }
};

// Create Product (Admin)
exports.createProduct = async (req, res) => {
    try {
        const { name, description, price, discountPrice, categoryId, stock } = req.body;

        // Validate
        if (!name || !price || !categoryId) {
            return res.status(400).json({ 
                success: false, 
                message: 'Missing required fields' 
            });
        }

        const product = new Product({
            name,
            description,
            price,
            discountPrice: discountPrice || price,
            categoryId,
            stock: stock || 0
        });

        await product.save();

        res.status(201).json({ 
            success: true, 
            message: 'Product created successfully',
            product 
        });
    } catch (error) {
        res.status(500).json({ success: false, message: error.message });
    }
};

// Update Product (Admin)
exports.updateProduct = async (req, res) => {
    try {
        const { price, discountPrice, stock, isActive } = req.body;

        const product = await Product.findByIdAndUpdate(
            req.params.id,
            { price, discountPrice, stock, isActive },
            { new: true }
        );

        if (!product) {
            return res.status(404).json({ 
                success: false, 
                message: 'Product not found' 
            });
        }

        res.json({ 
            success: true, 
            message: 'Product updated successfully',
            product 
        });
    } catch (error) {
        res.status(500).json({ success: false, message: error.message });
    }
};

// Delete Product (Admin)
exports.deleteProduct = async (req, res) => {
    try {
        const product = await Product.findByIdAndDelete(req.params.id);

        if (!product) {
            return res.status(404).json({ 
                success: false, 
                message: 'Product not found' 
            });
        }

        res.json({ 
            success: true, 
            message: 'Product deleted successfully' 
        });
    } catch (error) {
        res.status(500).json({ success: false, message: error.message });
    }
};

// Search Products
exports.searchProducts = async (req, res) => {
    try {
        const { q } = req.query;

        if (!q) {
            return res.status(400).json({ 
                success: false, 
                message: 'Search query required' 
            });
        }

        const products = await Product.find({
            $or: [
                { name: { $regex: q, $options: 'i' } },
                { description: { $regex: q, $options: 'i' } }
            ]
        }).limit(10);

        res.json({ 
            success: true, 
            results: products,
            total: products.length 
        });
    } catch (error) {
        res.status(500).json({ success: false, message: error.message });
    }
};
```

---

### 5. Express Backend - Auth Middleware

```javascript
// middleware/auth.js
const jwt = require('jsonwebtoken');

const authMiddleware = (req, res, next) => {
    try {
        // Get token from header
        const token = req.headers.authorization?.split(' ')[1];

        if (!token) {
            return res.status(401).json({ 
                success: false, 
                message: 'No token provided' 
            });
        }

        // Verify token
        const decoded = jwt.verify(token, process.env.JWT_SECRET);
        
        // Attach user to request
        req.user = decoded;
        next();
    } catch (error) {
        if (error.name === 'TokenExpiredError') {
            return res.status(401).json({ 
                success: false, 
                message: 'Token expired' 
            });
        }
        res.status(401).json({ 
            success: false, 
            message: 'Invalid token' 
        });
    }
};

module.exports = authMiddleware;
```

---

### 6. React - API Service

```javascript
// services/api.js
import axios from 'axios';

const API_BASE_URL = process.env.REACT_APP_API_URL || 'http://localhost:5000/api';

const axiosInstance = axios.create({
    baseURL: API_BASE_URL,
    headers: {
        'Content-Type': 'application/json'
    }
});

// Add token to request headers
axiosInstance.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem('token');
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    (error) => Promise.reject(error)
);

// Handle response errors
axiosInstance.interceptors.response.use(
    (response) => response.data,
    (error) => {
        if (error.response?.status === 401) {
            localStorage.removeItem('token');
            window.location.href = '/login';
        }
        return Promise.reject(error);
    }
);

// Product APIs
export const productAPI = {
    getAll: (params) => axiosInstance.get('/products', { params }),
    getById: (id) => axiosInstance.get(`/products/${id}`),
    search: (query) => axiosInstance.get('/products/search', { params: { q: query } }),
    create: (data) => axiosInstance.post('/products', data),
    update: (id, data) => axiosInstance.put(`/products/${id}`, data),
    delete: (id) => axiosInstance.delete(`/products/${id}`)
};

// Auth APIs
export const authAPI = {
    register: (data) => axiosInstance.post('/auth/register', data),
    login: (data) => axiosInstance.post('/auth/login', data),
    logout: () => axiosInstance.post('/auth/logout'),
    getCurrentUser: () => axiosInstance.get('/auth/me')
};

// Cart APIs
export const cartAPI = {
    getCart: () => axiosInstance.get('/cart'),
    addItem: (data) => axiosInstance.post('/cart', data),
    updateItem: (itemId, data) => axiosInstance.put(`/cart/${itemId}`, data),
    removeItem: (itemId) => axiosInstance.delete(`/cart/${itemId}`),
    clearCart: () => axiosInstance.delete('/cart')
};

// Order APIs
export const orderAPI = {
    create: (data) => axiosInstance.post('/orders', data),
    getAll: (params) => axiosInstance.get('/orders', { params }),
    getById: (id) => axiosInstance.get(`/orders/${id}`),
    cancel: (id) => axiosInstance.put(`/orders/${id}/cancel`)
};

// Payment APIs
export const paymentAPI = {
    initiate: (data) => axiosInstance.post('/payments/initiate', data),
    verify: (data) => axiosInstance.post('/payments/verify', data)
};

export default axiosInstance;
```

---

### 7. React - Redux Action

```javascript
// redux/actions/cartActions.js
export const ADD_TO_CART = 'ADD_TO_CART';
export const REMOVE_FROM_CART = 'REMOVE_FROM_CART';
export const UPDATE_QUANTITY = 'UPDATE_QUANTITY';
export const CLEAR_CART = 'CLEAR_CART';

export const addToCart = (productId, quantity) => ({
    type: ADD_TO_CART,
    payload: { productId, quantity }
});

export const removeFromCart = (productId) => ({
    type: REMOVE_FROM_CART,
    payload: productId
});

export const updateQuantity = (productId, quantity) => ({
    type: UPDATE_QUANTITY,
    payload: { productId, quantity }
});

export const clearCart = () => ({
    type: CLEAR_CART
});
```

---

## 🚀 Getting Started

### 1. Frontend Setup
```bash
cd frontend
npm install
npm start
```

### 2. Backend Setup
```bash
cd backend
npm install
npm run dev
```

### 3. Start Coding!

Copy ye components ko apni project mein modify karke use karo.

---

## 📝 Tips

1. **Components Ko Reusable Banao** - Small, focused components likho
2. **Props Use Karo** - Data pass kro via props
3. **Error Handling** - Hamesha error cases handle kro
4. **Loading States** - User ko batao kab data load ho raha hai
5. **Responsive Design** - Mobile-first approach use kro
6. **Security** - Passwords hash kro, tokens store securely

---

**Happy Coding! 🎉**
