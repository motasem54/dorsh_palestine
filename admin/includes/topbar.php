<header class="admin-topbar">
    <div class="topbar-left">
        <button class="mobile-menu-toggle" id="mobileMenuToggle">
            <i class="fas fa-bars"></i>
        </button>
        
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Search products, orders, customers..." id="globalSearch">
        </div>
    </div>
    
    <div class="topbar-right">
        <!-- Notifications -->
        <div class="topbar-item dropdown">
            <button class="icon-btn" id="notificationsBtn">
                <i class="fas fa-bell"></i>
                <span class="badge">3</span>
            </button>
            <div class="dropdown-menu" id="notificationsMenu">
                <div class="dropdown-header">Notifications</div>
                <div class="notification-item">
                    <i class="fas fa-shopping-cart text-primary"></i>
                    <div class="notification-content">
                        <p>New order #1234 received</p>
                        <span>2 minutes ago</span>
                    </div>
                </div>
                <div class="notification-item">
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    <div class="notification-content">
                        <p>Low stock alert for 3 products</p>
                        <span>1 hour ago</span>
                    </div>
                </div>
                <div class="notification-item">
                    <i class="fas fa-user text-success"></i>
                    <div class="notification-content">
                        <p>5 new customer registrations</p>
                        <span>3 hours ago</span>
                    </div>
                </div>
                <div class="dropdown-footer">
                    <a href="/admin/notifications/">View all notifications</a>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="topbar-item dropdown">
            <button class="icon-btn" id="quickActionsBtn">
                <i class="fas fa-plus-circle"></i>
            </button>
            <div class="dropdown-menu" id="quickActionsMenu">
                <div class="dropdown-header">Quick Actions</div>
                <a href="/admin/products/add.php" class="dropdown-item">
                    <i class="fas fa-box"></i> Add Product
                </a>
                <a href="/admin/orders/add.php" class="dropdown-item">
                    <i class="fas fa-shopping-cart"></i> Create Order
                </a>
                <a href="/admin/customers/add.php" class="dropdown-item">
                    <i class="fas fa-user-plus"></i> Add Customer
                </a>
                <a href="/admin/discounts/add.php" class="dropdown-item">
                    <i class="fas fa-percent"></i> Create Coupon
                </a>
            </div>
        </div>
        
        <!-- Admin Profile -->
        <div class="topbar-item dropdown">
            <button class="admin-profile-btn" id="profileBtn">
                <div class="admin-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="admin-info">
                    <span class="admin-name"><?php echo htmlspecialchars($current_admin['name']); ?></span>
                    <span class="admin-role"><?php echo ucfirst($current_admin['role']); ?></span>
                </div>
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right" id="profileMenu">
                <div class="dropdown-header">
                    Signed in as<br>
                    <strong><?php echo htmlspecialchars($current_admin['email']); ?></strong>
                </div>
                <a href="/admin/profile.php" class="dropdown-item">
                    <i class="fas fa-user"></i> My Profile
                </a>
                <a href="/admin/settings.php" class="dropdown-item">
                    <i class="fas fa-cog"></i> Settings
                </a>
                <a href="/admin/activity.php" class="dropdown-item">
                    <i class="fas fa-history"></i> Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a href="/admin/logout.php" class="dropdown-item text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </div>
</header>
