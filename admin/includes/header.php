<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?>Dorsh Palestine Admin</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    
    <!-- Admin CSS -->
    <link rel="stylesheet" href="assets/css/admin.css">
    
    <?php if (isset($extra_css)): ?>
        <?php foreach ($extra_css as $css): ?>
            <link rel="stylesheet" href="<?php echo $css; ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Navbar -->
            <nav class="top-navbar">
                <div class="navbar-left">
                    <button class="sidebar-toggle" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="page-title"><?php echo $page_title ?? 'Dashboard'; ?></h1>
                </div>
                
                <div class="navbar-right">
                    <!-- Search -->
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search..." id="globalSearch">
                    </div>
                    
                    <!-- Notifications -->
                    <div class="navbar-item dropdown">
                        <button class="icon-btn" id="notificationsBtn">
                            <i class="fas fa-bell"></i>
                            <span class="badge">3</span>
                        </button>
                        <div class="dropdown-menu" id="notificationsMenu">
                            <div class="dropdown-header">
                                <h4>Notifications</h4>
                                <a href="#">Mark all as read</a>
                            </div>
                            <div class="notifications-list">
                                <a href="#" class="notification-item unread">
                                    <i class="fas fa-shopping-cart"></i>
                                    <div>
                                        <p><strong>New order #1234</strong></p>
                                        <span>2 minutes ago</span>
                                    </div>
                                </a>
                                <a href="#" class="notification-item">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <div>
                                        <p><strong>Low stock alert</strong></p>
                                        <span>1 hour ago</span>
                                    </div>
                                </a>
                                <a href="#" class="notification-item">
                                    <i class="fas fa-user"></i>
                                    <div>
                                        <p><strong>New customer registered</strong></p>
                                        <span>3 hours ago</span>
                                    </div>
                                </a>
                            </div>
                            <div class="dropdown-footer">
                                <a href="notifications.php">View all notifications</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- User Menu -->
                    <div class="navbar-item dropdown">
                        <button class="user-btn" id="userMenuBtn">
                            <img src="assets/images/avatar-placeholder.png" alt="Admin">
                            <span><?php echo $_SESSION['admin_name'] ?? 'Admin'; ?></span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu" id="userMenu">
                            <a href="profile.php">
                                <i class="fas fa-user"></i> My Profile
                            </a>
                            <a href="settings.php">
                                <i class="fas fa-cog"></i> Settings
                            </a>
                            <a href="../index.php" target="_blank">
                                <i class="fas fa-globe"></i> Visit Store
                            </a>
                            <hr>
                            <a href="logout.php" class="text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
            
            <!-- Page Content -->
            <div class="page-content">
