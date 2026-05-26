<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? sanitize($title) . ' - ' : ''; ?>FlipClone - E-Commerce</title>
    <link rel="stylesheet" href="<?php echo getConfig('app_url'); ?>/css/style.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            text-decoration: none;
            color: white;
        }

        nav {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            transition: opacity 0.3s;
        }

        nav a:hover {
            opacity: 0.8;
        }

        .search-box {
            flex: 1;
            max-width: 300px;
            margin: 0 2rem;
        }

        .search-box input {
            width: 100%;
            padding: 0.5rem;
            border: none;
            border-radius: 4px;
        }

        .cart-icon {
            position: relative;
            cursor: pointer;
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #ff6b6b;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
        }

        .main-content {
            padding: 2rem 0;
            min-height: 60vh;
        }

        footer {
            background-color: #333;
            color: white;
            padding: 2rem 0;
            margin-top: 3rem;
            text-align: center;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }

        .product-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: #f0f0f0;
        }

        .product-info {
            padding: 1rem;
        }

        .product-name {
            font-weight: bold;
            margin-bottom: 0.5rem;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .product-price {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .price-original {
            text-decoration: line-through;
            color: #999;
        }

        .price-current {
            font-weight: bold;
            color: #27ae60;
            font-size: 1.1rem;
        }

        .discount-badge {
            background: #ff6b6b;
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.75rem;
        }

        .rating {
            color: #ffc107;
            margin-bottom: 0.5rem;
        }

        .btn {
            padding: 0.75rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 0.9rem;
            width: 100%;
        }

        .btn-primary {
            background-color: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background-color: #5568d3;
        }

        .btn-success {
            background-color: #27ae60;
            color: white;
        }

        .btn-success:hover {
            background-color: #229954;
        }

        .btn-danger {
            background-color: #ff6b6b;
            color: white;
        }

        .btn-danger:hover {
            background-color: #ff5252;
        }

        .alert {
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin: 1rem 0;
        }

        table th {
            background-color: #667eea;
            color: white;
            padding: 1rem;
            text-align: left;
        }

        table td {
            padding: 1rem;
            border-bottom: 1px solid #ddd;
        }

        table tr:hover {
            background-color: #f5f5f5;
        }

        form {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        input, textarea, select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }

        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.3);
        }

        @media (max-width: 768px) {
            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            }

            nav {
                flex-direction: column;
                gap: 1rem;
            }

            .search-box {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
    <div class="container">
        <div class="header-content">
            <a href="<?php echo getConfig('app_url'); ?>/?page=home" class="logo">FlipClone</a>

        <nav>
             <a href="<?php echo getConfig('app_url'); ?>/?page=home">Home</a>

             <?php if (isset($_SESSION['user'])): ?>
             <a href="<?php echo getConfig('app_url'); ?>/?page=orders">My Orders</a>
             <a href="<?php echo getConfig('app_url'); ?>/?page=logout" onclick="return confirmLogout(event)" style="color: #ffdddd;">Logout</a>
             <?php else: ?>
            <a href="<?php echo getConfig('app_url'); ?>/?page=login">Login</a>
            <a href="<?php echo getConfig('app_url'); ?>/?page=register">Register</a>
            <?php endif; ?>

            <a href="<?php echo getConfig('app_url'); ?>/?page=cart" class="cart-icon">
             Cart
             <span class="cart-badge">
            <?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>
            </span>
               </a>
                  </nav>

        </div>
    </div>
</header>

    <!-- Flash Messages -->
    <?php if ($flash = getFlash()): ?>
        <div class="container">
            <div class="alert alert-<?php echo $flash['type']; ?>">
                <?php echo sanitize($flash['message']); ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <?php echo $content; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 FlipClone E-Commerce Platform. All rights reserved.</p>
        <p>Contact: support@flipclone.local</p>
    </footer>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    
    <!-- Flash Messages Handler -->
    <script>
        // Confirm Logout
        function confirmLogout(event) {
            event.preventDefault();
            Swal.fire({
                icon: 'question',
                title: 'Logout?',
                text: 'Are you sure you want to logout?',
                showCancelButton: true,
                confirmButtonColor: '#667eea',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Logout',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?php echo getConfig('app_url'); ?>/?page=logout';
                }
            });
            return false;
        }

        <?php if ($flash = getFlash()): ?>
            Swal.fire({
                icon: '<?php echo $flash['type'] === 'error' ? 'error' : ($flash['type'] === 'success' ? 'success' : 'info'); ?>',
                title: '<?php echo ucfirst($flash['type']); ?>',
                text: '<?php echo addslashes(sanitize($flash['message'])); ?>',
                confirmButtonColor: '#667eea',
                confirmButtonText: 'OK'
            });
        <?php endif; ?>
    </script>
</body>
</html>
