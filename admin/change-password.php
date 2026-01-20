<?php
session_start();
$page_title = 'Change Password';
require_once 'includes/header.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $error = 'All fields are required';
    } elseif ($new_password !== $confirm_password) {
        $error = 'New passwords do not match';
    } elseif (strlen($new_password) < 6) {
        $error = 'Password must be at least 6 characters';
    } else {
        // Get current admin
        $admin = $db->query(
            "SELECT * FROM staff WHERE id = ?",
            [$_SESSION['admin_id']]
        )->fetch();
        
        if ($admin && password_verify($current_password, $admin['password'])) {
            // Update password
            $hashed = password_hash($new_password, PASSWORD_DEFAULT);
            $db->query(
                "UPDATE staff SET password = ? WHERE id = ?",
                [$hashed, $_SESSION['admin_id']]
            );
            
            // Log activity
            logAdminActivity($_SESSION['admin_id'], 'password_change', 'Password changed successfully');
            
            $success = 'Password changed successfully!';
        } else {
            $error = 'Current password is incorrect';
        }
    }
}
?>

<style>
.password-card {
    max-width: 600px;
    margin: 0 auto;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 40px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 25px;
}

.form-label {
    display: block;
    color: white;
    font-weight: 600;
    margin-bottom: 10px;
    font-size: 14px;
}

.form-control {
    width: 100%;
    padding: 14px 18px;
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.1);
    color: white;
    font-size: 15px;
    transition: all 0.3s ease;
}

.form-control::placeholder {
    color: rgba(255, 255, 255, 0.5);
}

.form-control:focus {
    outline: none;
    border-color: rgba(52, 152, 219, 0.8);
    background: rgba(255, 255, 255, 0.15);
    box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.2);
}

.btn {
    padding: 14px 30px;
    border-radius: 12px;
    border: none;
    font-weight: 600;
    font-size: 15px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 10px;
}

.btn-primary {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
    box-shadow: 0 4px 15px rgba(52, 152, 219, 0.4);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(52, 152, 219, 0.5);
}

.password-strength {
    height: 4px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 2px;
    margin-top: 8px;
    overflow: hidden;
}

.password-strength-bar {
    height: 100%;
    transition: all 0.3s ease;
}

.strength-weak { 
    width: 33%; 
    background: #e74c3c; 
}

.strength-medium { 
    width: 66%; 
    background: #f39c12; 
}

.strength-strong { 
    width: 100%; 
    background: #2ecc71; 
}
</style>

<div class="password-card">
    <h2 style="color: white; margin-bottom: 30px; font-size: 28px;">
        <i class="fas fa-key"></i> Change Password
    </h2>
    
    <?php if ($error): ?>
    <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <?php echo $error; ?>
    </div>
    <?php endif; ?>
    
    <?php if ($success): ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <?php echo $success; ?>
    </div>
    <?php endif; ?>
    
    <form method="POST">
        <div class="form-group">
            <label class="form-label">Current Password</label>
            <input type="password" name="current_password" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">New Password</label>
            <input type="password" name="new_password" id="newPassword" class="form-control" required>
            <div class="password-strength">
                <div class="password-strength-bar" id="strengthBar"></div>
            </div>
        </div>
        
        <div class="form-group">
            <label class="form-label">Confirm New Password</label>
            <input type="password" name="confirm_password" class="form-control" required>
        </div>
        
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Change Password
        </button>
    </form>
</div>

<script>
document.getElementById('newPassword').addEventListener('input', function(e) {
    const password = e.target.value;
    const strengthBar = document.getElementById('strengthBar');
    
    let strength = 0;
    if (password.length >= 6) strength++;
    if (password.length >= 10) strength++;
    if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^a-zA-Z0-9]/.test(password)) strength++;
    
    strengthBar.className = 'password-strength-bar';
    if (strength <= 2) {
        strengthBar.classList.add('strength-weak');
    } else if (strength <= 4) {
        strengthBar.classList.add('strength-medium');
    } else {
        strengthBar.classList.add('strength-strong');
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>