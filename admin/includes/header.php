<?php
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../../includes/functions.php';

$page_title = $page_title ?? 'Dashboard';
$admin_name = $_SESSION['admin_name'] ?? 'Admin';
$admin_role = $_SESSION['admin_role'] ?? 'admin';
$admin_email = $_SESSION['admin_email'] ?? '';

// Get admin language preference
$admin_lang = $_SESSION['admin_lang'] ?? 'en';
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'ar'])) {
    $_SESSION['admin_lang'] = $_GET['lang'];
    $admin_lang = $_GET['lang'];
}

// Admin translations
$trans = [
    'en' => [
        'dashboard' => 'Dashboard',
        'products' => 'Products',
        'categories' => 'Categories',
        'orders' => 'Orders',
        'customers' => 'Customers',
        'coupons' => 'Coupons',
        'reviews' => 'Reviews',
        'settings' => 'Settings',
        'profile' => 'Profile',
        'change_password' => 'Change Password',
        'logout' => 'Logout',
        'notifications' => 'Notifications',
        'no_notifications' => 'No new notifications',
        'welcome' => 'Welcome',
        'search' => 'Search...',
    ],
    'ar' => [
        'dashboard' => 'لوحة التحكم',
        'products' => 'المنتجات',
        'categories' => 'التصنيفات',
        'orders' => 'الطلبات',
        'customers' => 'العملاء',
        'coupons' => 'كوبونات الخصم',
        'reviews' => 'التقييمات',
        'settings' => 'الإعدادات',
        'profile' => 'الملف الشخصي',
        'change_password' => 'تغيير كلمة المرور',
        'logout' => 'تسجيل خروج',
        'notifications' => 'الإشعارات',
        'no_notifications' => 'لا توجد إشعارات جديدة',
        'welcome' => 'مرحباً',
        'search' => 'بحث...',
    ]
];

function t($key) {
    global $trans, $admin_lang;
    return $trans[$admin_lang][$key] ?? $key;
}

