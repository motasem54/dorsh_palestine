<!DOCTYPE html>
<html lang="<?php echo $current_lang ?? 'en'; ?>" dir="<?php echo isRTL() ? 'rtl' : 'ltr'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ($page_title ?? 'Shop') . ' - Dorsh Palestine'; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="top-bar-content">
                <div class="top-left">
                    <span><i class="fas fa-phone"></i> +970 599 123 456</span>
                    <span><i class="fas fa-envelope"></i> info@dorsh-palestine.com</span>
                </div>
                <div class="top-right">
                    <a href="?lang=en" class="<?php echo $current_lang === 'en' ? 'active' : ''; ?>">English</a>
                    <a href="?lang=ar" class="<?php echo $current_lang === 'ar' ? 'active' : ''; ?>">العربية</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Header -->
    <header class="main-header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <a href="/">
                        <i class="fas fa-store"></i>
                        <span>Dorsh Palestine</span>
                    </a>
                </div>
                
                <nav class="main-nav">
                    <a href="/"><?php echo t('home'); ?></a>
                    <a href="/shop.php"><?php echo t('shop'); ?></a>
                    <a href="/about.php"><?php echo t('about'); ?></a>
                    <a href="/contact.php"><?php echo t('contact'); ?></a>
                </nav>
                
                <div class="header-actions">
                    <button class="search-btn" onclick="toggleSearch()">
                        <i class="fas fa-search"></i>
                    </button>
                    
                    <a href="/cart.php" class="cart-btn">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count" id="cartCount"><?php echo getCartCount(); ?></span>
                    </a>
                    
                    <?php if (isLoggedIn()): ?>
                    <div class="user-menu">
                        <button class="user-btn" onclick="toggleUserMenu()">
                            <i class="fas fa-user"></i>
                        </button>
                        <div class="user-dropdown" id="userDropdown">
                            <a href="/account/"><i class="fas fa-home"></i> <?php echo t('my_account'); ?></a>
                            <a href="/account/orders.php"><i class="fas fa-shopping-bag"></i> <?php echo t('my_orders'); ?></a>
                            <a href="/logout.php"><i class="fas fa-sign-out-alt"></i> <?php echo t('logout'); ?></a>
                        </div>
                    </div>
                    <?php else: ?>
                    <a href="/login.php" class="login-btn">
                        <i class="fas fa-user"></i>
                    </a>
                    <?php endif; ?>
                    
                    <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Search Overlay -->
    <div class="search-overlay" id="searchOverlay">
        <div class="search-box">
            <input type="text" id="globalSearch" placeholder="<?php echo t('search_products'); ?>..." onkeyup="handleSearch(event)">
            <button onclick="toggleSearch()"><i class="fas fa-times"></i></button>
        </div>
    </div>
    
    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <a href="/"><?php echo t('home'); ?></a>
        <a href="/shop.php"><?php echo t('shop'); ?></a>
        <a href="/about.php"><?php echo t('about'); ?></a>
        <a href="/contact.php"><?php echo t('contact'); ?></a>
        <?php if (isLoggedIn()): ?>
        <a href="/account/"><?php echo t('my_account'); ?></a>
        <a href="/logout.php"><?php echo t('logout'); ?></a>
        <?php else: ?>
        <a href="/login.php"><?php echo t('login'); ?></a>
        <a href="/register.php"><?php echo t('register'); ?></a>
        <?php endif; ?>
    </div>
    
    <main>
