<?php
/**
 * Product Model
 * Handle product-related database operations
 */

class Product {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Get all products with pagination and filters
     */
    public function getAllProducts($page = 1, $limit = 20, $categoryId = null, $sortBy = 'id', $order = 'DESC') {
        $offset = ($page - 1) * $limit;
        $sortBy = preg_replace('/[^a-zA-Z_]/', '', $sortBy);
        $order = strtoupper($order) === 'ASC' ? 'ASC' : 'DESC';

        $where = '';
        $params = [];
        $types = '';

        if ($categoryId) {
            $where = 'WHERE categoryId = ?';
            $params[] = $categoryId;
            $types .= 'i';
        }

        $sql = "
            SELECT id, name, description, price, discountPrice, categoryId, mainImage, stock, rating, reviewCount
            FROM products
            $where
            ORDER BY $sortBy $order
            LIMIT ?, ?
        ";

        $params[] = $offset;
        $params[] = $limit;
        $types .= 'ii';

        $stmt = $this->db->prepare($sql);
        
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Get product by ID
     */
    public function getProductById($productId) {
        $stmt = $this->db->prepare("
            SELECT id, name, description, price, discountPrice, categoryId, mainImage, stock, rating, reviewCount
            FROM products
            WHERE id = ?
            LIMIT 1
        ");
        
        $stmt->bind_param('i', $productId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }

    /**
     * Search products
     */
    public function searchProducts($query, $limit = 10) {
        $searchTerm = '%' . $query . '%';
        
        $stmt = $this->db->prepare("
            SELECT id, name, description, price, discountPrice, mainImage
            FROM products
            WHERE name LIKE ? OR description LIKE ?
            LIMIT ?
        ");
        
        $stmt->bind_param('ssi', $searchTerm, $searchTerm, $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Get products by category
     */
    public function getByCategory($categoryId, $limit = 20) {
        $stmt = $this->db->prepare("
            SELECT id, name, description, price, discountPrice, mainImage, stock, rating
            FROM products
            WHERE categoryId = ?
            LIMIT ?
        ");
        
        $stmt->bind_param('ii', $categoryId, $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Get featured products
     */
    public function getFeaturedProducts($limit = 10) {
        $stmt = $this->db->prepare("
            SELECT id, name, description, price, discountPrice, mainImage, stock, rating
            FROM products
            WHERE stock > 0
            ORDER BY rating DESC, reviewCount DESC
            LIMIT ?
        ");
        
        $stmt->bind_param('i', $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Create product (Admin)
     */
    public function createProduct($name, $description, $price, $discountPrice, $categoryId, $stock) {
        $stmt = $this->db->prepare("
            INSERT INTO products (name, description, price, discountPrice, categoryId, stock, createdAt)
            VALUES (?, ?, ?, ?, ?, ?, NOW())
        ");
        
        $stmt->bind_param('ssddii', $name, $description, $price, $discountPrice, $categoryId, $stock);
        
        return $stmt->execute();
    }

    /**
     * Update product (Admin)
     */
    public function updateProduct($productId, $price, $discountPrice, $stock) {
        $stmt = $this->db->prepare("
            UPDATE products
            SET price = ?, discountPrice = ?, stock = ?, updatedAt = NOW()
            WHERE id = ?
        ");
        
        $stmt->bind_param('ddii', $price, $discountPrice, $stock, $productId);
        
        return $stmt->execute();
    }

    /**
     * Get total product count
     */
    public function getTotalCount($categoryId = null) {
        if ($categoryId) {
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM products WHERE categoryId = ?");
            $stmt->bind_param('i', $categoryId);
        } else {
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM products");
        }
        
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'];
    }
}
?>
