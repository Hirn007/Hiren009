<?php
require APP_ROOT . '/app/helpers.php';

ob_start();

$title = 'Shopping Cart';

// Check if user is logged in
if (!isLoggedIn()) {
    ?>
    <div style="background: white; padding: 2rem; border-radius: 8px; text-align: center;">
        <h2>Your Cart is Empty</h2>
        <p>Please <a href="<?php echo getConfig('app_url'); ?>/?page=login">login</a> to view your cart</p>
        <a href="<?php echo getConfig('app_url'); ?>/?page=products">
            <button class="btn btn-primary">Continue Shopping</button>
        </a>
    </div>
    <?php
} else {
    $cartModel = new Cart();
    $cartItems = $cartModel->getCartItems(getCurrentUserId());
    $cartTotal = $cartModel->getCartTotal(getCurrentUserId());

    // Handle quantity update
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
        if ($_POST['action'] === 'update') {
            $productId = intval($_POST['product_id']);
            $quantity = max(1, intval($_POST['quantity']));
            $cartModel->updateQuantity(getCurrentUserId(), $productId, $quantity);
            setFlash('success', 'Cart updated');
            redirect('cart');
        } elseif ($_POST['action'] === 'remove') {
            $productId = intval($_POST['product_id']);
            $cartModel->removeItem(getCurrentUserId(), $productId);
            setFlash('success', 'Item removed from cart');
            redirect('cart');
        }
    }

    if (empty($cartItems)):
        ?>
        <div style="background: white; padding: 2rem; border-radius: 8px; text-align: center;">
            <h2>Your Cart is Empty</h2>
            <p>Add some products to your cart to get started</p>
            <a href="<?php echo getConfig('app_url'); ?>/?page=products">
                <button class="btn btn-primary">Continue Shopping</button>
            </a>
        </div>
        <?php
    else:
        ?>
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
            <!-- Cart Items -->
            <div style="background: white; padding: 2rem; border-radius: 8px;">
                <h2 style="margin-bottom: 1.5rem;">Shopping Cart (<?php echo count($cartItems); ?> items)</h2>
                
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cartItems as $item): ?>
                            <tr>
                                <td>
                                    <strong><?php echo sanitize($item['name']); ?></strong>
                                </td>
                                <td><?php echo formatPrice($item['discountPrice']); ?></td>
                                <td>
                                    <form method="POST" style="background: none; padding: 0; display: flex; gap: 0.5rem;">
                                        <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" max="10" style="width: 60px;">
                                        <input type="hidden" name="product_id" value="<?php echo $item['productId']; ?>">
                                        <input type="hidden" name="action" value="update">
                                        <button type="submit" class="btn btn-primary" style="width: auto; padding: 0.5rem;">Update</button>
                                    </form>
                                </td>
                                <td><?php echo formatPrice($item['discountPrice'] * $item['quantity']); ?></td>
                                <td>
                                    <form method="POST" style="background: none; padding: 0;">
                                        <input type="hidden" name="product_id" value="<?php echo $item['productId']; ?>">
                                        <input type="hidden" name="action" value="remove">
                                        <button type="submit" class="btn btn-danger" style="width: 100px;">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Order Summary -->
            <div style="background: white; padding: 2rem; border-radius: 8px; height: fit-content;">
                <h3>Order Summary</h3>
                <div style="margin-top: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; border-bottom: 1px solid #ddd; padding-bottom: 1rem;">
                        <span>Subtotal:</span>
                        <strong><?php echo formatPrice($cartTotal); ?></strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                        <span>Shipping:</span>
                        <strong style="color: #27ae60;">Free</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                        <span>Tax (18%):</span>
                        <strong><?php echo formatPrice($cartTotal * 0.18); ?></strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 1.2rem; font-weight: bold; border-top: 2px solid #667eea; padding-top: 1rem;">
                        <span>Total:</span>
                        <span><?php echo formatPrice($cartTotal * 1.18); ?></span>
                    </div>
                </div>
                <a href="<?php echo getConfig('app_url'); ?>/?page=checkout" style="text-decoration: none;">
                    <button class="btn btn-success" style="font-size: 1rem; margin-top: 1.5rem;">Proceed to Checkout</button>
                </a>
                <a href="<?php echo getConfig('app_url'); ?>/?page=products" style="text-decoration: none;">
                    <button class="btn btn-primary" style="margin-top: 0.5rem;">Continue Shopping</button>
                </a>
            </div>
        </div>
        <?php
    endif;
}

$content = ob_get_clean();
include APP_ROOT . '/app/views/layouts/main.php';
?>
