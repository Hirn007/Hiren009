# E-Commerce Development Setup Guide

## 🚀 Quick Start Guide

### Prerequisites
- Node.js (v14 or higher)
- npm or yarn
- Git
- MySQL/MongoDB
- Code Editor (VS Code recommended)
- Postman (for API testing)

---

## 📦 Frontend Setup (React)

### Step 1: Create React App
```bash
npx create-react-app ecommerce-frontend
cd ecommerce-frontend
```

### Step 2: Install Dependencies
```bash
npm install axios react-router-dom redux react-redux redux-thunk
npm install tailwindcss postcss autoprefixer
npm install react-icons
npm install -D tailwindcss postcss autoprefixer
```

### Step 3: Folder Structure
```bash
mkdir -p src/{components,pages,services,context,styles}
```

### Step 4: Run Development Server
```bash
npm start
```

---

## 🔧 Backend Setup (Node.js/Express)

### Step 1: Initialize Project
```bash
mkdir ecommerce-backend
cd ecommerce-backend
npm init -y
```

### Step 2: Install Dependencies
```bash
npm install express cors dotenv mongoose bcryptjs jsonwebtoken
npm install cloudinary multer axios
npm install nodemailer
npm install --save-dev nodemon
```

### Step 3: Create Folder Structure
```bash
mkdir -p {config,controllers,models,routes,middleware,utils}
touch server.js .env
```

### Step 4: Setup .env File
```env
PORT=5000
NODE_ENV=development

# Database
MONGODB_URI=mongodb://localhost:27017/ecommerce
# OR for MySQL
DB_HOST=localhost
DB_USER=root
DB_PASSWORD=password
DB_NAME=ecommerce_db

# JWT
JWT_SECRET=your_super_secret_jwt_key_here_change_in_production
JWT_EXPIRE=7d

# Cloudinary (Image Upload)
CLOUDINARY_NAME=your_cloudinary_name
CLOUDINARY_API_KEY=your_api_key
CLOUDINARY_API_SECRET=your_api_secret

# Email Service
EMAIL_USER=your_email@gmail.com
EMAIL_PASSWORD=your_app_password

# Payment Gateway (Razorpay)
RAZORPAY_KEY_ID=your_key_id
RAZORPAY_KEY_SECRET=your_key_secret

# Frontend URL
FRONTEND_URL=http://localhost:3000
```

### Step 5: Create Basic Server
```javascript
// server.js
const express = require('express');
const cors = require('cors');
require('dotenv').config();

const app = express();

// Middleware
app.use(cors());
app.use(express.json());

// Routes
app.use('/api/auth', require('./routes/auth'));
app.use('/api/products', require('./routes/products'));
app.use('/api/cart', require('./routes/cart'));
app.use('/api/orders', require('./routes/orders'));

// Error Handler
app.use((err, req, res, next) => {
    console.error(err.stack);
    res.status(500).json({ error: 'Something went wrong!' });
});

const PORT = process.env.PORT || 5000;
app.listen(PORT, () => {
    console.log(`Server running on port ${PORT}`);
});
```

### Step 6: Update package.json scripts
```json
{
  "scripts": {
    "start": "node server.js",
    "dev": "nodemon server.js"
  }
}
```

### Step 7: Run Backend
```bash
npm run dev
```

---

## 🗄️ Database Setup

### MySQL Setup
```bash
# Login to MySQL
mysql -u root -p

# Create Database
CREATE DATABASE ecommerce_db;
USE ecommerce_db;

# Run the schema file
source DATABASE_SCHEMA.sql;
```

### MongoDB Setup
```bash
# If using MongoDB locally
mongod

# Or use MongoDB Atlas (Cloud)
# Connection string: mongodb+srv://username:password@cluster.mongodb.net/dbname
```

---

## 🔐 Authentication Implementation

### User Registration
```javascript
// POST /api/auth/register
{
    "firstName": "John",
    "lastName": "Doe",
    "email": "john@example.com",
    "password": "password123",
    "phone": "9876543210"
}
```

### User Login
```javascript
// POST /api/auth/login
{
    "email": "john@example.com",
    "password": "password123"
}

// Response
{
    "token": "jwt_token_here",
    "user": {
        "id": 1,
        "firstName": "John",
        "email": "john@example.com"
    }
}
```

---

## 📱 Frontend Components (React)

### Header Component
```jsx
import React from 'react';
import { Link } from 'react-router-dom';

function Header() {
    return (
        <header className="bg-blue-600 text-white p-4">
            <div className="container mx-auto flex justify-between items-center">
                <Link to="/" className="text-2xl font-bold">
                    FlipClone
                </Link>
                <nav className="space-x-6">
                    <Link to="/">Home</Link>
                    <Link to="/cart">Cart</Link>
                    <Link to="/profile">Profile</Link>
                </nav>
            </div>
        </header>
    );
}

export default Header;
```

