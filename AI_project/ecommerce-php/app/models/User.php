<?php
/**
 * User Model
 * Handle user-related database operations
 */

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Create new user
     */
    public function register($firstName, $lastName, $email, $password, $phone) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
        $stmt = $this->db->prepare("
            INSERT INTO users (firstName, lastName, email, password, phone, createdAt)
            VALUES (?, ?, ?, ?, ?, NOW())
        ");
        
        $stmt->bind_param('sssss', $firstName, $lastName, $email, $hashedPassword, $phone);
        
        if ($stmt->execute()) {
            return [
                'success' => true,
                'userId' => $this->db->insert_id,
                'message' => 'User registered successfully'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Error: ' . $stmt->error
            ];
        }
    }

    /**
     * Login user
     */
    public function login($email, $password) {
        $stmt = $this->db->prepare("
            SELECT id, firstName, lastName, email, password, phone, profileImage
            FROM users
            WHERE email = ?
            LIMIT 1
        ");
        
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['password'])) {
                unset($user['password']); // Remove password from response
                return [
                    'success' => true,
                    'user' => $user,
                    'message' => 'Login successful'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Invalid password'
                ];
            }
        } else {
            return [
                'success' => false,
                'message' => 'User not found'
            ];
        }
    }

    /**
     * Get user by ID
     */
    public function getUserById($userId) {
        $stmt = $this->db->prepare("
            SELECT id, firstName, lastName, email, phone, profileImage, createdAt
            FROM users
            WHERE id = ?
            LIMIT 1
        ");
        
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }

    /**
     * Update user profile
     */
    public function updateProfile($userId, $firstName, $lastName, $phone) {
        $stmt = $this->db->prepare("
            UPDATE users
            SET firstName = ?, lastName = ?, phone = ?, updatedAt = NOW()
            WHERE id = ?
        ");
        
        $stmt->bind_param('sssi', $firstName, $lastName, $phone, $userId);
        
        return $stmt->execute();
    }

    /**
     * Check if email exists
     */
    public function emailExists($email) {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }
}
?>
