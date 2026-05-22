<?php
/**
 * Smart Store API Suite
 * Users Controller (Profile Management)
 * 
 * Routes:
 * - GET /api/users.php -> View profile of authenticated user (Protected, JWT required)
 * - PUT /api/users.php -> Update profile of authenticated user (Protected, JWT required)
 */

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/helpers/response.php';
require_once __DIR__ . '/middleware/auth.php';

// Initialize response settings (CORS, headers)
Response::init();

$method = $_SERVER['REQUEST_METHOD'];

// Establish Database Connection
$db = new Database();
$conn = $db->getConnection();

// All user routes require JWT authentication
$currentUser = AuthMiddleware::authenticate();
$user_id = $currentUser['user_id'];

switch ($method) {
    case 'GET':
        handleGetProfile($conn, $user_id);
        break;

    case 'PUT':
        handleUpdateProfile($conn, $user_id);
        break;

    default:
        Response::error("Method Not Allowed. Supported verbs for this endpoint are GET and PUT.", 405);
        break;
}

/**
 * GET: Retrieve authenticated user's profile
 */
function handleGetProfile($conn, $user_id) {
    try {
        $stmt = $conn->prepare("SELECT id, name, email, role, created_at FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();

        if (!$user) {
            Response::error("User account not found.", 404);
        }

        $user['id'] = (int)$user['id'];
        Response::success($user, 200);

    } catch (PDOException $e) {
        Response::error("Database error occurred: " . $e->getMessage(), 500);
    }
}

/**
 * PUT: Update profile details of authenticated user
 */
function handleUpdateProfile($conn, $user_id) {
    $input = json_decode(file_get_contents("php://input"), true);

    try {
        // Fetch current details
        $stmt = $conn->prepare("SELECT id, name, password, email, role, created_at FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();

        if (!$user) {
            Response::error("User account not found.", 404);
        }

        $name = isset($input['name']) ? trim($input['name']) : $user['name'];
        $password = $user['password']; // Default keep old password

        if (empty($name)) {
            Response::error("Validation Error: 'name' cannot be empty.", 422);
        }

        // If password is provided in input, update it
        if (!empty($input['password'])) {
            if (strlen($input['password']) < 6) {
                Response::error("Validation Error: New password must be at least 6 characters long.", 422);
            }
            $password = password_hash($input['password'], PASSWORD_BCRYPT);
        }

        // Update database
        $update = $conn->prepare("UPDATE users SET name = ?, password = ? WHERE id = ?");
        $update->execute([$name, $password, $user_id]);

        Response::success([
            "message" => "Profile updated successfully!",
            "user" => [
                "id" => (int)$user_id,
                "name" => $name,
                "email" => $user['email'],
                "role" => $user['role'],
                "created_at" => $user['created_at']
            ]
        ], 200);

    } catch (PDOException $e) {
        Response::error("Database error occurred: " . $e->getMessage(), 500);
    }
}
