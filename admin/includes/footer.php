        </main>
        
        <!-- Footer -->
        <footer class="admin-footer">
            <p>&copy; <?php echo date('Y'); ?> Dorsh Palestine. All rights reserved.</p>
            <div class="footer-links">
                <a href="../" target="_blank">Visit Store</a>
                <a href="#">Documentation</a>
                <a href="#">Support</a>
            </div>
        </footer>
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/admin.js"></script>
    
    <script>
    // Sidebar Toggle
    document.getElementById('sidebarToggle')?.addEventListener('click', function() {
        document.getElementById('sidebar').classList.toggle('collapsed');
        document.getElementById('mainContent').classList.toggle('expanded');
    });
    
    document.getElementById('sidebarToggleMobile')?.addEventListener('click', function() {
        document.getElementById('sidebar').classList.toggle('mobile-open');
    });
    
    // Dropdown Menus
    document.querySelectorAll('.dropdown').forEach(dropdown => {
        const btn = dropdown.querySelector('button');
        const menu = dropdown.querySelector('.dropdown-menu');
        
        btn?.addEventListener('click', function(e) {
            e.stopPropagation();
            
            // Close other dropdowns
            document.querySelectorAll('.dropdown-menu').forEach(m => {
                if (m !== menu) m.classList.remove('show');
            });
            
            menu.classList.toggle('show');
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function() {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.classList.remove('show');
        });
    });
    
    // Initialize DataTables
    if (typeof $.fn.DataTable !== 'undefined') {
        $('.data-table').DataTable({
            pageLength: 25,
            order: [[0, 'desc']],
            language: {
                search: 'Search:',
                lengthMenu: 'Show _MENU_ entries',
                info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                paginate: {
                    first: 'First',
                    last: 'Last',
                    next: 'Next',
                    previous: 'Previous'
                }
            }
        });
    }
    </script>
</body>
</html>