// Get notifications count
try {
    $notifications_count = $db->query(
        "SELECT COUNT(*) as count FROM notifications WHERE admin_id = ? AND is_read = 0",
        [$_SESSION['admin_id']]
    )->fetch()['count'] ?? 0;
} catch (Exception $e) {
    $notifications_count = 0;
}
?>
<!DOCTYPE html>
<html lang="<?php echo $admin_lang; ?>" dir="<?php echo $admin_lang === 'ar' ? 'rtl' : 'ltr'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?> - Dorsch Palestine Admin</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        :root {
            --primary: #3498db;
            --primary-dark: #2980b9;
            --secondary: #2ecc71;
            --danger: #e74c3c;
            --warning: #f39c12;
            --dark: #2c3e50;
            --light: #ecf0f1;
            --sidebar-width: 280px;
            --topbar-height: 70px;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background-attachment: fixed;
            color: #2c3e50;
            <?php if ($admin_lang === 'ar'): ?>
            direction: rtl;
            font-family: 'Segoe UI', Tahoma, Arial, sans-serif;
            <?php endif; ?>
        }
        
        /* Glassmorphism Background */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(120, 119, 198, 0.3), transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(252, 70, 107, 0.3), transparent 50%),
                radial-gradient(circle at 40% 60%, rgba(99, 125, 231, 0.3), transparent 50%);
            animation: gradientShift 15s ease infinite;
            pointer-events: none;
        }
        
        @keyframes gradientShift {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.1); }
        }
        
        .admin-layout {
            display: flex;
            min-height: 100vh;
            position: relative;
        }
        
        /* TOP NAVBAR */
        .top-navbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--topbar-height);
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            z-index: 999;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }
        
        .topbar-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .search-box {
            position: relative;
        }
        
        .search-box input {
            width: 350px;
            padding: 12px 20px 12px 45px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 25px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        .search-box input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        
        .search-box input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.3);
            box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.2);
        }
        
        .search-box i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
        }
        
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 25px;
        }
        
        /* Language Switcher */
        .lang-switcher {
            display: flex;
            gap: 5px;
            background: rgba(255, 255, 255, 0.2);
            padding: 5px;
            border-radius: 20px;
        }
        
        .lang-switcher a {
            padding: 8px 16px;
            border-radius: 15px;
            color: white;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .lang-switcher a.active {
            background: rgba(52, 152, 219, 0.8);
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.4);
        }
        
        .lang-switcher a:hover:not(.active) {
            background: rgba(255, 255, 255, 0.2);
        }
        
        /* Notifications */
        .notification-icon {
            position: relative;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .notification-icon:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.05);
        }
        
        .notification-icon .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #e74c3c;
            color: white;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            font-size: 11px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        
        /* Profile Dropdown */
        .profile-dropdown {
            position: relative;
        }
        
        .profile-trigger {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 15px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .profile-trigger:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }
        
        .profile-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
            border: 2px solid white;
        }
        
        .profile-menu {
            position: absolute;
            top: calc(100% + 15px);
            right: 0;
            min-width: 250px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }
        
        .profile-dropdown:hover .profile-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .profile-menu-header {
            padding: 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        .profile-menu-header strong {
            display: block;
            color: #2c3e50;
            font-size: 16px;
            margin-bottom: 5px;
        }
        
        .profile-menu-header small {
            color: #7f8c8d;
            font-size: 13px;
        }
        
        .profile-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 20px;
            color: #2c3e50;
            text-decoration: none;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }
        
        .profile-menu a:hover {
            background: rgba(52, 152, 219, 0.1);
            border-left-color: #3498db;
            padding-left: 25px;
        }
        
        .profile-menu a i {
            font-size: 16px;
            width: 20px;
            color: #3498db;
        }
        
        .profile-menu a.danger {
            color: #e74c3c;
        }
        
        .profile-menu a.danger i {
            color: #e74c3c;
        }
        
        /* SIDEBAR */
        .admin-sidebar {
            width: var(--sidebar-width);
            background: rgba(44, 62, 80, 0.95);
            backdrop-filter: blur(20px);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            box-shadow: 4px 0 30px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-header {
            padding: 25px 20px;
            background: rgba(0, 0, 0, 0.2);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .sidebar-logo {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        .sidebar-header h2 {
            font-size: 20px;
            font-weight: 700;
            color: white;
        }
        
        .sidebar-nav {
            padding: 20px 0;
        }
        
        .nav-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 14px 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            margin: 5px 10px;
            border-radius: 10px;
        }
        
        .nav-item:hover {
            background: rgba(52, 152, 219, 0.15);
            color: white;
            padding-left: 25px;
        }
        
        .nav-item.active {
            background: rgba(52, 152, 219, 0.25);
            border-left-color: #3498db;
            color: white;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.2);
        }
        
        .nav-item i {
            font-size: 18px;
            width: 24px;
        }
        
        /* MAIN CONTENT */
        .admin-main {
            flex: 1;
            margin-left: var(--sidebar-width);
            margin-top: var(--topbar-height);
            padding: 30px;
            min-height: calc(100vh - var(--topbar-height));
        }
        
        .page-header {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            padding: 25px 30px;
            border-radius: 20px;
            margin-bottom: 30px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        .page-header h1 {
            color: white;
            font-size: 32px;
            font-weight: 700;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }
        
        .admin-content {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        /* Alerts */
        .alert {
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            backdrop-filter: blur(10px);
            animation: slideDown 0.3s ease;
        }
        
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .alert-success {
            background: rgba(46, 204, 113, 0.2);
            color: #27ae60;
            border: 1px solid rgba(46, 204, 113, 0.3);
        }
        
        .alert-error {
            background: rgba(231, 76, 60, 0.2);
            color: #c0392b;
            border: 1px solid rgba(231, 76, 60, 0.3);
        }
        
        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1);
        }
        
        ::-webkit-scrollbar-thumb {
            background: rgba(52, 152, 219, 0.5);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(52, 152, 219, 0.7);
        }
    </style>
</head>
<body>
    <div class="admin-layout">
        <!-- TOP NAVBAR -->
        <nav class="top-navbar">
            <div class="topbar-left">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="<?php echo t('search'); ?>">
                </div>
            </div>
            <div class="topbar-right">
                <!-- Language Switcher -->
                <div class="lang-switcher">
                    <a href="?lang=en" class="<?php echo $admin_lang === 'en' ? 'active' : ''; ?>">EN</a>
                    <a href="?lang=ar" class="<?php echo $admin_lang === 'ar' ? 'active' : ''; ?>">ع</a>
                </div>
                
                <!-- Notifications -->
                <div class="notification-icon">
                    <i class="fas fa-bell"></i>
                    <?php if ($notifications_count > 0): ?>
                    <span class="badge"><?php echo $notifications_count; ?></span>
                    <?php endif; ?>
                </div>
                
                <!-- Profile Dropdown -->
                <div class="profile-dropdown">
                    <div class="profile-trigger">
                        <div class="profile-avatar">
                            <?php echo strtoupper(substr($admin_name, 0, 1)); ?>
                        </div>
                        <span><?php echo htmlspecialchars($admin_name); ?></span>
                        <i class="fas fa-chevron-down" style="font-size: 12px;"></i>
                    </div>
                    <div class="profile-menu">
                        <div class="profile-menu-header">
                            <strong><?php echo htmlspecialchars($admin_name); ?></strong>
                            <small><?php echo htmlspecialchars($admin_email); ?></small>
                        </div>
                        <a href="profile.php">
                            <i class="fas fa-user"></i>
                            <span><?php echo t('profile'); ?></span>
                        </a>
                        <a href="change-password.php">
                            <i class="fas fa-key"></i>
                            <span><?php echo t('change_password'); ?></span>
                        </a>
                        <a href="logout.php" class="danger">
                            <i class="fas fa-sign-out-alt"></i>
                            <span><?php echo t('logout'); ?></span>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
        
        <!-- SIDEBAR -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <i class="fas fa-rocket"></i>
                </div>
                <h2>Dorsch Admin</h2>
            </div>
            <nav class="sidebar-nav">
                <a href="index.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
                    <i class="fas fa-tachometer-alt"></i>
                    <span><?php echo t('dashboard'); ?></span>
                </a>
                <a href="products/" class="nav-item <?php echo strpos($_SERVER['PHP_SELF'], '/products/') !== false ? 'active' : ''; ?>">
                    <i class="fas fa-box"></i>
                    <span><?php echo t('products'); ?></span>
                </a>
                <a href="categories/" class="nav-item <?php echo strpos($_SERVER['PHP_SELF'], '/categories/') !== false ? 'active' : ''; ?>">
                    <i class="fas fa-tags"></i>
                    <span><?php echo t('categories'); ?></span>
                </a>
                <a href="orders/" class="nav-item <?php echo strpos($_SERVER['PHP_SELF'], '/orders/') !== false ? 'active' : ''; ?>">
                    <i class="fas fa-shopping-cart"></i>
                    <span><?php echo t('orders'); ?></span>
                </a>
                <a href="customers/" class="nav-item <?php echo strpos($_SERVER['PHP_SELF'], '/customers/') !== false ? 'active' : ''; ?>">
                    <i class="fas fa-users"></i>
                    <span><?php echo t('customers'); ?></span>
                </a>
                <a href="coupons/" class="nav-item <?php echo strpos($_SERVER['PHP_SELF'], '/coupons/') !== false ? 'active' : ''; ?>">
                    <i class="fas fa-ticket-alt"></i>
                    <span><?php echo t('coupons'); ?></span>
                </a>
                <a href="reviews.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'reviews.php' ? 'active' : ''; ?>">
                    <i class="fas fa-star"></i>
                    <span><?php echo t('reviews'); ?></span>
                </a>
                <a href="settings/" class="nav-item <?php echo strpos($_SERVER['PHP_SELF'], '/settings/') !== false ? 'active' : ''; ?>">
                    <i class="fas fa-cog"></i>
                    <span><?php echo t('settings'); ?></span>
                </a>
            </nav>
        </aside>
        
        <!-- MAIN CONTENT -->
        <main class="admin-main">
            <div class="page-header">
                <h1><?php echo htmlspecialchars($page_title); ?></h1>
            </div>
            
            <div class="admin-content">
                <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></span>
                </div>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></span>
                </div>
                <?php endif; ?>
