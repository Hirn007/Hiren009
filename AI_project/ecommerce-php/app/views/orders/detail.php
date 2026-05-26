<?php
require APP_ROOT . '/app/helpers.php';

ob_start();

$title = 'Order Details';

// Check if user is logged in
if (!isLoggedIn()) {
    ?>
    <div style="background: white; padding: 2rem; border-radius: 8px; text-align: center;">
        <h2>Please Log In</h2>
        <p>You need to be logged in to view order details.</p>
        <a href="<?php echo getConfig('app_url'); ?>/?page=login">
            <button class="btn btn-primary">Login</button>
        </a>
    </div>
    <?php
    $content = ob_get_clean();
    include APP_ROOT . '/app/views/layouts/main.php';
    exit;
}

// Get order ID from URL
$orderId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$orderId) {
    ?>
    <div style="background: white; padding: 2rem; border-radius: 8px; text-align: center;">
        <h2>Order Not Found</h2>
        <a href="<?php echo getConfig('app_url'); ?>/?page=orders">
            <button class="btn btn-primary">Back to Orders</button>
        </a>
    </div>
    <?php
    $content = ob_get_clean();
    include APP_ROOT . '/app/views/layouts/main.php';
    exit;
}

// Get order details
$orderModel = new Order();
$order = $orderModel->getOrderById($orderId);

// Verify order belongs to current user
if (!$order || $order['userId'] != getCurrentUserId()) {
    ?>
    <div style="background: white; padding: 2rem; border-radius: 8px; text-align: center;">
        <h2>Access Denied</h2>
        <p>You don't have permission to view this order.</p>
        <a href="<?php echo getConfig('app_url'); ?>/?page=orders">
            <button class="btn btn-primary">Back to Orders</button>
        </a>
    </div>
    <?php
    $content = ob_get_clean();
    include APP_ROOT . '/app/views/layouts/main.php';
    exit;
}

// Get order items
$orderItems = $orderModel->getOrderItems($orderId);
$currentUser = getCurrentUser();

?>

<div style="max-width: 1000px; margin: 2rem auto;">
    <a href="<?php echo getConfig('app_url'); ?>/?page=orders" style="text-decoration: none; color: #667eea; margin-bottom: 1rem; display: inline-block;">
        ← Back to Orders
    </a>

    <!-- Order Header -->
    <div style="background: white; padding: 2rem; border-radius: 8px; margin-bottom: 2rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 2rem;">
            <div>
                <label style="color: #999; font-size: 0.9rem; display: block; margin-bottom: 0.5rem;">ORDER NUMBER</label>
                <h3 style="margin: 0; color: #333;"><?php echo sanitize($order['orderNumber']); ?></h3>
            </div>
            <div>
                <label style="color: #999; font-size: 0.9rem; display: block; margin-bottom: 0.5rem;">ORDER DATE</label>
                <h3 style="margin: 0; color: #333;"><?php echo date('d M Y H:i', strtotime($order['createdAt'])); ?></h3>
            </div>
            <div>
                <label style="color: #999; font-size: 0.9rem; display: block; margin-bottom: 0.5rem;">ORDER STATUS</label>
                <h3 style="margin: 0;">
                    <span style="
                        display: inline-block;
                        padding: 0.5rem 1rem;
                        border-radius: 4px;
                        font-weight: bold;
                        font-size: 0.9rem;
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
                </h3>
            </div>
        </div>
    </div>

    <!-- Customer Info -->
    <div style="background: white; padding: 2rem; border-radius: 8px; margin-bottom: 2rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <h3 style="margin-top: 0;">Customer Information</h3>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
            <div>
                <label style="color: #999; font-size: 0.9rem; display: block; margin-bottom: 0.5rem;">CUSTOMER NAME</label>
                <p style="margin: 0; color: #333; font-weight: bold;">
                    <?php echo sanitize($currentUser['firstName'] . ' ' . $currentUser['lastName']); ?>
                </p>
            </div>
            <div>
                <label style="color: #999; font-size: 0.9rem; display: block; margin-bottom: 0.5rem;">EMAIL</label>
                <p style="margin: 0; color: #333;">
                    <?php echo sanitize($currentUser['email']); ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Shipping Address -->
    <div style="background: white; padding: 2rem; border-radius: 8px; margin-bottom: 2rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <h3 style="margin-top: 0;">Shipping Address</h3>
        <p style="margin: 0.5rem 0; color: #333;">
            <?php echo sanitize($order['shippingAddress']); ?>
        </p>
        <p style="margin: 0.5rem 0; color: #333;">
            <?php echo sanitize($order['shippingCity'] . ', ' . $order['shippingState'] . ' ' . $order['shippingPostalCode']); ?>
        </p>
    </div>

    <!-- Order Items -->
    <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 2rem;">
        <div style="padding: 2rem; background: #f8f9fa; border-bottom: 1px solid #ddd;">
            <h3 style="margin: 0;">Order Items (<?php echo count($orderItems); ?>)</h3>
        </div>
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: #f8f9fa; border-bottom: 1px solid #ddd;">
                <tr>
                    <th style="padding: 1rem; text-align: left;">Product</th>
                    <th style="padding: 1rem; text-align: center;">Qty</th>
                    <th style="padding: 1rem; text-align: right;">Price</th>
                    <th style="padding: 1rem; text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orderItems as $item): ?>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 1rem;">
                            <strong><?php echo sanitize($item['name']); ?></strong>
                        </td>
                        <td style="padding: 1rem; text-align: center;">
                            <?php echo $item['quantity']; ?>
                        </td>
                        <td style="padding: 1rem; text-align: right;">
                            <?php echo formatPrice($item['priceAtOrder']); ?>
                        </td>
                        <td style="padding: 1rem; text-align: right; font-weight: bold;">
                            <?php echo formatPrice($item['totalPrice']); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Order Total -->
    <div style="background: white; padding: 2rem; border-radius: 8px; text-align: right; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <div style="display: inline-block;">
            <div style="margin-bottom: 1rem;">
                <span style="color: #999; margin-right: 2rem;">Subtotal:</span>
                <span><?php echo formatPrice($order['totalAmount']); ?></span>
            </div>
            <div style="margin-bottom: 1rem;">
                <span style="color: #999; margin-right: 2rem;">Shipping:</span>
                <span>Free</span>
            </div>
            <div style="border-top: 2px solid #ddd; padding-top: 1rem; margin-top: 1rem;">
                <span style="font-size: 1.2rem; font-weight: bold; margin-right: 2rem;">Total Amount:</span>
                <span style="font-size: 1.2rem; font-weight: bold; color: #667eea;">
                    <?php echo formatPrice($order['totalAmount']); ?>
                </span>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include APP_ROOT . '/app/views/layouts/main.php';
?>
