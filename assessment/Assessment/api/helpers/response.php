<?php
/**
 * Smart Store API Suite
 * Standardized API Response and CORS Helper
 */

class Response {
    /**
     * Send standard JSON headers, handles preflight requests, and sets up CORS.
     */
    public static function init() {
        // Enable CORS
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        // Handle preflight OPTIONS request
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit();
        }
    }

    /**
     * Return a standardized success JSON response
     * @param mixed $data Output payload
     * @param int $code HTTP Status Code (default: 200)
     */
    public static function success($data = null, $code = 200) {
        self::init();
        http_response_code($code);
        
        $response = [
            "status" => "success",
            "code" => $code
        ];

        if ($data !== null) {
            $response["data"] = $data;
        }

        echo json_encode($response, JSON_PRETTY_PRINT);
        exit();
    }

    /**
     * Return a standardized error JSON response
     * @param string $message Error message
     * @param int $code HTTP Status Code (default: 400)
     */
    public static function error($message, $code = 400) {
        self::init();
        http_response_code($code);
        
        $response = [
            "status" => "error",
            "code" => $code,
            "message" => $message
        ];

        echo json_encode($response, JSON_PRETTY_PRINT);
        exit();
    }
}
