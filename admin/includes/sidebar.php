<?php
$current_page = $current_page ?? '';
?>
<aside class="admin-sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <i class="fas fa-shopping-bag"></i>
            <span>Dorsh Palestine</span>
        </div>
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
    </div>
    
    <nav class="sidebar-nav">
        <ul class="nav-menu">
            <li class="nav-item <?php echo $current_page === 'dashboard' ? 'active' : ''; ?>">
                <a href="/admin/index.php" class="nav-link">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
            <li class="nav-section">E-Commerce</li>
            
            <li class="nav-item <?php echo $current_page === 'products' ? 'active' : ''; ?>">
                <a href="/admin/products/" class="nav-link">
                    <i class="fas fa-box"></i>
                    <span>Products</span>
                    <span class="badge badge-info">NEW</span>
                </a>
            </li>
            
            <li class="nav-item <?php echo $current_page === 'categories' ? 'active' : ''; ?>">
                <a href="/admin/categories/" class="nav-link">
                    <i class="fas fa-tags"></i>
                    <span>Categories</span>
                </a>
            </li>
            
            <li class="nav-item <?php echo $current_page === 'orders' ? 'active' : ''; ?>">
                <a href="/admin/orders/" class="nav-link">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Orders</span>
                    <?php if ($pending_orders ?? 0 > 0): ?>
                    <span class="badge badge-warning"><?php echo $pending_orders; ?></span>
                    <?php endif; ?>
                </a>
            </li>
            
            <li class="nav-item <?php echo $current_page === 'customers' ? 'active' : ''; ?>">
                <a href="/admin/customers/" class="nav-link">
                    <i class="fas fa-users"></i>
                    <span>Customers</span>
                </a>
            </li>
            
            <li class="nav-section">Marketing</li>
            
            <li class="nav-item <?php echo $current_page === 'discounts' ? 'active' : ''; ?>">
                <a href="/admin/discounts/" class="nav-link">
                    <i class="fas fa-percent"></i>
                    <span>Discount Codes</span>
                </a>
            </li>
            
            <li class="nav-item <?php echo $current_page === 'abandoned-carts' ? 'active' : ''; ?>">
                <a href="/admin/abandoned-carts/" class="nav-link">
                    <i class="fas fa-cart-arrow-down"></i>
                    <span>Abandoned Carts</span>
                </a>
            </li>
            
            <li class="nav-section">Reports</li>
            
            <li class="nav-item <?php echo $current_page === 'reports' ? 'active' : ''; ?>">
                <a href="/admin/reports/" class="nav-link">
                    <i class="fas fa-chart-bar"></i>
                    <span>Sales Reports</span>
                </a>
            </li>
            
            <li class="nav-item <?php echo $current_page === 'analytics' ? 'active' : ''; ?>">
                <a href="/admin/analytics/" class="nav-link">
                    <i class="fas fa-chart-line"></i>
                    <span>Analytics</span>
                </a>
            </li>
            
            <li class="nav-section">System</li>
            
            <li class="nav-item <?php echo $current_page === 'staff' ? 'active' : ''; ?>">
                <a href="/admin/staff/" class="nav-link">
                    <i class="fas fa-user-tie"></i>
                    <span>Staff</span>
                </a>
            </li>
            
            <li class="nav-item <?php echo $current_page === 'settings' ? 'active' : ''; ?>">
                <a href="/admin/settings/" class="nav-link">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>
