<?php
/**
 * Cart Model
 * Handle shopping cart operations
 */

class Cart {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Get cart items for user
     */
    public function getCartItems($userId) {
        $stmt = $this->db->prepare("
            SELECT c.id, c.productId, c.quantity, p.name, p.price, p.discountPrice, p.mainImage
            FROM cart c
            JOIN products p ON c.productId = p.id
            WHERE c.userId = ?
            ORDER BY c.addedAt DESC
        ");
        
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Get cart total
     */
    public function getCartTotal($userId) {
        $stmt = $this->db->prepare("
            SELECT SUM(p.discountPrice * c.quantity) as total
            FROM cart c
            JOIN products p ON c.productId = p.id
            WHERE c.userId = ?
        ");
        
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        
        return $result['total'] ?? 0;
    }

    /**
     * Add item to cart
     */
    public function addItem($userId, $productId, $quantity = 1) {
        // Check if item already exists in cart
        $stmt = $this->db->prepare("
            SELECT id FROM cart
            WHERE userId = ? AND productId = ?
        ");
        
        $stmt->bind_param('ii', $userId, $productId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Update quantity
            return $this->updateQuantity($userId, $productId, $quantity, true);
        } else {
            // Insert new item
            $stmt = $this->db->prepare("
                INSERT INTO cart (userId, productId, quantity, addedAt)
                VALUES (?, ?, ?, NOW())
            ");
            
            $stmt->bind_param('iii', $userId, $productId, $quantity);
            return $stmt->execute();
        }
    }

    /**
     * Update cart item quantity
     */
    public function updateQuantity($userId, $productId, $quantity, $increment = false) {
        if ($increment) {
            $stmt = $this->db->prepare("
                UPDATE cart
                SET quantity = quantity + ?
                WHERE userId = ? AND productId = ?
            ");
        } else {
            $stmt = $this->db->prepare("
                UPDATE cart
                SET quantity = ?
                WHERE userId = ? AND productId = ?
            ");
        }
        
        if ($increment) {
            $stmt->bind_param('iii', $quantity, $userId, $productId);
        } else {
            $stmt->bind_param('iii', $quantity, $userId, $productId);
        }
        
        return $stmt->execute();
    }

    /**
     * Remove item from cart
     */
    public function removeItem($userId, $productId) {
        $stmt = $this->db->prepare("
            DELETE FROM cart
            WHERE userId = ? AND productId = ?
        ");
        
        $stmt->bind_param('ii', $userId, $productId);
        return $stmt->execute();
    }

    /**
     * Clear entire cart
     */
    public function clearCart($userId) {
        $stmt = $this->db->prepare("DELETE FROM cart WHERE userId = ?");
        $stmt->bind_param('i', $userId);
        return $stmt->execute();
    }

    /**
     * Get cart item count
     */
    public function getCartCount($userId) {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as count FROM cart WHERE userId = ?
        ");
        
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['count'];
    }
}
?>
