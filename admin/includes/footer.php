            </div> <!-- .page-content -->
            
            <!-- Footer -->
            <footer class="admin-footer">
                <div class="footer-content">
                    <p>&copy; <?php echo date('Y'); ?> Dorsh Palestine. All rights reserved.</p>
                    <p class="footer-links">
                        <a href="../" target="_blank">Visit Store</a>
                        <span>|</span>
                        <a href="help.php">Help</a>
                        <span>|</span>
                        <a href="about.php">About</a>
                    </p>
                </div>
            </footer>
        </div> <!-- .main-content -->
    </div> <!-- .admin-wrapper -->
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    
    <!-- Admin JS -->
    <script src="assets/js/admin.js"></script>
    
    <?php if (isset($extra_js)): ?>
        <?php foreach ($extra_js as $js): ?>
            <script src="<?php echo $js; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
    
    <script>
    // Dropdown menus
    document.addEventListener('DOMContentLoaded', function() {
        // Notifications dropdown
        const notifBtn = document.getElementById('notificationsBtn');
        const notifMenu = document.getElementById('notificationsMenu');
        
        if (notifBtn) {
            notifBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                notifMenu.classList.toggle('show');
                document.getElementById('userMenu').classList.remove('show');
            });
        }
        
        // User menu dropdown
        const userBtn = document.getElementById('userMenuBtn');
        const userMenu = document.getElementById('userMenu');
        
        if (userBtn) {
            userBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                userMenu.classList.toggle('show');
                notifMenu.classList.remove('show');
            });
        }
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function() {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.remove('show');
            });
        });
        
        // Prevent closing when clicking inside dropdown
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
        
        // Initialize DataTables
        if ($.fn.DataTable) {
            $('.data-table').DataTable({
                pageLength: 25,
                responsive: true,
                order: [[0, 'desc']]
            });
        }
        
        // Global search
        const globalSearch = document.getElementById('globalSearch');
        if (globalSearch) {
            globalSearch.addEventListener('input', function() {
                // Implement global search functionality
                console.log('Searching:', this.value);
            });
        }
    });
    </script>
</body>
</html>
