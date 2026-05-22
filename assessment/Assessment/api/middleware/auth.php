<?php
/**
 * Smart Store API Suite
 * Authentication Middleware (JWT Validator)
 */

require_once __DIR__ . '/../helpers/jwt_helper.php';
require_once __DIR__ . '/../helpers/response.php';

class AuthMiddleware {
    /**
     * Authenticate the incoming request using the Authorization Bearer token.
     * @return array Decoded user payload if successful, otherwise terminates with 401.
     */
    public static function authenticate() {
        $headers = self::getRequestHeaders();
        $authHeader = null;

        if (isset($headers['Authorization'])) {
            $authHeader = $headers['Authorization'];
        } elseif (isset($headers['authorization'])) {
            $authHeader = $headers['authorization'];
        } elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
        } elseif (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
            $authHeader = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
        }

        if (empty($authHeader)) {
            Response::error("Unauthorized access. Access token is missing.", 401);
        }

        // Extract token from Bearer scheme
        $token = null;
        if (preg_match('/Bearer\s(\S+)/i', $authHeader, $matches)) {
            $token = $matches[1];
        }

        if (empty($token)) {
            Response::error("Unauthorized access. Invalid Authorization header format. Expected Bearer <token>.", 401);
        }

        // Decode and validate token
        $decoded = JWTHelper::decode($token);
        if (!$decoded) {
            Response::error("Unauthorized access. Access token is invalid, tampered, or expired.", 401);
        }

        return $decoded; // Return user payload (contains user_id, email, role, etc.)
    }

    /**
     * Authenticate request and check if user has admin privileges.
     * @return array Decoded user payload if successful and role is admin.
     */
    public static function authenticateAdmin() {
        $user = self::authenticate();
        if (!isset($user['role']) || $user['role'] !== 'admin') {
            Response::error("Forbidden access. Administrator privileges required.", 403);
        }
        return $user;
    }

    /**
     * Extract all request headers, with support for diverse environments.
     */
    private static function getRequestHeaders() {
        if (function_exists('apache_request_headers')) {
            return apache_request_headers();
        }

        $headers = [];
        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) <> 'HTTP_') {
                continue;
            }
            $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
            $headers[$header] = $value;
        }
        return $headers;
    }
}