### Product Card Component
```jsx
import React from 'react';
import { Link } from 'react-router-dom';

function ProductCard({ product }) {
    return (
        <div className="border rounded-lg overflow-hidden shadow-md hover:shadow-lg">
            <img 
                src={product.mainImage} 
                alt={product.name}
                className="w-full h-48 object-cover"
            />
            <div className="p-4">
                <h3 className="font-bold text-lg">{product.name}</h3>
                <div className="flex justify-between items-center mt-2">
                    <div>
                        <span className="text-red-500 line-through mr-2">
                            ₹{product.price}
                        </span>
                        <span className="text-green-600 font-bold">
                            ₹{product.discountPrice}
                        </span>
                    </div>
                    <span className="bg-yellow-400 px-2 py-1 rounded">
                        ⭐ {product.rating}
                    </span>
                </div>
                <button className="mt-4 w-full bg-orange-500 text-white py-2 rounded hover:bg-orange-600">
                    Add to Cart
                </button>
            </div>
        </div>
    );
}

export default ProductCard;
```

---

## 🧪 Testing the API

### Using Postman

#### Test Registration
```
POST: http://localhost:5000/api/auth/register
Body (JSON):
{
    "firstName": "John",
    "lastName": "Doe",
    "email": "john@example.com",
    "password": "password123",
    "phone": "9876543210"
}
```

#### Test Login
```
POST: http://localhost:5000/api/auth/login
Body (JSON):
{
    "email": "john@example.com",
    "password": "password123"
}
```

#### Test Get Products
```
GET: http://localhost:5000/api/products
Headers:
Authorization: Bearer {jwt_token}
```

---

## 🔄 Git Workflow

```bash
# Initialize Git
git init

# Create .gitignore
echo "node_modules/" > .gitignore
echo ".env" >> .gitignore
echo "dist/" >> .gitignore

# Initial commit
git add .
git commit -m "Initial commit: E-commerce project setup"

# Create branches
git checkout -b feature/auth
git checkout -b feature/products
git checkout -b feature/cart
```

---

## 📋 Development Checklist

### Week 1: Setup & Auth
- [ ] Project structure created
- [ ] Database schema set up
- [ ] Backend server running
- [ ] Frontend React app running
- [ ] User registration working
- [ ] User login working
- [ ] JWT authentication implemented

### Week 2: Products
- [ ] Product CRUD operations
- [ ] Product listing page
- [ ] Product details page
- [ ] Search functionality
- [ ] Category filtering
- [ ] Product image upload

### Week 3: Cart & Orders
- [ ] Add to cart functionality
- [ ] Cart page UI
- [ ] Cart calculations (total, discount)
- [ ] Order creation
- [ ] Order history

### Week 4: Checkout & Payment
- [ ] Checkout page design
- [ ] Address management
- [ ] Payment gateway integration
- [ ] Order confirmation
- [ ] Email notifications

### Week 5+: Admin & Polish
- [ ] Admin dashboard
- [ ] Admin product management
- [ ] Order management
- [ ] User reviews
- [ ] Wishlist feature
- [ ] Performance optimization

---

## 🚀 Deployment

### Deploy Backend (Heroku)
```bash
# Install Heroku CLI
npm install -g heroku

# Login
heroku login

# Create app
heroku create your-app-name

# Deploy
git push heroku main
```

### Deploy Frontend (Vercel)
```bash
# Install Vercel CLI
npm install -g vercel

# Deploy
vercel
```

---

## 📚 Useful Resources

- [Express.js Documentation](https://expressjs.com/)
- [React Documentation](https://react.dev/)
- [MongoDB Documentation](https://docs.mongodb.com/)
- [Tailwind CSS](https://tailwindcss.com/)
- [JWT Documentation](https://jwt.io/)
- [Razorpay API](https://razorpay.com/docs/api/)

---

## ⚠️ Common Issues & Solutions

### CORS Error
```javascript
// Add to your Express server
const cors = require('cors');
app.use(cors({
    origin: process.env.FRONTEND_URL,
    credentials: true
}));
```

### MongoDB Connection Error
```javascript
// Make sure MongoDB is running
// Windows: mongodb server should be installed and running
// Check: mongosh in terminal
```

### JWT Token Expired
```javascript
// Implement refresh token logic
// Store refresh token in httpOnly cookie
```

---

## 🎯 Next Steps

1. Clone/fork this repository
2. Follow the setup steps
3. Start coding from Week 1 checklist
4. Test every feature before moving forward
5. Deploy when ready
6. Collect user feedback
7. Iterate and improve

---

**Happy Developing! 🎉**

For any issues or questions, create an issue or reach out to the team.
