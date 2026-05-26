<?php
/**
 * Test User and Fix Password
 */

$config = require '../config/database.php';

// Create connection
$mysqli = new mysqli(
    $config['host'],
    $config['username'],
    $config['password'],
    $config['database'],
    $config['port']
);

if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

// Check if test user exists
$stmt = $mysqli->prepare("SELECT id, email, password FROM users WHERE email = ?");
$email = 'raj@example.com';
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo "✓ User found: " . $user['email'] . "\n";
    echo "Current password hash: " . $user['password'] . "\n\n";
    
    // Generate correct hash for password "12345"
    $correctHash = password_hash("12345", PASSWORD_BCRYPT);
    echo "Correct password hash: " . $correctHash . "\n\n";
    
    // Update with correct hash
    $updateStmt = $mysqli->prepare("UPDATE users SET password = ? WHERE id = ?");
    $updateStmt->bind_param('si', $correctHash, $user['id']);
    
    if ($updateStmt->execute()) {
        echo "✓ Password updated successfully!\n";
        echo "Login with: raj@example.com / 12345\n";
    } else {
        echo "❌ Error updating password: " . $updateStmt->error . "\n";
    }
} else {
    echo "❌ Test user not found. Creating test user...\n";
    
    $password = password_hash("12345", PASSWORD_BCRYPT);
    $firstName = 'Raj';
    $lastName = 'Kumar';
    $phone = '9876543210';
    
    $insertStmt = $mysqli->prepare("
        INSERT INTO users (firstName, lastName, email, password, phone)
        VALUES (?, ?, ?, ?, ?)
    ");
    $insertStmt->bind_param('sssss', $firstName, $lastName, $email, $password, $phone);
    
    if ($insertStmt->execute()) {
        echo "✓ Test user created successfully!\n";
        echo "Login with: raj@example.com / 12345\n";
    } else {
        echo "❌ Error creating user: " . $insertStmt->error . "\n";
    }
}

$mysqli->close();
?>
