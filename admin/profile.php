<?php
session_start();
$page_title = 'My Profile';
require_once 'includes/header.php';

$admin = $db->query(
    "SELECT * FROM staff WHERE id = ?",
    [$_SESSION['admin_id']]
)->fetch();

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = sanitize($_POST['full_name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');
    
    if (empty($full_name) || empty($email)) {
        $error = 'Name and email are required';
    } else {
        $db->query(
            "UPDATE staff SET full_name = ?, email = ?, phone = ? WHERE id = ?",
            [$full_name, $email, $phone, $_SESSION['admin_id']]
        );
        
        $_SESSION['admin_name'] = $full_name;
        $_SESSION['admin_email'] = $email;
        
        $success = 'Profile updated successfully!';
        $admin['full_name'] = $full_name;
        $admin['email'] = $email;
        $admin['phone'] = $phone;
    }
}
?>

<style>
.profile-container {
    max-width: 800px;
    margin: 0 auto;
}

.profile-header {
    text-align: center;
    margin-bottom: 40px;
}

.profile-avatar-large {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 48px;
    color: white;
    font-weight: 700;
    margin-bottom: 20px;
    border: 5px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
}

.profile-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 40px;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 25px;
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

.form-control:focus {
    outline: none;
    border-color: rgba(52, 152, 219, 0.8);
    background: rgba(255, 255, 255, 0.15);
    box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.2);
}

.btn-primary {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
    padding: 14px 30px;
    border-radius: 12px;
    border: none;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(52, 152, 219, 0.4);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(52, 152, 219, 0.5);
}
</style>

<div class="profile-container">
    <div class="profile-header">
        <div class="profile-avatar-large">
            <?php echo strtoupper(substr($admin['full_name'], 0, 1)); ?>
        </div>
        <h2 style="color: white; font-size: 28px; margin-bottom: 5px;">
            <?php echo htmlspecialchars($admin['full_name']); ?>
        </h2>
        <p style="color: rgba(255, 255, 255, 0.7);">
            <?php echo htmlspecialchars($admin['role']); ?> • Joined <?php echo date('F Y', strtotime($admin['created_at'])); ?>
        </p>
    </div>
    
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
    
    <div class="profile-card">
        <h3 style="color: white; margin-bottom: 25px; font-size: 20px;">
            <i class="fas fa-user-edit"></i> Edit Profile
        </h3>
        
        <form method="POST">
            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input type="text" name="full_name" class="form-control" 
                       value="<?php echo htmlspecialchars($admin['full_name']); ?>" required>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" 
                           value="<?php echo htmlspecialchars($admin['email']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <input type="tel" name="phone" class="form-control" 
                           value="<?php echo htmlspecialchars($admin['phone'] ?? ''); ?>">
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" 
                       value="<?php echo htmlspecialchars($admin['username']); ?>" disabled>
            </div>
            
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i> Save Changes
            </button>
        </form>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>