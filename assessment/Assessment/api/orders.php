<?php
/**
 * Smart Store API Suite
 * Orders Controller (Cart checkout & Order tracking)
 * 
 * Routes:
 * - GET /api/orders.php            -> List orders for current authenticated user (Protected, JWT required)
 * - GET /api/orders.php?id={id}    -> Fetch single order details with items (Protected, JWT required)
 * - POST /api/orders.php           -> Place a new order / checkout (Protected, JWT required)
 */

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/helpers/response.php';
require_once __DIR__ . '/middleware/auth.php';

// Initialize response settings (CORS, headers)
Response::init();

$method = $_SERVER['REQUEST_METHOD'];
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

// Establish Database Connection
$db = new Database();
$conn = $db->getConnection();

// All order endpoints require authentication
$currentUser = AuthMiddleware::authenticate();
$user_id = (int)$currentUser['user_id'];
$user_role = $currentUser['role'];

switch ($method) {
    case 'GET':
        if ($id) {
            handleGetOrder($conn, $id, $user_id, $user_role);
        } else {
            handleGetOrders($conn, $user_id, $user_role);
        }
        break;

    case 'POST':
        handleCreateOrder($conn, $user_id);
        break;

    default:
        Response::error("Method Not Allowed. Supported verbs are GET and POST.", 405);
        break;
}

/**
 * GET: Fetch all orders of the logged-in user
 */
