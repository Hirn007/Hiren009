<?php
/**
 * Smart Store API Suite
 * Products REST API Controller
 * 
 * Routes:
 * - GET /api/products.php            -> Fetch all products (Public)
 * - GET /api/products.php?id={id}     -> Fetch single product (Public)
 * - POST /api/products.php           -> Add new product (Protected, JWT required)
 * - PUT /api/products.php?id={id}    -> Update product (Protected, JWT required)
 * - DELETE /api/products.php?id={id} -> Delete product (Protected, JWT required)
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

switch ($method) {
    case 'GET':
        if ($id) {
            handleGetProduct($conn, $id);
        } else {
            handleGetProducts($conn);
        }
        break;

    case 'POST':
        // Protect POST route using JWT auth
        AuthMiddleware::authenticate();
        handleCreateProduct($conn);
        break;

    case 'PUT':
        // Protect PUT route using JWT auth
        AuthMiddleware::authenticate();
        if (!$id) {
            Response::error("Bad Request: Product ID is required in the query parameter (?id=...).", 400);
        }
        handleUpdateProduct($conn, $id);
        break;

    case 'DELETE':
        // Protect DELETE route using JWT auth
        AuthMiddleware::authenticate();
        if (!$id) {
            Response::error("Bad Request: Product ID is required in the query parameter (?id=...).", 400);
        }
        handleDeleteProduct($conn, $id);
        break;

    default:
        Response::error("Method Not Allowed. Supported verbs are GET, POST, PUT, DELETE.", 405);
        break;
}

/**
 * GET: Fetch all products
 */
function handleGetProducts($conn) {
    try {
        $stmt = $conn->query("SELECT * FROM products ORDER BY id DESC");
        $products = $stmt->fetchAll();
        
        // Cast values to proper data types for premium API output
        foreach ($products as &$p) {
            $p['id'] = (int)$p['id'];
            $p['price'] = (float)$p['price'];
            $p['stock'] = (int)$p['stock'];
        }

        Response::success($products, 200);
    } catch (PDOException $e) {
        Response::error("Database error occurred: " . $e->getMessage(), 500);
    }
}

/**
 * GET: Fetch a single product
 */
function handleGetProduct($conn, $id) {
    try {
        $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $product = $stmt->fetch();

        if (!$product) {
            Response::error("Product Not Found: No product matches the provided ID '{$id}'.", 404);
        }

        $product['id'] = (int)$product['id'];
        $product['price'] = (float)$product['price'];
        $product['stock'] = (int)$product['stock'];

        Response::success($product, 200);
    } catch (PDOException $e) {
        Response::error("Database error occurred: " . $e->getMessage(), 500);
    }
}

/**
 * POST: Create a new product
 */
function handleCreateProduct($conn) {
    $input = json_decode(file_get_contents("php://input"), true);

    // Validate request body
    if (empty($input['name']) || !isset($input['price']) || !isset($input['stock']) || empty($input['sku'])) {
        Response::error("Validation Error: 'name', 'price', 'stock', and 'sku' fields are required.", 422);
    }

    $name = trim($input['name']);
    $description = isset($input['description']) ? trim($input['description']) : null;
    $price = filter_var($input['price'], FILTER_VALIDATE_FLOAT);
    $stock = filter_var($input['stock'], FILTER_VALIDATE_INT);
    $sku = strtoupper(trim($input['sku']));

    if ($price === false || $price < 0) {
        Response::error("Validation Error: 'price' must be a positive decimal number.", 422);
    }

    if ($stock === false || $stock < 0) {
        Response::error("Validation Error: 'stock' must be a non-negative integer.", 422);
    }

    try {
        // Verify SKU uniqueness
        $stmt = $conn->prepare("SELECT id FROM products WHERE sku = ?");
        $stmt->execute([$sku]);
        if ($stmt->fetch()) {
            Response::error("Unprocessable Entity: A product with SKU '{$sku}' already exists.", 422);
        }

        // Insert new product
        $insert = $conn->prepare("INSERT INTO products (name, description, price, stock, sku) VALUES (?, ?, ?, ?, ?)");
        $insert->execute([$name, $description, $price, $stock, $sku]);
        $new_id = $conn->lastInsertId();

        // Retrieve and return the created product
        $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$new_id]);
        $product = $stmt->fetch();

        $product['id'] = (int)$product['id'];
        $product['price'] = (float)$product['price'];
        $product['stock'] = (int)$product['stock'];

        Response::success([
            "message" => "Product added successfully!",
            "product" => $product
        ], 201); // 201 Created

    } catch (PDOException $e) {
        Response::error("Database error occurred: " . $e->getMessage(), 500);
    }
}

