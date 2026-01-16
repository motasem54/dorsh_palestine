/**
 * Admin Dashboard JavaScript
 */

// Sidebar Toggle
const menuToggle = document.getElementById('menuToggle');
const adminSidebar = document.getElementById('adminSidebar');
const adminMain = document.querySelector('.admin-main');

if (menuToggle) {
    menuToggle.addEventListener('click', () => {
        adminSidebar.classList.toggle('collapsed');
        adminMain.classList.toggle('expanded');
        
        // Mobile
        if (window.innerWidth <= 768) {
            adminSidebar.classList.toggle('active');
        }
    });
}

// Close sidebar on mobile when clicking outside
if (window.innerWidth <= 768) {
    document.addEventListener('click', (e) => {
        if (!adminSidebar.contains(e.target) && !menuToggle.contains(e.target)) {
            adminSidebar.classList.remove('active');
        }
    });
}

// Search
const adminSearch = document.getElementById('adminSearch');
if (adminSearch) {
    adminSearch.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase();
        // Implement search functionality
        console.log('Searching for:', query);
    });
}

// Notifications
const notificationsBtn = document.getElementById('notificationsBtn');
if (notificationsBtn) {
    notificationsBtn.addEventListener('click', () => {
        // Show notifications dropdown
        console.log('Show notifications');
    });
}

// Messages
const messagesBtn = document.getElementById('messagesBtn');
if (messagesBtn) {
    messagesBtn.addEventListener('click', () => {
        // Show messages dropdown
        console.log('Show messages');
    });
}

// User Menu
const userMenu = document.getElementById('userMenu');
if (userMenu) {
    userMenu.addEventListener('click', () => {
        // Show user menu dropdown
        console.log('Show user menu');
    });
}

// Auto-hide alerts after 5 seconds
const alerts = document.querySelectorAll('.alert');
alerts.forEach(alert => {
    setTimeout(() => {
        alert.style.opacity = '0';
        alert.style.transition = 'opacity 0.3s';
        setTimeout(() => alert.remove(), 300);
    }, 5000);
});

// Confirm delete actions
const deleteButtons = document.querySelectorAll('[data-action="delete"]');
deleteButtons.forEach(btn => {
    btn.addEventListener('click', (e) => {
        if (!confirm('Are you sure you want to delete this item?')) {
            e.preventDefault();
        }
    });
});

// DataTables initialization (if library is loaded)
if (typeof $ !== 'undefined' && $.fn.DataTable) {
    $('.data-table').DataTable({
        responsive: true,
        pageLength: 25,
        order: [[0, 'desc']]
    });
}

// Charts initialization (if Chart.js is loaded)
if (typeof Chart !== 'undefined') {
    // Sales chart example
    const salesChartCanvas = document.getElementById('salesChart');
    if (salesChartCanvas) {
        new Chart(salesChartCanvas, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Sales',
                    data: [12, 19, 3, 5, 2, 3],
                    borderColor: '#667eea',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }
}

// Form validation
const forms = document.querySelectorAll('.needs-validation');
forms.forEach(form => {
    form.addEventListener('submit', (e) => {
        if (!form.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        form.classList.add('was-validated');
    });
});

// Image preview
const imageInputs = document.querySelectorAll('input[type="file"][accept*="image"]');
imageInputs.forEach(input => {
    input.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                const preview = input.closest('.form-group').querySelector('.image-preview');
                if (preview) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
            };
            reader.readAsDataURL(file);
        }
    });
});

// Print functionality
const printButtons = document.querySelectorAll('[data-action="print"]');
printButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        window.print();
    });
});

// Export functionality
const exportButtons = document.querySelectorAll('[data-action="export"]');
exportButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        const format = btn.dataset.format || 'csv';
        console.log('Exporting as:', format);
        // Implement export logic
    });
});
