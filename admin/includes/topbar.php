<?php
/**
 * Admin Top Bar
 */

$admin_name = $_SESSION['admin_name'] ?? 'Admin';
$admin_email = $_SESSION['admin_email'] ?? '';
$admin_avatar = $_SESSION['admin_avatar'] ?? '../images/default-avatar.png';
?>
<header class="admin-topbar">
    <div class="topbar-left">
        <!-- Menu Toggle -->
        <button class="menu-toggle" id="menuToggle">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </button>
        
        <!-- Search -->
        <div class="topbar-search">
            <svg class="topbar-search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.35-4.35"></path>
            </svg>
            <input type="text" placeholder="<?php echo t('search'); ?>..." id="adminSearch">
        </div>
    </div>
    
    <div class="topbar-right">
        <!-- Language Switcher -->
        <a href="<?php echo getLanguageSwitchUrl(); ?>" class="topbar-btn" title="<?php echo getLanguageName(getOtherLanguage()); ?>">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="2" y1="12" x2="22" y2="12"></line>
                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
            </svg>
        </a>
        
        <!-- Notifications -->
        <button class="topbar-btn" id="notificationsBtn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
            </svg>
            <?php if (isset($stats['pending_orders']) && $stats['pending_orders'] > 0): ?>
            <span class="topbar-btn-badge"></span>
            <?php endif; ?>
        </button>
        
        <!-- Messages -->
        <button class="topbar-btn" id="messagesBtn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
            </svg>
        </button>
        
        <!-- User Menu -->
        <div class="topbar-user" id="userMenu">
            <img src="<?php echo htmlspecialchars($admin_avatar); ?>" alt="<?php echo htmlspecialchars($admin_name); ?>" class="user-avatar">
            <div class="user-info">
                <h4><?php echo htmlspecialchars($admin_name); ?></h4>
                <span><?php echo t('administrator'); ?></span>
            </div>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
        </div>
    </div>
</header>