/**
 * PUT: Update an existing product
 */
function handleUpdateProduct($conn, $id) {
    $input = json_decode(file_get_contents("php://input"), true);

    try {
        // 1. Check if product exists
        $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $product = $stmt->fetch();

        if (!$product) {
            Response::error("Product Not Found: Cannot update non-existent product ID '{$id}'.", 404);
        }

        // 2. Parse and validate inputs (allow partial updates)
        $name = isset($input['name']) ? trim($input['name']) : $product['name'];
        $description = isset($input['description']) ? trim($input['description']) : $product['description'];
        $price = isset($input['price']) ? filter_var($input['price'], FILTER_VALIDATE_FLOAT) : (float)$product['price'];
        $stock = isset($input['stock']) ? filter_var($input['stock'], FILTER_VALIDATE_INT) : (int)$product['stock'];
        $sku = isset($input['sku']) ? strtoupper(trim($input['sku'])) : $product['sku'];

        if ($price === false || $price < 0) {
            Response::error("Validation Error: 'price' must be a positive decimal number.", 422);
        }

        if ($stock === false || $stock < 0) {
            Response::error("Validation Error: 'stock' must be a non-negative integer.", 422);
        }

        if (empty($name) || empty($sku)) {
            Response::error("Validation Error: 'name' and 'sku' cannot be empty strings.", 422);
        }

        // 3. Check SKU uniqueness if SKU is being updated
        if ($sku !== $product['sku']) {
            $sku_check = $conn->prepare("SELECT id FROM products WHERE sku = ? AND id != ?");
            $sku_check->execute([$sku, $id]);
            if ($sku_check->fetch()) {
                Response::error("Unprocessable Entity: Another product with SKU '{$sku}' already exists.", 422);
            }
        }

        // 4. Perform update
        $update = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, stock = ?, sku = ? WHERE id = ?");
        $update->execute([$name, $description, $price, $stock, $sku, $id]);

        // 5. Return updated product
        $updated_product = [
            "id" => $id,
            "name" => $name,
            "description" => $description,
            "price" => $price,
            "stock" => $stock,
            "sku" => $sku,
            "created_at" => $product['created_at']
        ];

        Response::success([
            "message" => "Product updated successfully!",
            "product" => $updated_product
        ], 200);

    } catch (PDOException $e) {
        Response::error("Database error occurred: " . $e->getMessage(), 500);
    }
}

/**
 * DELETE: Delete a product
 */
function handleDeleteProduct($conn, $id) {
    try {
        // 1. Verify existence
        $stmt = $conn->prepare("SELECT name FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $product = $stmt->fetch();

        if (!$product) {
            Response::error("Product Not Found: Cannot delete non-existent product ID '{$id}'.", 404);
        }

        // 2. Perform deletion
        $delete = $conn->prepare("DELETE FROM products WHERE id = ?");
        $delete->execute([$id]);

        Response::success([
            "message" => "Product '{$product['name']}' (ID: {$id}) has been deleted successfully."
        ], 200);

    } catch (PDOException $e) {
        Response::error("Database error occurred: " . $e->getMessage(), 500);
    }
}