function handleGetOrders($conn, $user_id, $user_role) {
    try {
        // Admins can see all orders, customers see only their own
        if ($user_role === 'admin') {
            $stmt = $conn->prepare("SELECT o.*, u.name as customer_name, u.email as customer_email 
                                    FROM orders o 
                                    JOIN users u ON o.user_id = u.id 
                                    ORDER BY o.id DESC");
            $stmt->execute();
        } else {
            $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY id DESC");
            $stmt->execute([$user_id]);
        }

        $orders = $stmt->fetchAll();

        foreach ($orders as &$order) {
            $order['id'] = (int)$order['id'];
            $order['user_id'] = (int)$order['user_id'];
            $order['total_amount'] = (float)$order['total_amount'];
            
            // Retrieve nested item details for each order
            $items_stmt = $conn->prepare("SELECT oi.id, oi.product_id, p.name as product_name, oi.quantity, oi.price 
                                          FROM order_items oi
                                          JOIN products p ON oi.product_id = p.id
                                          WHERE oi.order_id = ?");
            $items_stmt->execute([$order['id']]);
            $items = $items_stmt->fetchAll();

            foreach ($items as &$item) {
                $item['id'] = (int)$item['id'];
                $item['product_id'] = (int)$item['product_id'];
                $item['quantity'] = (int)$item['quantity'];
                $item['price'] = (float)$item['price'];
            }

            $order['items'] = $items;
        }

        Response::success($orders, 200);

    } catch (PDOException $e) {
        Response::error("Database error occurred: " . $e->getMessage(), 500);
    }
}

/**
 * GET: Fetch a single order with full details
 */
function handleGetOrder($conn, $id, $user_id, $user_role) {
    try {
        $stmt = $conn->prepare("SELECT o.*, u.name as customer_name, u.email as customer_email 
                                FROM orders o 
                                JOIN users u ON o.user_id = u.id 
                                WHERE o.id = ?");
        $stmt->execute([$id]);
        $order = $stmt->fetch();

        if (!$order) {
            Response::error("Order Not Found: Order ID '{$id}' does not exist.", 404);
        }

        // Access Control check: Customer must own the order (Admins can view any order)
        if ($user_role !== 'admin' && (int)$order['user_id'] !== $user_id) {
            Response::error("Forbidden: You do not have permissions to view this order.", 403);
        }

        $order['id'] = (int)$order['id'];
        $order['user_id'] = (int)$order['user_id'];
        $order['total_amount'] = (float)$order['total_amount'];

        // Fetch items in the order
        $items_stmt = $conn->prepare("SELECT oi.id, oi.product_id, p.name as product_name, p.sku as product_sku, oi.quantity, oi.price 
                                      FROM order_items oi
                                      JOIN products p ON oi.product_id = p.id
                                      WHERE oi.order_id = ?");
        $items_stmt->execute([$id]);
        $items = $items_stmt->fetchAll();

        foreach ($items as &$item) {
            $item['id'] = (int)$item['id'];
            $item['product_id'] = (int)$item['product_id'];
            $item['quantity'] = (int)$item['quantity'];
            $item['price'] = (float)$item['price'];
        }

        $order['items'] = $items;

        Response::success($order, 200);

    } catch (PDOException $e) {
        Response::error("Database error occurred: " . $e->getMessage(), 500);
    }
}

/**
 * POST: Create a new order (Checkout)
 */
function handleCreateOrder($conn, $user_id) {
    $input = json_decode(file_get_contents("php://input"), true);

    if (empty($input['shipping_address']) || empty($input['items']) || !is_array($input['items'])) {
        Response::error("Validation Error: 'shipping_address' and a non-empty array of 'items' are required.", 422);
    }

    $shipping_address = trim($input['shipping_address']);
    $items = $input['items'];

    try {
        // Begin Transaction
        $conn->beginTransaction();

        $total_amount = 0;
        $validated_items = [];

        // 1. Process and validate all products/quantities/stock first
        foreach ($items as $index => $item) {
            if (empty($item['product_id']) || empty($item['quantity'])) {
                $conn->rollBack();
                Response::error("Validation Error: Item at index {$index} must contain valid 'product_id' and 'quantity'.", 422);
            }

            $product_id = (int)$item['product_id'];
            $quantity = (int)$item['quantity'];

            if ($quantity <= 0) {
                $conn->rollBack();
                Response::error("Validation Error: Quantity for product ID {$product_id} must be greater than 0.", 422);
            }

            // Fetch product and lock row for update to prevent race conditions during concurrent orders!
            $prod_stmt = $conn->prepare("SELECT id, name, price, stock FROM products WHERE id = ? FOR UPDATE");
            $prod_stmt->execute([$product_id]);
            $product = $prod_stmt->fetch();

            if (!$product) {
                $conn->rollBack();
                Response::error("Product Not Found: Product ID {$product_id} at index {$index} does not exist.", 404);
            }

            if ((int)$product['stock'] < $quantity) {
                $conn->rollBack();
                Response::error("Unprocessable Entity: Insufficient stock for '{$product['name']}'. Only {$product['stock']} left, but you requested {$quantity}.", 422);
            }

            $item_price = (float)$product['price'];
            $item_total = $item_price * $quantity;
            $total_amount += $item_total;

            $validated_items[] = [
                "product_id" => $product_id,
                "name" => $product['name'],
                "quantity" => $quantity,
                "price" => $item_price,
                "current_stock" => (int)$product['stock']
            ];
        }

        // 2. Insert Order Header record
        $order_stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, shipping_address, status) VALUES (?, ?, ?, 'pending')");
        $order_stmt->execute([$user_id, $total_amount, $shipping_address]);
        $order_id = $conn->lastInsertId();

        // 3. Insert Order Items & Deduct Product Inventory
        $item_insert = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stock_update = $conn->prepare("UPDATE products SET stock = ? WHERE id = ?");

        foreach ($validated_items as $vi) {
            // Insert line item
            $item_insert->execute([$order_id, $vi['product_id'], $vi['quantity'], $vi['price']]);

            // Deduct stock
            $new_stock = $vi['current_stock'] - $vi['quantity'];
            $stock_update->execute([$new_stock, $vi['product_id']]);
        }

        // Commit transaction
        $conn->commit();

        Response::success([
            "message" => "Order placed successfully! Reference ID: {$order_id}",
            "order" => [
                "id" => (int)$order_id,
                "total_amount" => $total_amount,
                "status" => "pending",
                "shipping_address" => $shipping_address,
                "items" => array_map(function($i) {
                    unset($i['current_stock']); // Clean response
                    return $i;
                }, $validated_items)
            ]
        ], 201); // 201 Created

    } catch (Exception $e) {
        // Rollback on any failure
        if ($conn->inTransaction()) {
            $conn->rollBack();
        }
        Response::error("Failed to process order: " . $e->getMessage(), 500);
    }
}
