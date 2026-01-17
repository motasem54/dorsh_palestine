<?php
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/functions.php';
require_once 'includes/language.php';
require_once 'includes/email.php';

$page_title = t('forgot_password');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email']);
    
    $user = $db->query("SELECT * FROM users WHERE email = ?", [$email])->fetch();
    
    if ($user) {
        // Generate reset token
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        // Save token to database
        $db->query(
            "INSERT INTO password_resets (user_id, token, expires_at, created_at) VALUES (?, ?, ?, NOW())",
            [$user['id'], $token, $expires]
        );
        
        // Send email
        $emailService = new EmailService();
        $emailService->sendPasswordReset($user, $token);
        
        $success = t('password_reset_sent');
    } else {
        // Don't reveal if email exists or not (security)
        $success = t('password_reset_sent');
    }
}

include 'includes/header.php';
?>

<div class="auth-page">
    <div class="container">
        <div class="auth-box">
            <h1><?php echo t('forgot_password'); ?></h1>
            <p style="margin-bottom: 30px; color: #666;"><?php echo t('forgot_password_message'); ?></p>
            
            <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label class="form-label"><?php echo t('email'); ?></label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">
                    <?php echo t('send_reset_link'); ?>
                </button>
            </form>
            
            <div style="text-align: center; margin-top: 20px;">
                <a href="login.php"><?php echo t('back_to_login'); ?></a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
