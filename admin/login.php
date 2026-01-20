<?php
/**
 * Admin Login Page
 */

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../includes/functions.php';

// Redirect if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: index.php');
    exit;
}

$error = '';
$success = '';

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);
    
    if (empty($email) || empty($password)) {
        $error = 'Please enter email and password';
    } else {
        // Check credentials
        $admin = $db->query(
            "SELECT * FROM staff WHERE email = ? AND status = 'active' LIMIT 1",
            [$email]
        )->fetch();
        
        if ($admin && password_verify($password, $admin['password'])) {
            // Login successful
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['full_name']; // استخدم full_name بدل first_name + last_name
            $_SESSION['admin_email'] = $admin['email'];
            $_SESSION['admin_role'] = $admin['role'];
            
            // Update last login
            $db->query(
                "UPDATE staff SET last_login = NOW(), last_login_ip = ? WHERE id = ?",
                [$_SERVER['REMOTE_ADDR'] ?? '', $admin['id']]
            );
            
            // Remember me
            if ($remember) {
                $token = bin2hex(random_bytes(32));
                setcookie('admin_token', $token, time() + (86400 * 30), '/');
                
                // Save token to database (إذا فيه حقل remember_token)
                try {
                    $db->query(
                        "UPDATE staff SET remember_token = ? WHERE id = ?",
                        [$token, $admin['id']]
                    );
                } catch (Exception $e) {
                    // Ignore if remember_token column doesn't exist
                }
            }
            
            // Log activity
            logAdminActivity($admin['id'], 'login', 'Admin logged in');
            
            header('Location: index.php');
            exit;
        } else {
            $error = 'Invalid email or password';
            
            // Log failed attempt
            logFailedLogin($email);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Dorsch Palestine</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
body {
    background: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5364 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    position: relative;
    overflow: hidden;
    margin: 0;
    padding: 0;
}

/* خلفية متحركة */
body::before {
    content: '';
    position: absolute;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(52, 152, 219, 0.1) 1px, transparent 1px);
    background-size: 50px 50px;
    animation: backgroundMove 20s linear infinite;
}

@keyframes backgroundMove {
    0% { transform: translate(0, 0); }
    100% { transform: translate(50px, 50px); }
}

/* دوائر متحركة في الخلفية */
.floating-circles {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    pointer-events: none;
    z-index: 0;
}

.circle {
    position: absolute;
    border-radius: 50%;
    background: linear-gradient(135deg, rgba(52, 152, 219, 0.2), rgba(41, 128, 185, 0.1));
    animation: float 15s ease-in-out infinite;
}

.circle:nth-child(1) {
    width: 80px;
    height: 80px;
    top: 10%;
    left: 20%;
    animation-delay: 0s;
}

.circle:nth-child(2) {
    width: 120px;
    height: 120px;
    top: 60%;
    left: 80%;
    animation-delay: 2s;
}

.circle:nth-child(3) {
    width: 60px;
    height: 60px;
    top: 80%;
    left: 10%;
    animation-delay: 4s;
}

.circle:nth-child(4) {
    width: 100px;
    height: 100px;
    top: 30%;
    left: 70%;
    animation-delay: 6s;
}

@keyframes float {
    0%, 100% {
        transform: translateY(0) rotate(0deg);
        opacity: 0.5;
    }
    50% {
        transform: translateY(-30px) rotate(180deg);
        opacity: 0.8;
    }
}

.login-container {
    width: 100%;
    max-width: 480px;
    padding: 20px;
    position: relative;
    z-index: 10;
}

.login-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 25px;
    padding: 50px 45px;
    box-shadow: 
        0 20px 60px rgba(0, 0, 0, 0.3),
        0 0 100px rgba(52, 152, 219, 0.2);
    border: 1px solid rgba(52, 152, 219, 0.2);
    animation: cardEntrance 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
    position: relative;
    overflow: hidden;
}

/* تأثير الضوء المتحرك */
.login-card::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(
        45deg,
        transparent,
        rgba(52, 152, 219, 0.1),
        transparent
    );
    animation: shine 3s infinite;
}

@keyframes shine {
    0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
    100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
}

