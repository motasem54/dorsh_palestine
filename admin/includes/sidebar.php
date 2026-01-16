<?php
/**
 * Admin Sidebar Navigation
 */
?>
<aside class="admin-sidebar" id="adminSidebar">
    <!-- Logo -->
    <div class="admin-logo">
        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="40" height="40" rx="8" fill="url(#logo-gradient)"/>
            <path d="M20 10L12 16V26L20 32L28 26V16L20 10Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <defs>
                <linearGradient id="logo-gradient" x1="0" y1="0" x2="40" y2="40">
                    <stop offset="0%" stop-color="#667eea"/>
                    <stop offset="100%" stop-color="#764ba2"/>
                </linearGradient>
            </defs>
        </svg>
        <h2>Dorsh Admin</h2>
    </div>
    
    <!-- Navigation -->
    <nav class="admin-nav">
        <!-- Main Section -->
        <div class="nav-section">
            <div class="nav-section-title"><?php echo t('main'); ?></div>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="index.php" class="nav-link active">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="7" height="7"></rect>
                            <rect x="14" y="3" width="7" height="7"></rect>
                            <rect x="14" y="14" width="7" height="7"></rect>
                            <rect x="3" y="14" width="7" height="7"></rect>
                        </svg>
                        <span><?php echo t('dashboard'); ?></span>
                    </a>
                </li>
            </ul>
        </div>
        
        <!-- Ecommerce Section -->
        <div class="nav-section">
            <div class="nav-section-title"><?php echo t('ecommerce'); ?></div>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="products/index.php" class="nav-link">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                        </svg>
                        <span><?php echo t('products'); ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="categories/index.php" class="nav-link">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h6v6H4z"></path>
                            <path d="M14 4h6v6h-6z"></path>
                            <path d="M14 14h6v6h-6z"></path>
                            <path d="M4 14h6v6H4z"></path>
                        </svg>
                        <span><?php echo t('categories'); ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="orders/index.php" class="nav-link">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <path d="M16 10a4 4 0 0 1-8 0"></path>
                        </svg>
                        <span><?php echo t('orders'); ?></span>
                        <?php if (isset($stats['pending_orders']) && $stats['pending_orders'] > 0): ?>
                        <span class="nav-badge"><?php echo $stats['pending_orders']; ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="customers/index.php" class="nav-link">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <span><?php echo t('customers'); ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="discounts/index.php" class="nav-link">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="20 12 20 22 4 22 4 12"></polyline>
                            <rect x="2" y="7" width="20" height="5"></rect>
                            <line x1="12" y1="22" x2="12" y2="7"></line>
                            <path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path>
                            <path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path>
                        </svg>
                        <span><?php echo t('discounts'); ?></span>
                    </a>
                </li>
            </ul>
        </div>
        
        <!-- Reports Section -->
        <div class="nav-section">
            <div class="nav-section-title"><?php echo t('reports'); ?></div>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="reports/sales.php" class="nav-link">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                            <polyline points="17 6 23 6 23 12"></polyline>
                        </svg>
                        <span><?php echo t('sales_report'); ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="reports/products.php" class="nav-link">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="20" x2="18" y2="10"></line>
                            <line x1="12" y1="20" x2="12" y2="4"></line>
                            <line x1="6" y1="20" x2="6" y2="14"></line>
                        </svg>
                        <span><?php echo t('products_report'); ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="reports/customers.php" class="nav-link">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                        <span><?php echo t('customers_report'); ?></span>
                    </a>
                </li>
            </ul>
        </div>
        
        <!-- Settings Section -->
        <div class="nav-section">
            <div class="nav-section-title"><?php echo t('settings'); ?></div>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="settings/general.php" class="nav-link">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path d="M12 1v6m0 6v6m-8-8h6m6 0h6"></path>
                        </svg>
                        <span><?php echo t('general'); ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="settings/shipping.php" class="nav-link">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="1" y="3" width="15" height="13"></rect>
                            <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                            <circle cx="5.5" cy="18.5" r="2.5"></circle>
                            <circle cx="18.5" cy="18.5" r="2.5"></circle>
                        </svg>
                        <span><?php echo t('shipping'); ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="settings/payment.php" class="nav-link">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                            <line x1="1" y1="10" x2="23" y2="10"></line>
                        </svg>
                        <span><?php echo t('payment_methods'); ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="staff/index.php" class="nav-link">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <span><?php echo t('staff'); ?></span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</aside>
