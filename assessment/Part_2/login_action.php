<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Allow ANY username and password combination as requested
    if (!empty($username) && !empty($password)) {
        $_SESSION['user_id'] = uniqid();
        $_SESSION['username'] = htmlspecialchars($username);
        header("Location: dashboard.php");
        exit;
    } else {
        header("Location: index.php?error=empty");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
?>
