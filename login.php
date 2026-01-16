<?php
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/functions.php';
require_once 'includes/language.php';

if (isLoggedIn()) {
    header('Location: account/');
    exit;
}

$page_title = t('login');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    
    $user = $db->query("SELECT * FROM users WHERE email = ? AND status = 'active'", [$email])->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user'] = $user;
        
        $redirect = $_SESSION['redirect_after_login'] ?? 'account/';
        unset($_SESSION['redirect_after_login']);
        header('Location: ' . $redirect);
        exit;
    } else {
        $error = t('invalid_credentials');
    }
}

include 'includes/header.php';
?>

<div class="auth-page">
    <div class="container">
        <div class="auth-box">
            <div class="auth-header">
                <h1><?php echo t('login'); ?></h1>
                <p><?php echo t('login_subtitle'); ?></p>
            </div>
            
            <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" class="auth-form">
                <div class="form-group">
                    <label><?php echo t('email'); ?></label>
                    <input type="email" name="email" required class="form-control" placeholder="<?php echo t('enter_email'); ?>">
                </div>
                
                <div class="form-group">
                    <label><?php echo t('password'); ?></label>
                    <input type="password" name="password" required class="form-control" placeholder="<?php echo t('enter_password'); ?>">
                </div>
                
                <button type="submit" class="btn btn-primary btn-lg"><?php echo t('login'); ?></button>
            </form>
            
            <div class="auth-footer">
                <p><?php echo t('no_account'); ?> <a href="register.php"><?php echo t('register_now'); ?></a></p>
            </div>
        </div>
    </div>
</div>

<style>
.auth-page { padding: 60px 0; min-height: calc(100vh - 200px); display: flex; align-items: center; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
.auth-box { max-width: 450px; margin: 0 auto; background: white; padding: 40px; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
.auth-header { text-align: center; margin-bottom: 30px; }
.auth-header h1 { font-size: 32px; font-weight: 700; margin-bottom: 10px; }
.auth-header p { color: #666; }
.auth-form .form-group { margin-bottom: 20px; }
.auth-form label { display: block; margin-bottom: 8px; font-weight: 600; }
.auth-form .btn-lg { width: 100%; margin-top: 10px; }
.auth-footer { text-align: center; margin-top: 25px; padding-top: 25px; border-top: 1px solid #eee; }
.auth-footer a { color: #2563eb; font-weight: 600; }
</style>

<?php include 'includes/footer.php'; ?>
