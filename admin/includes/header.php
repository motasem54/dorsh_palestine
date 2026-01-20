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
$admin_trans = [
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

function at($key) {
    global $admin_trans, $admin_lang;
    return $admin_trans[$admin_lang][$key] ?? $key;
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
            --primary: #5dade2;
            --primary-dark: #3498db;
            --primary-light: #85c1e9;
            --secondary: #2ecc71;
            --danger: #e74c3c;
            --warning: #f39c12;
            --info: #17a2b8;
            --success: #28a745;
            --sidebar-width: 280px;
            --topbar-height: 75px;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5364 100%);
            background-attachment: fixed;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
            <?php if ($admin_lang === 'ar'): ?>
            direction: rtl;
            <?php endif; ?>
        }
        
        /* Animated Background */
        body::before {
            content: '';
            position: fixed;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(93, 173, 226, 0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: backgroundMove 20s linear infinite;
            z-index: 0;
        }
        
        @keyframes backgroundMove {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }
        
        /* Floating Circles */
        .floating-circles {
            position: fixed;
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
            background: linear-gradient(135deg, rgba(93, 173, 226, 0.2), rgba(52, 152, 219, 0.1));
            animation: float 15s ease-in-out infinite;
        }
        
        .circle:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 10%;
            <?php echo $admin_lang === 'ar' ? 'right' : 'left'; ?>: 20%;
            animation-delay: 0s;
        }
        
        .circle:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            <?php echo $admin_lang === 'ar' ? 'left' : 'right'; ?>: 20%;
            animation-delay: 2s;
        }
        
        .circle:nth-child(3) {
            width: 60px;
            height: 60px;
            top: 80%;
            <?php echo $admin_lang === 'ar' ? 'right' : 'left'; ?>: 10%;
            animation-delay: 4s;
        }
        
        .circle:nth-child(4) {
            width: 100px;
            height: 100px;
            top: 30%;
            <?php echo $admin_lang === 'ar' ? 'left' : 'right'; ?>: 30%;
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
        
        .admin-layout {
            display: flex;
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }
        
        /* SIDEBAR */
        .admin-sidebar {
            width: var(--sidebar-width);
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            position: fixed;
            <?php echo $admin_lang === 'ar' ? 'right' : 'left'; ?>: 0;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            border-<?php echo $admin_lang === 'ar' ? 'left' : 'right'; ?>: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        .sidebar-header {
            padding: 30px 25px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            text-align: center;
        }
        
        .sidebar-logo {
            width: 65px;
            height: 65px;
            margin: 0 auto 15px;
            background: linear-gradient(135deg, #5dade2, #3498db);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            color: white;
            box-shadow: 0 10px 25px rgba(93, 173, 226, 0.5);
            animation: logoFloat 3s ease-in-out infinite;
        }
        
        @keyframes logoFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .sidebar-header h2 {
            font-size: 22px;
            font-weight: 700;
            color: white;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            letter-spacing: 0.5px;
        }
        
        .sidebar-nav {
            padding: 25px 15px;
        }
        
        .nav-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 16px 20px;
            margin-bottom: 8px;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            border-radius: 15px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }
        
        .nav-item::before {
            content: '';
            position: absolute;
            top: 0;
            <?php echo $admin_lang === 'ar' ? 'right' : 'left'; ?>: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, #5dade2, #3498db);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }
        
        .nav-item:hover {
            background: rgba(93, 173, 226, 0.2);
            transform: translateX(<?php echo $admin_lang === 'ar' ? '-' : ''; ?>5px);
            box-shadow: 0 4px 15px rgba(93, 173, 226, 0.3);
        }
        
        .nav-item:hover::before {
            transform: scaleY(1);
        }
        
        .nav-item.active {
            background: rgba(93, 173, 226, 0.3);
            color: white;
            font-weight: 600;
            box-shadow: 0 6px 20px rgba(93, 173, 226, 0.4);
        }
        
        .nav-item.active::before {
            transform: scaleY(1);
        }
        
        .nav-item i {
            font-size: 19px;
            width: 26px;
            text-align: center;
        }
        
        /* TOP NAVBAR */
        .top-navbar {
            position: fixed;
            top: 0;
            <?php echo $admin_lang === 'ar' ? 'right' : 'left'; ?>: var(--sidebar-width);
            <?php echo $admin_lang === 'ar' ? 'left' : 'right'; ?>: 0;
            height: var(--topbar-height);
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.18);
            z-index: 999;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 35px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
        
        .topbar-left {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .search-box {
            position: relative;
            max-width: 400px;
            flex: 1;
        }
        
        .search-box input {
            width: 100%;
            padding: 14px 20px 14px 50px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.15);
            color: white;
            font-size: 15px;
            transition: all 0.3s ease;
        }
        
        <?php if ($admin_lang === 'ar'): ?>
        .search-box input {
            padding: 14px 50px 14px 20px;
        }
        <?php endif; ?>
        
        .search-box input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }
        
        .search-box input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(93, 173, 226, 0.6);
            box-shadow: 0 0 0 4px rgba(93, 173, 226, 0.2);
        }
        
        .search-box i {
            position: absolute;
            <?php echo $admin_lang === 'ar' ? 'right' : 'left'; ?>: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
            font-size: 16px;
        }
        
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        /* Language Switcher */
        .lang-switcher {
            display: flex;
            gap: 5px;
            background: rgba(255, 255, 255, 0.15);
            padding: 6px;
            border-radius: 25px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .lang-switcher a {
            padding: 10px 18px;
            border-radius: 20px;
            color: white;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .lang-switcher a.active {
            background: linear-gradient(135deg, #5dade2, #3498db);
            box-shadow: 0 4px 15px rgba(93, 173, 226, 0.5);
        }
        
        .lang-switcher a:hover:not(.active) {
            background: rgba(255, 255, 255, 0.2);
        }
        
        /* Notification Icon */
        .notification-icon {
            position: relative;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .notification-icon:hover {
            background: rgba(93, 173, 226, 0.3);
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(93, 173, 226, 0.4);
        }
        
        .notification-icon .badge {
            position: absolute;
            top: -3px;
            <?php echo $admin_lang === 'ar' ? 'left' : 'right'; ?>: -3px;
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            font-size: 11px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid rgba(15, 32, 39, 0.8);
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
            padding: 10px 18px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 30px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .profile-trigger:hover {
            background: rgba(93, 173, 226, 0.25);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(93, 173, 226, 0.4);
        }
        
        .profile-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #5dade2, #3498db);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        
        .profile-menu {
            position: absolute;
            top: calc(100% + 15px);
            <?php echo $admin_lang === 'ar' ? 'left' : 'right'; ?>: 0;
            min-width: 260px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(25px);
            border-radius: 18px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
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
            padding: 22px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            background: linear-gradient(135deg, rgba(93, 173, 226, 0.15), rgba(52, 152, 219, 0.08));
            border-radius: 18px 18px 0 0;
        }
        
        .profile-menu-header strong {
            display: block;
            color: #2c3e50;
            font-size: 17px;
            margin-bottom: 5px;
            font-weight: 700;
        }
        
        .profile-menu-header small {
            color: #7f8c8d;
            font-size: 13px;
        }
        
        .profile-menu a {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 15px 22px;
            color: #2c3e50;
            text-decoration: none;
            transition: all 0.2s ease;
            font-weight: 500;
        }
        
        .profile-menu a:hover {
            background: rgba(93, 173, 226, 0.12);
            padding-<?php echo $admin_lang === 'ar' ? 'right' : 'left'; ?>: 28px;
        }
        
        .profile-menu a:last-child {
            border-radius: 0 0 18px 18px;
        }
        
        .profile-menu a i {
            font-size: 17px;
            width: 22px;
            color: #5dade2;
        }
        
        .profile-menu a.danger {
            color: #e74c3c;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .profile-menu a.danger i {
            color: #e74c3c;
        }
        
        /* MAIN CONTENT */
        .admin-main {
            flex: 1;
            margin-<?php echo $admin_lang === 'ar' ? 'right' : 'left'; ?>: var(--sidebar-width);
            margin-top: var(--topbar-height);
            padding: 35px;
            min-height: calc(100vh - var(--topbar-height));
        }
        
        .page-header {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(25px);
            padding: 28px 35px;
            border-radius: 22px;
            margin-bottom: 30px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
        
        .page-header h1 {
            color: white;
            font-size: 34px;
            font-weight: 700;
            text-shadow: 0 2px 15px rgba(0, 0, 0, 0.3);
            letter-spacing: -0.5px;
        }
        
        .admin-content {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(25px);
            border-radius: 22px;
            padding: 35px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
        
        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 35px;
        }
        
        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 28px;
            display: flex;
            align-items: center;
            gap: 22px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, transparent, rgba(255, 255, 255, 0.1));
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(93, 173, 226, 0.3);
        }
        
        .stat-card:hover::before {
            opacity: 1;
        }
        
        .stat-icon {
            width: 70px;
            height: 70px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: white;
            flex-shrink: 0;
            position: relative;
            z-index: 1;
        }
        
        .stat-card.card-blue .stat-icon {
            background: linear-gradient(135deg, #5dade2, #3498db);
            box-shadow: 0 8px 20px rgba(93, 173, 226, 0.4);
        }
        
        .stat-card.card-green .stat-icon {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            box-shadow: 0 8px 20px rgba(46, 204, 113, 0.4);
        }
        
        .stat-card.card-purple .stat-icon {
            background: linear-gradient(135deg, #9b59b6, #8e44ad);
            box-shadow: 0 8px 20px rgba(155, 89, 182, 0.4);
        }
        
        .stat-card.card-orange .stat-icon {
            background: linear-gradient(135deg, #f39c12, #e67e22);
            box-shadow: 0 8px 20px rgba(243, 156, 18, 0.4);
        }
        
        .stat-details {
            flex: 1;
            position: relative;
            z-index: 1;
        }
        
        .stat-number {
            font-size: 32px;
            font-weight: 800;
            color: white;
            line-height: 1;
            margin-bottom: 8px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }
        
        .stat-label {
            font-size: 15px;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
            margin-bottom: 10px;
        }
        
        .stat-change {
            font-size: 13px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        .stat-change.positive {
            color: #2ecc71;
        }
        
        .stat-change.negative {
            color: #e74c3c;
        }
        
        .stat-info {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.7);
        }
        
        .badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .badge-warning {
            background: rgba(243, 156, 18, 0.2);
            color: #f39c12;
        }
        
        .badge-success {
            background: rgba(46, 204, 113, 0.2);
            color: #2ecc71;
        }
        
        .badge-danger {
            background: rgba(231, 76, 60, 0.2);
            color: #e74c3c;
        }
        
        .badge-info {
            background: rgba(93, 173, 226, 0.2);
            color: #5dade2;
        }
        
        /* Dashboard Cards */
        .dashboard-row {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 25px;
            margin-bottom: 25px;
        }
        
        .dashboard-col-12 { grid-column: span 12; }
        .dashboard-col-8 { grid-column: span 8; }
        .dashboard-col-6 { grid-column: span 6; }
        .dashboard-col-4 { grid-column: span 4; }
        
        .dashboard-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            overflow: hidden;
        }
        
        .card-header {
            padding: 22px 28px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .card-title {
            color: white;
            font-size: 18px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .card-body {
            padding: 28px;
        }
        
        .quick-stat-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        
        .quick-stat-item:last-child {
            border-bottom: none;
        }
        
        .quick-stat-label {
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
        }
        
        .quick-stat-value {
            color: white;
            font-weight: 700;
            font-size: 18px;
        }
        
        /* Tables */
        .table-responsive {
            overflow-x: auto;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table thead tr {
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
        }
        
        .table th {
            padding: 15px;
            text-align: left;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 600;
            font-size: 14px;
        }
        
        .table td {
            padding: 15px;
            color: rgba(255, 255, 255, 0.9);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .table tbody tr:hover {
            background: rgba(93, 173, 226, 0.08);
        }
        
        .table a {
            color: #5dade2;
            text-decoration: none;
            font-weight: 600;
        }
        
        .table a:hover {
            color: #85c1e9;
        }
        
        /* Alerts */
        .alert {
            padding: 18px 24px;
            border-radius: 15px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 14px;
            font-weight: 600;
            backdrop-filter: blur(10px);
            animation: slideDown 0.4s ease;
            border: 1px solid;
        }
        
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .alert-success {
            background: rgba(46, 204, 113, 0.2);
            color: #27ae60;
            border-color: rgba(46, 204, 113, 0.4);
        }
        
        .alert-error {
            background: rgba(231, 76, 60, 0.2);
            color: #e74c3c;
            border-color: rgba(231, 76, 60, 0.4);
        }
        
        .alert-warning {
            background: rgba(243, 156, 18, 0.2);
            color: #f39c12;
            border-color: rgba(243, 156, 18, 0.4);
        }
        
        .alert-link {
            color: inherit;
            text-decoration: underline;
            font-weight: 700;
        }
        
        /* Form Controls */
        .form-control {
            padding: 10px 16px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 14px;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #5dade2;
            background: rgba(255, 255, 255, 0.15);
        }
        
        .form-control-sm {
            padding: 8px 14px;
            font-size: 13px;
        }
        
        .btn {
            padding: 10px 20px;
            border-radius: 10px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-sm {
            padding: 8px 16px;
            font-size: 13px;
        }
        
        .btn-outline {
            background: transparent;
            border: 2px solid rgba(93, 173, 226, 0.5);
            color: #5dade2;
        }
        
        .btn-outline:hover {
            background: rgba(93, 173, 226, 0.2);
            border-color: #5dade2;
        }
        
        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1);
        }
        
        ::-webkit-scrollbar-thumb {
            background: rgba(93, 173, 226, 0.5);
            border-radius: 5px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(93, 173, 226, 0.7);
        }
        
        /* Mobile Toggle */
        .mobile-toggle {
            display: none;
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            color: white;
            font-size: 20px;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .mobile-toggle:hover {
            background: rgba(93, 173, 226, 0.3);
        }
        
        /* Responsive */
        @media (max-width: 1200px) {
            .dashboard-col-8,
            .dashboard-col-6,
            .dashboard-col-4 {
                grid-column: span 12;
            }
        }
        
        @media (max-width: 1024px) {
            :root {
                --sidebar-width: 240px;
            }
            
            .search-box {
                max-width: 280px;
            }
        }
        
        @media (max-width: 768px) {
            .mobile-toggle {
                display: flex;
            }
            
            .admin-sidebar {
                transform: translateX(<?php echo $admin_lang === 'ar' ? '' : '-'; ?>100%);
                box-shadow: none;
            }
            
            <?php if ($admin_lang === 'ar'): ?>
            .admin-sidebar {
                transform: translateX(100%);
            }
            <?php endif; ?>
            
            .admin-sidebar.active {
                transform: translateX(0);
                box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.5);
            }
            
            .top-navbar {
                left: 0;
                right: 0;
                padding: 0 20px;
            }
            
            .admin-main {
                margin-left: 0;
                margin-right: 0;
                padding: 20px;
            }
            
            .search-box {
                max-width: 180px;
            }
            
            .search-box input {
                padding: 12px 15px 12px 40px;
                font-size: 14px;
            }
            
            <?php if ($admin_lang === 'ar'): ?>
            .search-box input {
                padding: 12px 40px 12px 15px;
            }
            <?php endif; ?>
            
            .profile-trigger span {
                display: none;
            }
            
            .page-header h1 {
                font-size: 26px;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 480px) {
            .topbar-right {
                gap: 10px;
            }
            
            .lang-switcher a {
                padding: 8px 14px;
                font-size: 13px;
            }
            
            .notification-icon {
                width: 42px;
                height: 42px;
            }
            
            .admin-content {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Floating Circles Background -->
    <div class="floating-circles">
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
    </div>
    
    <div class="admin-layout">
        <!-- SIDEBAR -->
        <aside class="admin-sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <i class="fas fa-rocket"></i>
                </div>
                <h2>Dorsch Admin</h2>
            </div>
            <nav class="sidebar-nav">
                <a href="index.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
                    <i class="fas fa-tachometer-alt"></i>
                    <span><?php echo at('dashboard'); ?></span>
                </a>
                <a href="products/" class="nav-item <?php echo strpos($_SERVER['PHP_SELF'], '/products/') !== false ? 'active' : ''; ?>">
                    <i class="fas fa-box"></i>
                    <span><?php echo at('products'); ?></span>
                </a>
                <a href="categories/" class="nav-item <?php echo strpos($_SERVER['PHP_SELF'], '/categories/') !== false ? 'active' : ''; ?>">
                    <i class="fas fa-tags"></i>
                    <span><?php echo at('categories'); ?></span>
                </a>
                <a href="orders/" class="nav-item <?php echo strpos($_SERVER['PHP_SELF'], '/orders/') !== false ? 'active' : ''; ?>">
                    <i class="fas fa-shopping-cart"></i>
                    <span><?php echo at('orders'); ?></span>
                </a>
                <a href="customers/" class="nav-item <?php echo strpos($_SERVER['PHP_SELF'], '/customers/') !== false ? 'active' : ''; ?>">
                    <i class="fas fa-users"></i>
                    <span><?php echo at('customers'); ?></span>
                </a>
                <a href="coupons/" class="nav-item <?php echo strpos($_SERVER['PHP_SELF'], '/coupons/') !== false ? 'active' : ''; ?>">
                    <i class="fas fa-ticket-alt"></i>
                    <span><?php echo at('coupons'); ?></span>
                </a>
                <a href="reviews.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'reviews.php' ? 'active' : ''; ?>">
                    <i class="fas fa-star"></i>
                    <span><?php echo at('reviews'); ?></span>
                </a>
                <a href="settings/" class="nav-item <?php echo strpos($_SERVER['PHP_SELF'], '/settings/') !== false ? 'active' : ''; ?>">
                    <i class="fas fa-cog"></i>
                    <span><?php echo at('settings'); ?></span>
                </a>
            </nav>
        </aside>
        
        <!-- TOP NAVBAR -->
        <nav class="top-navbar">
            <div class="topbar-left">
                <div class="mobile-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </div>
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="<?php echo at('search'); ?>">
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
                            <span><?php echo at('profile'); ?></span>
                        </a>
                        <a href="change-password.php">
                            <i class="fas fa-key"></i>
                            <span><?php echo at('change_password'); ?></span>
                        </a>
                        <a href="logout.php" class="danger">
                            <i class="fas fa-sign-out-alt"></i>
                            <span><?php echo at('logout'); ?></span>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
        
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
                
    <script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('active');
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        const sidebar = document.getElementById('sidebar');
        const toggle = document.querySelector('.mobile-toggle');
        
        if (window.innerWidth <= 768) {
            if (!sidebar.contains(event.target) && !toggle.contains(event.target)) {
                sidebar.classList.remove('active');
            }
        }
    });
    </script>
