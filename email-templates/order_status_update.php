<?php
ob_start();
?>
<div class="email-header">
    <h1>Order Status Updated</h1>
    <p>Your order status has changed</p>
</div>
<div class="email-body">
    <p>Hi <?php echo htmlspecialchars($order['first_name']); ?>,</p>
    <p style="margin-top: 15px;">The status of your order <strong>#<?php echo $order['order_number']; ?></strong> has been updated.</p>
    
    <div class="info-box">
        <strong>Previous Status:</strong> <?php echo ucfirst($old_status); ?><br>
        <strong>New Status:</strong> <span style="color: #2563eb; font-weight: 600;"><?php echo ucfirst($new_status); ?></span>
    </div>
    
    <?php if ($new_status === 'shipped'): ?>
    <p style="margin-top: 20px;">Great news! Your order has been shipped and is on its way to you. You should receive it within 3-5 business days.</p>
    <?php elseif ($new_status === 'delivered'): ?>
    <p style="margin-top: 20px;">Your order has been delivered! We hope you enjoy your purchase. Please let us know if you have any feedback.</p>
    <?php elseif ($new_status === 'cancelled'): ?>
    <p style="margin-top: 20px;">Your order has been cancelled. If you have any questions, please contact our customer support.</p>
    <?php endif; ?>
    
    <div style="text-align: center; margin-top: 30px;">
        <a href="<?php echo SITE_URL; ?>/account/orders.php?order=<?php echo $order['id']; ?>" class="btn">View Order Details</a>
    </div>
    
    <p style="margin-top: 30px; font-size: 14px; color: #666;">
        Thank you for shopping with Dorsh Palestine!
    </p>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
