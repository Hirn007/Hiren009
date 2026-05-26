<?php
require APP_ROOT . '/app/helpers.php';

ob_start();

$title = 'My Orders';

// Check if user is logged in
if (!isLoggedIn()) {
    ?>
    <div style="background: white; padding: 2rem; border-radius: 8px; text-align: center;">
        <h2>Please Log In</h2>
        <p>You need to be logged in to view your orders.</p>
        <a href="<?php echo getConfig('app_url'); ?>/?page=login">
            <button class="btn btn-primary">Login</button>
        </a>
    </div>
    <?php
    $content = ob_get_clean();
    include APP_ROOT . '/app/views/layouts/main.php';
    exit;
}

// Get current user
$currentUser = getCurrentUser();
$orderModel = new Order();
$orders = $orderModel->getUserOrders(getCurrentUserId());

?>

<div style="max-width: 1200px; margin: 2rem auto;">
    <h1>My Orders</h1>
    <p style="color: #666; margin-bottom: 2rem;">
        Welcome, <strong><?php echo sanitize($currentUser['firstName'] . ' ' . $currentUser['lastName']); ?></strong>
    </p>

    <?php if (empty($orders)): ?>
        <div style="background: white; padding: 2rem; border-radius: 8px; text-align: center;">
            <h3>No Orders Yet</h3>
            <p>You haven't placed any orders yet. Start shopping now!</p>
            <a href="<?php echo getConfig('app_url'); ?>/?page=products">
                <button class="btn btn-primary">Continue Shopping</button>
            </a>
        </div>
    <?php else: ?>
        <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: #667eea; color: white;">
                    <tr>
                        <th style="padding: 1rem; text-align: left;">Order ID</th>
                        <th style="padding: 1rem; text-align: left;">Date</th>
                        <th style="padding: 1rem; text-align: left;">Products</th>
                        <th style="padding: 1rem; text-align: left;">Amount</th>
                        <th style="padding: 1rem; text-align: left;">Status</th>
                        <th style="padding: 1rem; text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <?php 
                            $orderItems = $orderModel->getOrderItems($order['id']);
                            $productNames = array_map(function($item) { 
                                return sanitize($item['name']); 
                            }, $orderItems);
                            $productsDisplay = implode(', ', array_slice($productNames, 0, 2));
                            if (count($orderItems) > 2) {
                                $productsDisplay .= ' +' . (count($orderItems) - 2) . ' more';
                            }
                        ?>
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 1rem;">
                                <strong><?php echo sanitize($order['orderNumber']); ?></strong>
                            </td>
                            <td style="padding: 1rem;">
                                <?php echo date('d M Y', strtotime($order['createdAt'])); ?>
                            </td>
                            <td style="padding: 1rem;">
                                <?php echo $productsDisplay; ?>
                            </td>
                            <td style="padding: 1rem;">
                                <strong><?php echo formatPrice($order['totalAmount']); ?></strong>
                            </td>
                            <td style="padding: 1rem;">
                                <span style="
                                    display: inline-block;
                                    padding: 0.4rem 0.8rem;
                                    border-radius: 4px;
                                    font-size: 0.85rem;
                                    font-weight: bold;
                                    <?php 
                                        if ($order['status'] == 'delivered') {
                                            echo 'background: #d4edda; color: #155724;';
                                        } elseif ($order['status'] == 'shipped') {
                                            echo 'background: #cfe2ff; color: #084298;';
                                        } elseif ($order['status'] == 'pending') {
                                            echo 'background: #fff3cd; color: #664d03;';
                                        } elseif ($order['status'] == 'cancelled') {
                                            echo 'background: #f8d7da; color: #842029;';
                                        }
                                    ?>
                                ">
                                    <?php echo ucfirst($order['status']); ?>
                                </span>
                            </td>
                            <td style="padding: 1rem; text-align: center;">
                                <a href="<?php echo getConfig('app_url'); ?>/?page=order-detail&id=<?php echo $order['id']; ?>" style="text-decoration: none;">
                                    <button class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.9rem;">View</button>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include APP_ROOT . '/app/views/layouts/main.php';
?>
