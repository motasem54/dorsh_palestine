<?php
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <i class="fas fa-store"></i>
            <span>Dorsh Palestine</span>
        </div>
        <button class="sidebar-close" id="sidebarClose">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <nav class="sidebar-nav">
        <ul class="nav-list">
            <!-- Dashboard -->
            <li class="nav-item <?php echo $current_page == 'index' ? 'active' : ''; ?>">
                <a href="index.php">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
            <!-- Products -->
            <li class="nav-item has-submenu <?php echo in_array($current_page, ['products', 'add-product', 'edit-product', 'categories', 'brands']) ? 'active' : ''; ?>">
                <a href="#products-menu" class="submenu-toggle">
                    <i class="fas fa-box"></i>
                    <span>Products</span>
                    <i class="fas fa-chevron-down arrow"></i>
                </a>
                <ul class="submenu" id="products-menu">
                    <li><a href="products/">All Products</a></li>
                    <li><a href="products/add.php">Add New</a></li>
                    <li><a href="products/categories.php">Categories</a></li>
                    <li><a href="products/brands.php">Brands</a></li>
                    <li><a href="products/collections.php">Collections</a></li>
                </ul>
            </li>
            
            <!-- Orders -->
            <li class="nav-item has-submenu <?php echo in_array($current_page, ['orders', 'order-details']) ? 'active' : ''; ?>">
                <a href="#orders-menu" class="submenu-toggle">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Orders</span>
                    <i class="fas fa-chevron-down arrow"></i>
                </a>
                <ul class="submenu" id="orders-menu">
                    <li><a href="orders/">All Orders</a></li>
                    <li><a href="orders/?status=pending">Pending</a></li>
                    <li><a href="orders/?status=processing">Processing</a></li>
                    <li><a href="orders/?status=shipped">Shipped</a></li>
                    <li><a href="orders/?status=delivered">Delivered</a></li>
                    <li><a href="orders/?status=cancelled">Cancelled</a></li>
                </ul>
            </li>
            
            <!-- Customers -->
            <li class="nav-item <?php echo $current_page == 'customers' ? 'active' : ''; ?>">
                <a href="customers/">
                    <i class="fas fa-users"></i>
                    <span>Customers</span>
                </a>
            </li>
            
            <!-- Marketing -->
            <li class="nav-item has-submenu">
                <a href="#marketing-menu" class="submenu-toggle">
                    <i class="fas fa-bullhorn"></i>
                    <span>Marketing</span>
                    <i class="fas fa-chevron-down arrow"></i>
                </a>
                <ul class="submenu" id="marketing-menu">
                    <li><a href="marketing/discounts.php">Discount Codes</a></li>
                    <li><a href="marketing/promotions.php">Promotions</a></li>
                    <li><a href="marketing/abandoned-carts.php">Abandoned Carts</a></li>
                    <li><a href="marketing/newsletters.php">Newsletters</a></li>
                </ul>
            </li>
            
            <!-- Reports -->
            <li class="nav-item has-submenu <?php echo $current_page == 'reports' ? 'active' : ''; ?>">
                <a href="#reports-menu" class="submenu-toggle">
                    <i class="fas fa-chart-line"></i>
                    <span>Reports</span>
                    <i class="fas fa-chevron-down arrow"></i>
                </a>
                <ul class="submenu" id="reports-menu">
                    <li><a href="reports/sales.php">Sales Report</a></li>
                    <li><a href="reports/products.php">Products Report</a></li>
                    <li><a href="reports/customers.php">Customers Report</a></li>
                    <li><a href="reports/inventory.php">Inventory Report</a></li>
                </ul>
            </li>
            
            <!-- AI Chatbot -->
            <li class="nav-item <?php echo $current_page == 'chatbot' ? 'active' : ''; ?>">
                <a href="chatbot/">
                    <i class="fas fa-robot"></i>
                    <span>AI Chatbot</span>
                    <span class="badge-new">AI</span>
                </a>
            </li>
            
            <li class="nav-divider"></li>
            
            <!-- Settings -->
            <li class="nav-item has-submenu <?php echo $current_page == 'settings' ? 'active' : ''; ?>">
                <a href="#settings-menu" class="submenu-toggle">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                    <i class="fas fa-chevron-down arrow"></i>
                </a>
                <ul class="submenu" id="settings-menu">
                    <li><a href="settings/general.php">General</a></li>
                    <li><a href="settings/shipping.php">Shipping</a></li>
                    <li><a href="settings/payment.php">Payment</a></li>
                    <li><a href="settings/notifications.php">Notifications</a></li>
                    <li><a href="settings/languages.php">Languages</a></li>
                    <li><a href="settings/openai.php">OpenAI</a></li>
                </ul>
            </li>
            
            <!-- Staff Management -->
            <li class="nav-item <?php echo $current_page == 'staff' ? 'active' : ''; ?>">
                <a href="staff/">
                    <i class="fas fa-user-tie"></i>
                    <span>Staff</span>
                </a>
            </li>
        </ul>
    </nav>
    
    <div class="sidebar-footer">
        <div class="quick-stats">
            <div class="stat-item">
                <i class="fas fa-clock"></i>
                <span id="currentTime"></span>
            </div>
            <div class="stat-item">
                <i class="fas fa-calendar"></i>
                <span><?php echo date('M d, Y'); ?></span>
            </div>
        </div>
    </div>
</aside>

<script>
// Sidebar functionality
document.addEventListener('DOMContentLoaded', function() {
    // Toggle sidebar on mobile
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarClose = document.getElementById('sidebarClose');
    const sidebar = document.getElementById('sidebar');
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });
    }
    
    if (sidebarClose) {
        sidebarClose.addEventListener('click', function() {
            sidebar.classList.remove('active');
        });
    }
    
    // Submenu toggles
    const submenuToggles = document.querySelectorAll('.submenu-toggle');
    submenuToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const parent = this.parentElement;
            const submenu = document.querySelector(this.getAttribute('href'));
            
            // Close other submenus
            document.querySelectorAll('.nav-item.has-submenu').forEach(item => {
                if (item !== parent) {
                    item.classList.remove('open');
                }
            });
            
            parent.classList.toggle('open');
        });
    });
    
    // Auto-open active submenu
    const activeItem = document.querySelector('.nav-item.active');
    if (activeItem && activeItem.classList.contains('has-submenu')) {
        activeItem.classList.add('open');
    }
    
    // Update time
    function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('en-US', { 
            hour: '2-digit', 
            minute: '2-digit'
        });
        const timeElement = document.getElementById('currentTime');
        if (timeElement) {
            timeElement.textContent = timeString;
        }
    }
    updateTime();
    setInterval(updateTime, 60000); // Update every minute
});
</script>
