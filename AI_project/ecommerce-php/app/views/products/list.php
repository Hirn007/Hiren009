<?php
require APP_ROOT . '/app/helpers.php';

ob_start();

$page = isset($_GET['page_num']) ? max(1, intval($_GET['page_num'])) : 1;
$categoryId = isset($_GET['category']) ? intval($_GET['category']) : null;
$limit = getConfig('items_per_page');

$productModel = new Product();
$products = $productModel->getAllProducts($page, $limit, $categoryId, 'rating', 'DESC');
$totalProducts = $productModel->getTotalCount($categoryId);
$totalPages = ceil($totalProducts / $limit);

$title = 'Products';
?>

<h1>Our Products</h1>

<?php if (!empty($products)): ?>
    <div class="product-grid">
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <img src="<?php echo getConfig('app_url'); ?>/images/placeholder.jpg" alt="<?php echo sanitize($product['name']); ?>" class="product-image">
                <div class="product-info">
                    <div class="product-name"><?php echo sanitize($product['name']); ?></div>
                    <div class="product-price">
                        <span class="price-original"><?php echo formatPrice($product['price']); ?></span>
                        <span class="price-current"><?php echo formatPrice($product['discountPrice']); ?></span>
                        <span class="discount-badge">-<?php echo getDiscountPercent($product['price'], $product['discountPrice']); ?>%</span>
                    </div>
                    <div class="rating">★<?php echo $product['rating']; ?> (<?php echo $product['reviewCount']; ?> reviews)</div>
                    <div style="margin-top: 0.5rem; color: <?php echo $product['stock'] > 0 ? '#27ae60' : '#ff6b6b'; ?>;">
                        <?php echo $product['stock'] > 0 ? 'In Stock' : 'Out of Stock'; ?>
                    </div>
                    <a href="<?php echo getConfig('app_url'); ?>/?page=product&id=<?php echo $product['id']; ?>">
                        <button class="btn btn-primary">View Details</button>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
        <div style="text-align: center; margin: 2rem 0;">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="<?php echo getConfig('app_url'); ?>/?page=products&page_num=<?php echo $i; ?>" 
                   style="display: inline-block; padding: 0.5rem 1rem; margin: 0.25rem; background: <?php echo $i == $page ? '#667eea' : '#ddd'; ?>; color: <?php echo $i == $page ? 'white' : '#333'; ?>; text-decoration: none; border-radius: 4px;">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
<?php else: ?>
    <p>No products found.</p>
<?php endif; ?>

<?php
$content = ob_get_clean();
include APP_ROOT . '/app/views/layouts/main.php';
?>
