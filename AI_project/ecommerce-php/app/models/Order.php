<?php
/**
 * Order Model
 * Handle order-related database operations
 */

class Order {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Create new order
     */
    public function createOrder($userId, $totalAmount, $shippingAddress, $shippingCity, $shippingState, $shippingPostalCode) {
        $orderNumber = 'ORD-' . date('YmdHis') . '-' . rand(1000, 9999);

        $stmt = $this->db->prepare("
            INSERT INTO orders (userId, orderNumber, totalAmount, status, shippingAddress, shippingCity, shippingState, shippingPostalCode, createdAt)
            VALUES (?, ?, ?, 'pending', ?, ?, ?, ?, NOW())
        ");
        
        $status = 'pending';
        $stmt->bind_param('isdsss', $userId, $orderNumber, $totalAmount, $shippingAddress, $shippingCity, $shippingState, $shippingPostalCode);
        
        if ($stmt->execute()) {
            return [
                'success' => true,
                'orderId' => $this->db->insert_id,
                'orderNumber' => $orderNumber
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Error creating order'
            ];
        }
    }

    /**
     * Add order items
     */
    public function addOrderItem($orderId, $productId, $quantity, $priceAtOrder, $totalPrice) {
        $stmt = $this->db->prepare("
            INSERT INTO order_items (orderId, productId, quantity, priceAtOrder, totalPrice, createdAt)
            VALUES (?, ?, ?, ?, ?, NOW())
        ");
        
        $stmt->bind_param('iiidd', $orderId, $productId, $quantity, $priceAtOrder, $totalPrice);
        return $stmt->execute();
    }

    /**
     * Get user orders
     */
    public function getUserOrders($userId) {
        $stmt = $this->db->prepare("
            SELECT id, orderNumber, totalAmount, status, createdAt
            FROM orders
            WHERE userId = ?
            ORDER BY createdAt DESC
        ");
        
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Get order details
     */
    public function getOrderById($orderId) {
        $stmt = $this->db->prepare("
            SELECT id, userId, orderNumber, totalAmount, status, shippingAddress, shippingCity, shippingState, shippingPostalCode, createdAt
            FROM orders
            WHERE id = ?
        ");
        
        $stmt->bind_param('i', $orderId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    /**
     * Get order items
     */
    public function getOrderItems($orderId) {
        $stmt = $this->db->prepare("
            SELECT oi.id, oi.productId, oi.quantity, oi.priceAtOrder, oi.totalPrice, p.name, p.mainImage
            FROM order_items oi
            JOIN products p ON oi.productId = p.id
            WHERE oi.orderId = ?
        ");
        
        $stmt->bind_param('i', $orderId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Update order status
     */
    public function updateStatus($orderId, $status) {
        $stmt = $this->db->prepare("
            UPDATE orders
            SET status = ?, updatedAt = NOW()
            WHERE id = ?
        ");
        
        $stmt->bind_param('si', $status, $orderId);
        return $stmt->execute();
    }

    /**
     * Cancel order
     */
    public function cancelOrder($orderId) {
        return $this->updateStatus($orderId, 'cancelled');
    }

    /**
     * Get total orders count
     */
    public function getTotalOrders($userId = null) {
        if ($userId) {
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM orders WHERE userId = ?");
            $stmt->bind_param('i', $userId);
        } else {
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM orders");
        }
        
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'];
    }
}
?>