@keyframes cardEntrance {
    0% {
        opacity: 0;
        transform: scale(0.8) translateY(50px);
    }
    100% {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

.login-header {
    text-align: center;
    margin-bottom: 40px;
    position: relative;
    z-index: 1;
}

.login-logo {
    width: 100%;
    max-width: 250px;
    height: auto;
    margin: 0 auto 30px;
    display: block;
    animation: logoFloat 3s ease-in-out infinite;
    filter: drop-shadow(0 10px 20px rgba(52, 152, 219, 0.3));
}

@keyframes logoFloat {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}

.login-title {
    font-size: 34px;
    font-weight: 800;
    background: linear-gradient(135deg, #3498db, #2980b9);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 10px;
    letter-spacing: -0.5px;
    animation: titleGlow 2s ease-in-out infinite;
}

@keyframes titleGlow {
    0%, 100% {
        filter: drop-shadow(0 0 10px rgba(52, 152, 219, 0.3));
    }
    50% {
        filter: drop-shadow(0 0 20px rgba(52, 152, 219, 0.5));
    }
}

.login-subtitle {
    color: #7f8c8d;
    font-size: 16px;
    font-weight: 500;
    animation: fadeIn 1s ease-in 0.3s both;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.form-group {
    margin-bottom: 28px;
    position: relative;
    z-index: 1;
    animation: slideInLeft 0.6s ease-out both;
}

.form-group:nth-child(1) { animation-delay: 0.2s; }
.form-group:nth-child(2) { animation-delay: 0.3s; }

@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.form-label {
    display: block;
    margin-bottom: 12px;
    font-weight: 600;
    color: #2c3e50;
    font-size: 14px;
    letter-spacing: 0.3px;
}

.form-control {
    width: 100%;
    padding: 16px 20px;
    border: 2px solid #ecf0f1;
    border-radius: 12px;
    font-size: 15px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    background: #f8f9fa;
    box-sizing: border-box;
}

.form-control:focus {
    outline: none;
    border-color: #3498db;
    background: white;
    box-shadow: 
        0 0 0 4px rgba(52, 152, 219, 0.1),
        0 10px 30px rgba(52, 152, 219, 0.2);
    transform: translateY(-2px);
}

.input-icon {
    position: relative;
}

.input-icon i {
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    color: #3498db;
    font-size: 18px;
    transition: all 0.3s ease;
    pointer-events: none;
}

.input-icon .form-control {
    padding-right: 55px;
}

.input-icon .form-control:focus ~ i {
    color: #2980b9;
    animation: iconBounce 0.5s ease;
}

@keyframes iconBounce {
    0%, 100% { transform: translateY(-50%) scale(1); }
    50% { transform: translateY(-50%) scale(1.2); }
}

.form-check {
    display: flex;
    align-items: center;
    margin-bottom: 28px;
    animation: slideInLeft 0.6s ease-out 0.4s both;
}

.form-check input[type="checkbox"] {
    margin-right: 12px;
    width: 20px;
    height: 20px;
    cursor: pointer;
    accent-color: #3498db;
    transition: transform 0.2s ease;
}

.form-check input[type="checkbox"]:checked {
    animation: checkBounce 0.3s ease;
}

@keyframes checkBounce {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.2); }
}

.form-check label {
    color: #7f8c8d;
    font-size: 14px;
    cursor: pointer;
    user-select: none;
}

.btn-login {
    width: 100%;
    padding: 18px;
    background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 17px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 
        0 6px 20px rgba(52, 152, 219, 0.4),
        inset 0 -2px 10px rgba(0, 0, 0, 0.1);
    position: relative;
    overflow: hidden;
    animation: slideInLeft 0.6s ease-out 0.5s both;
}

.btn-login::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transition: left 0.5s ease;
}

.btn-login:hover::before {
    left: 100%;
}

.btn-login:hover {
    transform: translateY(-3px);
    box-shadow: 
        0 10px 30px rgba(52, 152, 219, 0.5),
        inset 0 -2px 10px rgba(0, 0, 0, 0.1);
}

.btn-login:active {
    transform: translateY(-1px);
}

.btn-login i {
    margin-right: 10px;
    transition: transform 0.3s ease;
}

.btn-login:hover i {
    transform: translateX(5px);
}

.alert {
    padding: 16px 20px;
    border-radius: 12px;
    margin-bottom: 28px;
    display: flex;
    align-items: center;
    gap: 14px;
    font-size: 14px;
    font-weight: 600;
    animation: alertSlide 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    position: relative;
    z-index: 1;
}

@keyframes alertSlide {
    0% {
        opacity: 0;
        transform: translateY(-20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

.alert i {
    font-size: 20px;
    animation: alertPulse 2s ease-in-out infinite;
}

@keyframes alertPulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
}

.alert-danger {
    background: linear-gradient(135deg, #fee 0%, #fdd 100%);
    color: #c33;
    border: 2px solid #fcc;
    box-shadow: 0 4px 15px rgba(204, 51, 51, 0.2);
}

.alert-success {
    background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
    color: #2e7d32;
    border: 2px solid #a5d6a7;
    box-shadow: 0 4px 15px rgba(46, 125, 50, 0.2);
}

/* Responsive */
@media (max-width: 768px) {
    .login-card {
        padding: 40px 30px;
        border-radius: 20px;
    }
    
    .login-title {
        font-size: 28px;
    }
    
    .login-logo {
        max-width: 200px;
    }
    
    .btn-login {
        padding: 16px;
        font-size: 16px;
    }
}

/* Loading Animation */
.btn-login.loading {
    pointer-events: none;
    opacity: 0.7;
}

.btn-login.loading::after {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    top: 50%;
    left: 50%;
    margin-left: -10px;
    margin-top: -10px;
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-top-color: white;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}
    </style>
</head>
<body>
    <!-- دوائر متحركة -->
    <div class="floating-circles">
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
    </div>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <img src="../images/logo.png" class="login-logo" alt="Dorsch Palestine">
                <h1 class="login-title">Admin Panel</h1>
                <p class="login-subtitle">Dorsch Palestine E-Commerce</p>
            </div>
            
            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?php echo htmlspecialchars($error); ?></span>
                </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span><?php echo htmlspecialchars($success); ?></span>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="" id="loginForm">
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <div class="input-icon">
                        <input type="email" name="email" class="form-control" placeholder="Enter your email" required autocomplete="email">
                        <i class="fas fa-envelope"></i>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="input-icon">
                        <input type="password" name="password" class="form-control" placeholder="Enter your password" required autocomplete="current-password">
                        <i class="fas fa-lock"></i>
                    </div>
                </div>
                
                <div class="form-check">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Remember me for 30 days</label>
                </div>
                
                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Login to Dashboard
                </button>
            </form>
        </div>
    </div>

    <script>
        // Loading animation on submit
        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.querySelector('.btn-login');
            btn.classList.add('loading');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Logging in...';
        });
    </script>
</body>
</html>