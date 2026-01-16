<?php
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/functions.php';
require_once 'includes/language.php';

if (isLoggedIn()) {
    header('Location: account/');
    exit;
}

$page_title = t('register');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = sanitize($_POST['first_name']);
    $last_name = sanitize($_POST['last_name']);
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validation
    if ($password !== $confirm_password) {
        $error = t('passwords_not_match');
    } else {
        // Check if email exists
        $existing = $db->query("SELECT id FROM users WHERE email = ?", [$email])->fetch();
        
        if ($existing) {
            $error = t('email_exists');
        } else {
            // Create user
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            
            $db->query(
                "INSERT INTO users (first_name, last_name, email, password, role, status, created_at) VALUES (?, ?, ?, ?, 'customer', 'active', NOW())",
                [$first_name, $last_name, $email, $hashed]
            );
            
            $_SESSION['success'] = t('registration_success');
            header('Location: login.php');
            exit;
        }
    }
}

include 'includes/header.php';
?>

<div class="auth-page">
    <div class="container">
        <div class="auth-box">
            <div class="auth-header">
                <h1><?php echo t('register'); ?></h1>
                <p><?php echo t('register_subtitle'); ?></p>
            </div>
            
            <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" class="auth-form">
                <div class="form-row">
                    <div class="form-group">
                        <label><?php echo t('first_name'); ?></label>
                        <input type="text" name="first_name" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label><?php echo t('last_name'); ?></label>
                        <input type="text" name="last_name" required class="form-control">
                    </div>
                </div>
                
                <div class="form-group">
                    <label><?php echo t('email'); ?></label>
                    <input type="email" name="email" required class="form-control">
                </div>
                
                <div class="form-group">
                    <label><?php echo t('password'); ?></label>
                    <input type="password" name="password" required minlength="6" class="form-control">
                </div>
                
                <div class="form-group">
                    <label><?php echo t('confirm_password'); ?></label>
                    <input type="password" name="confirm_password" required minlength="6" class="form-control">
                </div>
                
                <button type="submit" class="btn btn-primary btn-lg"><?php echo t('register'); ?></button>
            </form>
            
            <div class="auth-footer">
                <p><?php echo t('have_account'); ?> <a href="login.php"><?php echo t('login_now'); ?></a></p>
            </div>
        </div>
    </div>
</div>

<style>
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
</style>

<?php include 'includes/footer.php'; ?>
