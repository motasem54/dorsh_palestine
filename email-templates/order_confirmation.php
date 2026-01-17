<?php
ob_start();
?>
<div class="email-header">
    <h1>Order Confirmation</h1>
    <p>Thank you for your order!</p>
</div>
<div class="email-body">
    <p>Hi <?php echo htmlspecialchars($order['first_name']); ?>,</p>
    <p style="margin-top: 15px;">Thank you for shopping with Dorsh Palestine! Your order has been received and is being processed.</p>
    
    <div class="info-box">
        <strong>Order Number:</strong> #<?php echo $order['order_number']; ?><br>
        <strong>Order Date:</strong> <?php echo date('F d, Y H:i', strtotime($order['created_at'])); ?><br>
        <strong>Status:</strong> <?php echo ucfirst($order['status']); ?>
    </div>
    
    <h3 style="margin: 30px 0 15px;">Order Items</h3>
    <div class="order-summary">
        <?php foreach ($items as $item): ?>
        <div class="order-item">
            <div>
                <strong><?php echo htmlspecialchars($item['product_name']); ?></strong><br>
                <small>Quantity: <?php echo $item['quantity']; ?> × $<?php echo number_format($item['price'], 2); ?></small>
            </div>
            <div>
                <strong>$<?php echo number_format($item['total'], 2); ?></strong>
            </div>
        </div>
        <?php endforeach; ?>
        
        <div style="padding: 10px 0; display: flex; justify-content: space-between;">
            <span>Subtotal:</span>
            <strong>$<?php echo number_format($order['subtotal'], 2); ?></strong>
        </div>
        <div style="padding: 10px 0; display: flex; justify-content: space-between;">
            <span>Shipping:</span>
            <strong>$<?php echo number_format($order['shipping'], 2); ?></strong>
        </div>
        <div class="total-row">
            <span>Total:</span>
            <span>$<?php echo number_format($order['total'], 2); ?></span>
        </div>
    </div>
    
    <h3 style="margin: 30px 0 15px;">Shipping Address</h3>
    <p>
        <?php echo htmlspecialchars($order['address']); ?><br>
        <?php echo htmlspecialchars($order['city']); ?> <?php echo htmlspecialchars($order['postal_code']); ?>
    </p>
    
    <div style="text-align: center; margin-top: 40px;">
        <a href="<?php echo SITE_URL; ?>/account/orders.php?order=<?php echo $order['id']; ?>" class="btn">View Order Details</a>
    </div>
    
    <p style="margin-top: 30px; font-size: 14px; color: #666;">
        If you have any questions about your order, please contact us at info@dorsh-palestine.com
    </p>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
