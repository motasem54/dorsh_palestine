<?php
if (!defined('ADMIN_PANEL')) define('ADMIN_PANEL', true);

$currentPage = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Admin Panel'; ?> - Dorsh Palestine</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../images/favicon.png">
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="assets/css/components.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</head>
<body class="admin-body">
    
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <img src="../images/logo.png" alt="Dorsh Palestine">
                <h2>Dorsh</h2>
            </div>
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        
        <nav class="sidebar-nav">
            <ul>
                <li class="<?php echo $currentPage == 'index' ? 'active' : ''; ?>">
                    <a href="index.php">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                <li class="nav-section">Products</li>
                <li class="<?php echo strpos($_SERVER['PHP_SELF'], '/products/') !== false ? 'active' : ''; ?>">
                    <a href="products/">
                        <i class="fas fa-box"></i>
                        <span>All Products</span>
                    </a>
                </li>
                <li>
                    <a href="products/add.php">
                        <i class="fas fa-plus-circle"></i>
                        <span>Add Product</span>
                    </a>
                </li>
                <li>
                    <a href="categories/">
                        <i class="fas fa-tags"></i>
                        <span>Categories</span>
                    </a>
                </li>
                
                <li class="nav-section">Orders</li>
                <li class="<?php echo strpos($_SERVER['PHP_SELF'], '/orders/') !== false ? 'active' : ''; ?>">
                    <a href="orders/">
                        <i class="fas fa-shopping-cart"></i>
                        <span>All Orders</span>
                    </a>
                </li>
                
                <li class="nav-section">Customers</li>
                <li class="<?php echo strpos($_SERVER['PHP_SELF'], '/customers/') !== false ? 'active' : ''; ?>">
                    <a href="customers/">
                        <i class="fas fa-users"></i>
                        <span>All Customers</span>
                    </a>
                </li>
                
                <li class="nav-section">Marketing</li>
                <li>
                    <a href="coupons/">
                        <i class="fas fa-ticket-alt"></i>
                        <span>Coupons</span>
                    </a>
                </li>
                <li>
                    <a href="newsletters/">
                        <i class="fas fa-envelope"></i>
                        <span>Newsletter</span>
                    </a>
                </li>
                
                <li class="nav-section">Reports</li>
                <li class="<?php echo strpos($_SERVER['PHP_SELF'], '/reports/') !== false ? 'active' : ''; ?>">
                    <a href="reports/">
                        <i class="fas fa-chart-bar"></i>
                        <span>Sales Reports</span>
                    </a>
                </li>
                
                <li class="nav-section">System</li>
                <li>
                    <a href="staff/">
                        <i class="fas fa-user-tie"></i>
                        <span>Staff</span>
                    </a>
                </li>
                <li class="<?php echo strpos($_SERVER['PHP_SELF'], '/settings/') !== false ? 'active' : ''; ?>">
                    <a href="settings/">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                </li>
            </ul>
        </nav>
        
        <div class="sidebar-footer">
            <a href="logout.php" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>
    
    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Top Navigation -->
        <header class="top-nav">
            <div class="nav-left">
                <button class="sidebar-toggle-mobile" id="sidebarToggleMobile">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="page-title"><?php echo $pageTitle ?? 'Dashboard'; ?></h1>
            </div>
            
            <div class="nav-right">
                <!-- Search -->
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search..." id="globalSearch">
                </div>
                
                <!-- Notifications -->
                <div class="dropdown notification-dropdown">
                    <button class="icon-btn" id="notificationBtn">
                        <i class="fas fa-bell"></i>
                        <span class="badge">3</span>
                    </button>
                    <div class="dropdown-menu" id="notificationMenu">
                        <div class="dropdown-header">
                            <h4>Notifications</h4>
                            <a href="#">Mark all as read</a>
                        </div>
                        <div class="notification-list">
                            <a href="#" class="notification-item unread">
                                <i class="fas fa-shopping-cart text-blue"></i>
                                <div>
                                    <p>New order received</p>
                                    <span class="time">2 minutes ago</span>
                                </div>
                            </a>
                            <a href="#" class="notification-item unread">
                                <i class="fas fa-exclamation-triangle text-orange"></i>
                                <div>
                                    <p>Low stock alert</p>
                                    <span class="time">1 hour ago</span>
                                </div>
                            </a>
                            <a href="#" class="notification-item">
                                <i class="fas fa-user text-green"></i>
                                <div>
                                    <p>New customer registered</p>
                                    <span class="time">3 hours ago</span>
                                </div>
                            </a>
                        </div>
                        <a href="notifications/" class="dropdown-footer">View all notifications</a>
                    </div>
                </div>
                
                <!-- Admin Profile -->
                <div class="dropdown profile-dropdown">
                    <button class="profile-btn" id="profileBtn">
                        <img src="<?php echo $_SESSION['admin_avatar'] ?? 'assets/images/default-avatar.png'; ?>" 
                             alt="Admin">
                        <span><?php echo $_SESSION['admin_name'] ?? 'Admin'; ?></span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu" id="profileMenu">
                        <a href="profile.php" class="dropdown-item">
                            <i class="fas fa-user"></i> My Profile
                        </a>
                        <a href="settings/" class="dropdown-item">
                            <i class="fas fa-cog"></i> Settings
                        </a>
                        <hr>
                        <a href="logout.php" class="dropdown-item text-danger">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Page Content -->
        <main class="page-content">
