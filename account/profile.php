<?php
require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/functions.php';
require_once '../includes/language.php';

if (!isLoggedIn()) {
    header('Location: ../login.php');
    exit;
}

$page_title = t('profile');
$user = $_SESSION['user'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'update_profile') {
        $first_name = sanitize($_POST['first_name']);
        $last_name = sanitize($_POST['last_name']);
        $email = sanitize($_POST['email']);
        $phone = sanitize($_POST['phone'] ?? '');
        
        try {
            $db->query(
                "UPDATE users SET first_name = ?, last_name = ?, email = ?, phone = ? WHERE id = ?",
                [$first_name, $last_name, $email, $phone, $user['id']]
            );
            
            // Update session
            $_SESSION['user']['first_name'] = $first_name;
            $_SESSION['user']['last_name'] = $last_name;
            $_SESSION['user']['email'] = $email;
            $_SESSION['user']['phone'] = $phone;
            
            $success = t('profile_updated');
        } catch (Exception $e) {
            $error = t('update_failed');
        }
    } elseif ($action === 'change_password') {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        
        // Verify current password
        $user_data = $db->query("SELECT password FROM users WHERE id = ?", [$user['id']])->fetch();
        
        if (!password_verify($current_password, $user_data['password'])) {
            $error = t('current_password_incorrect');
        } elseif ($new_password !== $confirm_password) {
            $error = t('passwords_not_match');
        } elseif (strlen($new_password) < 6) {
            $error = t('password_too_short');
        } else {
            $hashed = password_hash($new_password, PASSWORD_DEFAULT);
            $db->query("UPDATE users SET password = ? WHERE id = ?", [$hashed, $user['id']]);
            $success = t('password_changed');
        }
    }
    
    // Reload user data
    $user = $db->query("SELECT * FROM users WHERE id = ?", [$user['id']])->fetch();
    $_SESSION['user'] = $user;
}

include '../includes/header.php';
?>

<div class="account-page">
    <div class="container">
        <div class="account-layout">
            <!-- Sidebar -->
            <aside class="account-sidebar">
                <div class="user-info">
                    <div class="user-avatar">
                        <?php echo strtoupper(substr($user['first_name'], 0, 1)); ?>
                    </div>
                    <h3><?php echo h($user['first_name'] . ' ' . $user['last_name']); ?></h3>
                    <p><?php echo h($user['email']); ?></p>
                </div>
                <nav class="account-nav">
                    <a href="index.php"><i class="fas fa-home"></i> <?php echo t('dashboard'); ?></a>
                    <a href="orders.php"><i class="fas fa-shopping-bag"></i> <?php echo t('my_orders'); ?></a>
                    <a href="profile.php" class="active"><i class="fas fa-user"></i> <?php echo t('profile'); ?></a>
                    <a href="../logout.php"><i class="fas fa-sign-out-alt"></i> <?php echo t('logout'); ?></a>
                </nav>
            </aside>
            
            <!-- Content -->
            <div class="account-content">
                <h1><?php echo t('profile'); ?></h1>
                
                <?php if (isset($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <!-- Profile Information -->
                <div class="profile-section">
                    <h2><?php echo t('profile_information'); ?></h2>
                    <form method="POST" class="profile-form">
                        <input type="hidden" name="action" value="update_profile">
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label"><?php echo t('first_name'); ?></label>
                                <input type="text" name="first_name" class="form-control" value="<?php echo h($user['first_name']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><?php echo t('last_name'); ?></label>
                                <input type="text" name="last_name" class="form-control" value="<?php echo h($user['last_name']); ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label"><?php echo t('email'); ?></label>
                            <input type="email" name="email" class="form-control" value="<?php echo h($user['email']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label"><?php echo t('phone'); ?></label>
                            <input type="tel" name="phone" class="form-control" value="<?php echo h($user['phone'] ?? ''); ?>">
                        </div>
                        <button type="submit" class="btn btn-primary"><?php echo t('save_changes'); ?></button>
                    </form>
                </div>
                
                <!-- Change Password -->
                <div class="profile-section">
                    <h2><?php echo t('change_password'); ?></h2>
                    <form method="POST" class="profile-form">
                        <input type="hidden" name="action" value="change_password">
                        <div class="form-group">
                            <label class="form-label"><?php echo t('current_password'); ?></label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label"><?php echo t('new_password'); ?></label>
                            <input type="password" name="new_password" class="form-control" minlength="6" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label"><?php echo t('confirm_password'); ?></label>
                            <input type="password" name="confirm_password" class="form-control" minlength="6" required>
                        </div>
                        <button type="submit" class="btn btn-primary"><?php echo t('update_password'); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.profile-section { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 25px; }
.profile-section h2 { font-size: 20px; font-weight: 600; margin-bottom: 25px; padding-bottom: 15px; border-bottom: 2px solid #eee; }
.profile-form .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
.profile-form .form-group { margin-bottom: 20px; }
.profile-form .form-label { display: block; margin-bottom: 8px; font-weight: 600; }
</style>

<?php include '../includes/footer.php'; ?>
