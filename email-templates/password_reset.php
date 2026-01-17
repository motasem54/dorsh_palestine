<?php
ob_start();
?>
<div class="email-header">
    <h1>Reset Your Password</h1>
    <p>You requested a password reset</p>
</div>
<div class="email-body">
    <p>Hi <?php echo htmlspecialchars($user['first_name']); ?>,</p>
    <p style="margin-top: 15px;">We received a request to reset your password for your Dorsh Palestine account.</p>
    
    <div class="info-box">
        Click the button below to reset your password. This link will expire in 1 hour.
    </div>
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="<?php echo $reset_link; ?>" class="btn">Reset Password</a>
    </div>
    
    <p style="font-size: 14px; color: #666;">
        If the button doesn't work, copy and paste this link into your browser:<br>
        <a href="<?php echo $reset_link; ?>" style="color: #2563eb; word-break: break-all;"><?php echo $reset_link; ?></a>
    </p>
    
    <div style="margin-top: 30px; padding: 15px; background: #fff3cd; border-left: 4px solid #ffc107; border-radius: 4px;">
        <strong>Security Notice:</strong> If you didn't request this password reset, please ignore this email. Your password will remain unchanged.
    </div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
