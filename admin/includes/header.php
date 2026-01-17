<?php
require_once __DIR__ . '/language.php';
$page_title = $page_title ?? at('admin_panel');
?>
<!DOCTYPE html>
<html lang="<?php echo getAdminLang(); ?>" dir="<?php echo isAdminRTL() ? 'rtl' : 'ltr'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - <?php echo at('admin_panel'); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/admin.css">
    <?php if (isAdminRTL()): ?>
    <link rel="stylesheet" href="assets/css/admin-rtl.css">
    <?php endif; ?>
</head>
<body>
    <div class="admin-layout">
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <h2><?php echo at('admin_panel'); ?></h2>
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
                <a href="settings/" class="nav-item <?php echo strpos($_SERVER['PHP_SELF'], '/settings/') !== false ? 'active' : ''; ?>">
                    <i class="fas fa-cog"></i>
                    <span><?php echo at('settings'); ?></span>
                </a>
            </nav>
            <div class="sidebar-footer">
                <div class="language-switcher">
                    <a href="?admin_lang=en" class="<?php echo getAdminLang() == 'en' ? 'active' : ''; ?>">EN</a>
                    <span>|</span>
                    <a href="?admin_lang=ar" class="<?php echo getAdminLang() == 'ar' ? 'active' : ''; ?>">AR</a>
                </div>
            </div>
        </aside>
        
        <main class="admin-main">
            <header class="admin-header">
                <div class="header-left">
                    <h1><?php echo $page_title; ?></h1>
                </div>
                <div class="header-right">
                    <span><?php echo at('welcome'); ?>, <?php echo $_SESSION['admin']['username']; ?></span>
                    <a href="logout.php" class="btn btn-logout">
                        <i class="fas fa-sign-out-alt"></i>
                        <?php echo at('logout'); ?>
                    </a>
                </div>
            </header>
            
            <div class="admin-content">
                <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
                <?php endif; ?>
