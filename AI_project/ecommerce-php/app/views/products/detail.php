<?php
require APP_ROOT . '/app/helpers.php';

ob_start();

// Validate ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    setFlash('error', 'Product not found');
    redirect('products');
}

$productId = intval($_GET['id']);
$productModel = new Product();
$product = $productModel->getProductById($productId);

if (!$product) {
    setFlash('error', 'Product not found');
    redirect('products');
}

$title = sanitize($product['name']);

// Handle Add to Cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' 
    && ($_POST['action'] ?? '') === 'add_to_cart') {
    
    if (!isLoggedIn()) {
        setFlash('error', 'Please login to add items to cart');
        redirect('login');
    }

    $quantity = max(1, intval($_POST['quantity'] ?? 1));

    $cartModel = new Cart();

    if ($cartModel->addItem(getCurrentUserId(), $productId, $quantity)) {
        setFlash('success', 'Product added to cart successfully');
        redirect('cart');
    } else {
        setFlash('error', 'Failed to add product to cart');
    }
}
?>

<div style="background: white; padding: 2rem; border-radius: 10px;">

    <a href="<?php echo getConfig('app_url'); ?>/?page=products" 
       style="color: #4c6ef5; text-decoration: none;">← Back to Products</a>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-top: 2rem;">

        <!-- Product Image -->
        <div>
            <img src="<?php echo getConfig('app_url'); ?>/images/placeholder.jpg"
                 alt="<?php echo sanitize($product['name']); ?>"
                 style="width: 100%; border-radius: 10px;">
        </div>

        <!-- Product Details -->
        <div>
            <h1><?php echo sanitize($product['name']); ?></h1>

            <!-- Rating -->
            <div style="font-size: 1.2rem; margin: 1rem 0;">
                ★ <?php echo $product['rating'] ?: '4.5'; ?> 
                (<?php echo $product['reviewCount'] ?: '10'; ?> reviews)
            </div>

            <!-- Price -->
            <div style="margin-bottom: 1.5rem;">
                <h3>Price</h3>
                <div style="font-size: 1.4rem; display: flex; gap: 10px; align-items: center;">
                    <span style="text-decoration: line-through; color: #888;">
                        <?php echo formatPrice($product['price']); ?>
                    </span>

                    <span style="color: #e63946; font-weight: bold;">
                        <?php echo formatPrice($product['discountPrice']); ?>
                    </span>

                    <span style="background: #e63946; color: white; padding: 4px 8px; 
                                border-radius: 4px; font-size: 0.9rem;">
                        -<?php echo getDiscountPercent($product['price'], $product['discountPrice']); ?>%
                    </span>
                </div>
            </div>

            <!-- Stock -->
            <div style="margin-bottom: 1.5rem;">
                <h3>Availability</h3>
                <p style="color: <?php echo $product['stock'] > 0 ? '#2a9d8f' : '#e63946'; ?>;
                          font-weight: bold;">
                    <?php echo $product['stock'] > 0 
                        ? 'In Stock (' . $product['stock'] . ' available)'
                        : 'Out of Stock'; ?>
                </p>
            </div>

            <!-- Description -->
            <div style="margin-bottom: 1.5rem;">
                <h3>Description</h3>
                <p><?php echo nl2br(sanitize($product['description'])); ?></p>
            </div>

            <!-- Add to Cart -->
            <?php if ($product['stock'] > 0): ?>
                <form method="POST">
                    <div style="margin-bottom: 1rem;">
                        <label>Quantity</label>
                        <input type="number" 
                               name="quantity" 
                               value="1" 
                               min="1" 
                               max="<?php echo $product['stock']; ?>" 
                               required
                               style="width: 80px; padding: 8px;">
                    </div>

                    <input type="hidden" name="action" value="add_to_cart">

                    <button type="submit" 
                            style="padding: 12px 20px; background: #2a9d8f; color: white;
                                   border: none; border-radius: 5px; font-size: 1rem; cursor: pointer;">
                        🛒 Add to Cart
                    </button>
                </form>
            <?php else: ?>
                <button style="padding: 12px 20px; background: #ccc; border: none; 
                               border-radius: 5px; cursor: not-allowed;">
                    Out of Stock
                </button>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include APP_ROOT . '/app/views/layouts/main.php';
?>