<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AutoFix HelpDesk</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-body">
    <div class="login-container">
        <div class="login-header">
            <h2>AutoFix HelpDesk</h2>
            <p>Sign in to manage tickets</p>
        </div>
        <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-error">Invalid login attempt.</div>
        <?php endif; ?>
        <?php if(isset($_GET['logout'])): ?>
            <div class="alert alert-success">Logged out successfully.</div>
        <?php endif; ?>
        <form action="login_action.php" method="POST" id="loginForm">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required placeholder="Enter any username">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Enter any password">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
        </form>
    </div>
</body>
</html>
