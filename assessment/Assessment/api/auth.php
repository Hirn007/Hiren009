<?php
/**
 * Smart Store API Suite
 * User Authentication Controller (Registration & Login)
 */

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/helpers/jwt_helper.php';
require_once __DIR__ . '/helpers/response.php';

// Initialize response settings (CORS, headers)
Response::init();

$method = $_SERVER['REQUEST_METHOD'];
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Establish Database Connection
$db = new Database();
$conn = $db->getConnection();

if ($method !== 'POST') {
    Response::error("Method not allowed. Use POST for authentication routes.", 405);
}

// Read raw JSON input
$input = json_decode(file_get_contents("php://input"), true);

if ($action === 'register') {
    handleRegister($conn, $input);
} elseif ($action === 'login') {
    handleLogin($conn, $input);
} else {
    Response::error("Invalid auth action. Available actions are 'register' and 'login'.", 400);
}

/**
 * Handle User Registration
 */
function handleRegister($conn, $input) {
    // 1. Validate Input
    if (empty($input['name']) || empty($input['email']) || empty($input['password'])) {
        Response::error("Validation Error: 'name', 'email', and 'password' are required.", 422);
    }

    $name = trim($input['name']);
    $email = trim($input['email']);
    $password = $input['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        Response::error("Validation Error: Invalid email format.", 422);
    }

    if (strlen($password) < 6) {
        Response::error("Validation Error: Password must be at least 6 characters long.", 422);
    }

    // 2. Check if email already exists
    try {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            Response::error("Unprocessable Entity: A user with this email address already exists.", 422);
        }

        // 3. Hash Password & Create User
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        
        $insert = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'customer')");
        $insert->execute([$name, $email, $hashed_password]);
        $new_user_id = $conn->lastInsertId();

        Response::success([
            "message" => "Registration successful! You can now log in.",
            "user" => [
                "id" => (int)$new_user_id,
                "name" => $name,
                "email" => $email,
                "role" => "customer"
            ]
        ], 21); // 201 Created

    } catch (PDOException $e) {
        Response::error("Database error occurred: " . $e->getMessage(), 500);
    }
}

/**
 * Handle User Login
 */
function handleLogin($conn, $input) {
    // 1. Validate Input
    if (empty($input['email']) || empty($input['password'])) {
        Response::error("Validation Error: 'email' and 'password' are required.", 422);
    }

    $email = trim($input['email']);
    $password = $input['password'];

    // 2. Fetch user
    try {
        $stmt = $conn->prepare("SELECT id, name, email, password, role FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password'])) {
            Response::error("Invalid credentials. Please check your email and password.", 401);
        }

        // 3. Generate JWT Token
        $token_payload = [
            "user_id" => (int)$user['id'],
            "name" => $user['name'],
            "email" => $user['email'],
            "role" => $user['role']
        ];

        // Token expires in 2 hours (7200 seconds)
        $token = JWTHelper::generate($token_payload, 7200);

        Response::success([
            "message" => "Login successful!",
            "token" => $token,
            "user" => [
                "id" => (int)$user['id'],
                "name" => $user['name'],
                "email" => $user['email'],
                "role" => $user['role']
            ]
        ], 200);

    } catch (PDOException $e) {
        Response::error("Database error occurred: " . $e->getMessage(), 500);
    }
}
