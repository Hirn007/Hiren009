<?php
// Load helpers and models
require APP_ROOT . '/app/helpers.php';

// Start output buffering for layout
ob_start();

// Get featured products
$productModel = new Product();
$featuredProducts = $productModel->getFeaturedProducts(8);

?>

<h1>Welcome to FlipClone</h1>
<p style="margin-bottom: 1rem; color: #666;">Your trusted online shopping destination</p>

<?php if (!empty($featuredProducts)): ?>
    <h2 style="margin: 2rem 0 1rem;">Featured Products</h2>
    <div class="product-grid">
        <?php foreach ($featuredProducts as $product): ?>
            <div class="product-card">
                <img src="<?php echo getConfig('app_url'); ?>/images/placeholder.jpg" alt="<?php echo sanitize($product['name']); ?>" class="product-image">
                <div class="product-info">
                    <div class="product-name"><?php echo sanitize($product['name']); ?></div>
                    <div class="product-price">
                        <span class="price-original"><?php echo formatPrice($product['price']); ?></span>
                        <span class="price-current"><?php echo formatPrice($product['discountPrice']); ?></span>
                        <span class="discount-badge">-<?php echo getDiscountPercent($product['price'], $product['discountPrice']); ?>%</span>
                    </div>
                    <div class="rating">★<?php echo $product['rating']; ?> (<?php echo isset($product['reviewCount']) ? $product['reviewCount'] : 0; ?> reviews)</div>
                    <a href="<?php echo getConfig('app_url'); ?>/?page=product&id=<?php echo $product['id']; ?>">
                        <button class="btn btn-primary">View Details</button>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>No products available at the moment.</p>
<?php endif; ?>

<?php
$content = ob_get_clean();
include APP_ROOT . '/app/views/layouts/main.php';
?>
