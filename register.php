<?php
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/functions.php';
require_once 'includes/language.php';
require_once 'includes/email.php';

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
    if (strlen($password) < 6) {
        $error = t('password_too_short');
    } elseif ($password !== $confirm_password) {
        $error = t('passwords_not_match');
    } else {
        // Check if email exists
        $existing = $db->query("SELECT id FROM users WHERE email = ?", [$email])->fetch();
        
        if ($existing) {
            $error = t('email_already_exists');
        } else {
            // Create user
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            
            $db->query(
                "INSERT INTO users (first_name, last_name, email, password, role, status, created_at) 
                VALUES (?, ?, ?, ?, 'customer', 'active', NOW())",
                [$first_name, $last_name, $email, $hashed]
            );
            
            $user_id = $db->lastInsertId();
            $user = $db->query("SELECT * FROM users WHERE id = ?", [$user_id])->fetch();
            
            // Send welcome email
            $emailService = new EmailService();
            $emailService->sendWelcomeEmail($user);
            
            // Auto login
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user'] = $user;
            
            header('Location: account/');
            exit;
        }
    }
}

include 'includes/header.php';
?>

<div class="auth-page">
    <div class="container">
        <div class="auth-box">
            <h1><?php echo t('create_account'); ?></h1>
            
            <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label"><?php echo t('first_name'); ?> *</label>
                        <input type="text" name="first_name" class="form-control" required value="<?php echo $first_name ?? ''; ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?php echo t('last_name'); ?> *</label>
                        <input type="text" name="last_name" class="form-control" required value="<?php echo $last_name ?? ''; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label"><?php echo t('email'); ?> *</label>
                    <input type="email" name="email" class="form-control" required value="<?php echo $email ?? ''; ?>">
                </div>
                <div class="form-group">
                    <label class="form-label"><?php echo t('password'); ?> *</label>
                    <input type="password" name="password" class="form-control" minlength="6" required>
                    <small style="color: #999;"><?php echo t('password_hint'); ?></small>
                </div>
                <div class="form-group">
                    <label class="form-label"><?php echo t('confirm_password'); ?> *</label>
                    <input type="password" name="confirm_password" class="form-control" minlength="6" required>
                </div>
                <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">
                    <?php echo t('register'); ?>
                </button>
            </form>
            
            <div class="auth-footer">
                <p><?php echo t('already_have_account'); ?> <a href="login.php"><?php echo t('login'); ?></a></p>
            </div>
        </div>
    </div>
</div>

<style>
.auth-page { padding: 80px 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; }
.auth-box { max-width: 500px; margin: 0 auto; background: white; padding: 40px; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.15); }
.auth-box h1 { font-size: 28px; font-weight: 700; margin-bottom: 30px; text-align: center; }
.auth-footer { text-align: center; margin-top: 25px; padding-top: 25px; border-top: 1px solid #eee; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
@media (max-width: 768px) { .form-row { grid-template-columns: 1fr; } }
</style>

<?php include 'includes/footer.php'; ?>
