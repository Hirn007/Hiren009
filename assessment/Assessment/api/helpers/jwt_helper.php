<?php
/**
 * Smart Store API Suite
 * Native JSON Web Token (JWT) Helper
 * Standard: HMAC-SHA256
 */

class JWTHelper {
    // Highly secure secret key for token signature
    private static $secret_key = "smart_store_api_suite_super_secret_key_2026_top_tech_assessment!";

    /**
     * Standard Base64Url Encode
     */
    private static function base64UrlEncode($data) {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
    }

    /**
     * Standard Base64Url Decode
     */
    private static function base64UrlDecode($data) {
        $remainder = strlen($data) % 4;
        if ($remainder) {
            $padlen = 4 - $remainder;
            $data .= str_repeat('=', $padlen);
        }
        return base64_decode(str_replace(['-', '_'], ['+', '/'], $data));
    }

    /**
     * Generate a JWT
     * @param array $payload Key-value pairs of claims to include (user_id, email, role, etc.)
     * @param int $expirySeconds Token expiration duration in seconds (default: 2 hours)
     * @return string Signed JWT token
     */
    public static function generate($payload, $expirySeconds = 7200) {
        $header = json_encode([
            "alg" => "HS256",
            "typ" => "JWT"
        ]);

        // Add standard registered claims
        $payload['iat'] = time();
        $payload['exp'] = time() + $expirySeconds;

        $header_encoded = self::base64UrlEncode($header);
        $payload_encoded = self::base64UrlEncode(json_encode($payload));

        // Create HMAC SHA256 signature
        $signature = hash_hmac('sha256', $header_encoded . "." . $payload_encoded, self::$secret_key, true);
        $signature_encoded = self::base64UrlEncode($signature);

        return $header_encoded . "." . $payload_encoded . "." . $signature_encoded;
    }

    /**
     * Validate and Decode a JWT
     * @param string $token The JWT token to decode
     * @return array|false Returns decoded payload array if valid, or false if invalid/expired
     */
    public static function decode($token) {
        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            return false;
        }

        list($header_encoded, $payload_encoded, $signature_encoded) = $parts;

        // Verify signature
        $signature = self::base64UrlDecode($signature_encoded);
        $expected_signature = hash_hmac('sha256', $header_encoded . "." . $payload_encoded, self::$secret_key, true);

        if (!hash_equals($signature, $expected_signature)) {
            return false; // Signature mismatch
        }

        $payload = json_decode(self::base64UrlDecode($payload_encoded), true);

        // Check if JSON decoding succeeded
        if (!$payload) {
            return false;
        }

        // Verify expiration (exp claim)
        if (isset($payload['exp']) && $payload['exp'] < time()) {
            return false; // Token expired
        }

        return $payload;
    }
}
