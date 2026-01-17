<?php
ob_start();
?>
<div class="email-header">
    <h1>Welcome to Dorsh Palestine!</h1>
    <p>Your account has been created successfully</p>
</div>
<div class="email-body">
    <p>Hi <?php echo htmlspecialchars($user['first_name']); ?>,</p>
    <p style="margin-top: 15px;">Welcome to Dorsh Palestine! We're excited to have you as part of our community.</p>
    
    <div class="info-box">
        Your account has been created with the email: <strong><?php echo htmlspecialchars($user['email']); ?></strong>
    </div>
    
    <h3 style="margin: 30px 0 15px;">What's Next?</h3>
    <ul style="line-height: 2; margin-left: 20px;">
        <li>Browse our collection of authentic Palestinian products</li>
        <li>Add items to your wishlist</li>
        <li>Enjoy secure checkout and fast shipping</li>
        <li>Track your orders in your account dashboard</li>
    </ul>
    
    <div style="text-align: center; margin-top: 40px;">
        <a href="<?php echo SITE_URL; ?>/shop.php" class="btn">Start Shopping</a>
    </div>
    
    <p style="margin-top: 30px; font-size: 14px; color: #666;">
        If you have any questions, feel free to reach out to our customer support team.
    </p>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
