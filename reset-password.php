<?php
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/functions.php';
require_once 'includes/language.php';

$page_title = t('reset_password');
$token = $_GET['token'] ?? '';

if (empty($token)) {
    header('Location: login.php');
    exit;
}

// Verify token
$reset = $db->query(
    "SELECT pr.*, u.* FROM password_resets pr
    JOIN users u ON pr.user_id = u.id
    WHERE pr.token = ? AND pr.expires_at > NOW() AND pr.used = 0",
    [$token]
)->fetch();

if (!$reset) {
    $error = t('invalid_or_expired_token');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($error)) {
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];
    
    if (strlen($password) < 6) {
        $error = t('password_too_short');
    } elseif ($password !== $confirm) {
        $error = t('passwords_not_match');
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        
        // Update password
        $db->query("UPDATE users SET password = ? WHERE id = ?", [$hashed, $reset['user_id']]);
        
        // Mark token as used
        $db->query("UPDATE password_resets SET used = 1 WHERE token = ?", [$token]);
        
        $_SESSION['success'] = t('password_reset_success');
        header('Location: login.php');
        exit;
    }
}

include 'includes/header.php';
?>

<div class="auth-page">
    <div class="container">
        <div class="auth-box">
            <h1><?php echo t('reset_password'); ?></h1>
            
            <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php else: ?>
            <p style="margin-bottom: 30px; color: #666;"><?php echo t('enter_new_password'); ?></p>
            
            <form method="POST">
                <div class="form-group">
                    <label class="form-label"><?php echo t('new_password'); ?></label>
                    <input type="password" name="password" class="form-control" minlength="6" required>
                </div>
                <div class="form-group">
                    <label class="form-label"><?php echo t('confirm_password'); ?></label>
                    <input type="password" name="confirm_password" class="form-control" minlength="6" required>
                </div>
                <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">
                    <?php echo t('reset_password'); ?>
                </button>
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
