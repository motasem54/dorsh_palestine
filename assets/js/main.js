/**
 * Dorsh Palestine - Main JavaScript
 */

// Toggle Search
function toggleSearch() {
    document.getElementById('searchOverlay').classList.toggle('show');
    if (document.getElementById('searchOverlay').classList.contains('show')) {
        document.getElementById('globalSearch').focus();
    }
}

// Handle Search
function handleSearch(e) {
    if (e.key === 'Enter') {
        const query = e.target.value;
        if (query.trim()) {
            window.location.href = '/shop.php?search=' + encodeURIComponent(query);
        }
    }
}

// Toggle User Menu
function toggleUserMenu() {
    document.getElementById('userDropdown')?.classList.toggle('show');
}

// Toggle Mobile Menu
function toggleMobileMenu() {
    document.getElementById('mobileMenu').classList.toggle('show');
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('.user-menu')) {
        document.getElementById('userDropdown')?.classList.remove('show');
    }
    if (!e.target.closest('.mobile-menu-btn') && !e.target.closest('.mobile-menu')) {
        document.getElementById('mobileMenu').classList.remove('show');
    }
});

// Add to Cart
document.addEventListener('click', function(e) {
    if (e.target.closest('.add-to-cart')) {
        e.preventDefault();
        const btn = e.target.closest('.add-to-cart');
        const productId = btn.dataset.productId;
        const quantity = document.getElementById('quantity')?.value || 1;
        
        fetch('/api/cart.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=add&product_id=${productId}&quantity=${quantity}`
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                updateCartCount(data.cart_count);
                showNotification('Product added to cart!', 'success');
            }
        });
    }
});

// Update Cart Quantity
function updateCartQty(productId, change) {
    const input = document.querySelector(`[data-id="${productId}"] input`);
    const newQty = parseInt(input.value) + change;
    
    if (newQty < 1) return;
    
    fetch('/api/cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=update&product_id=${productId}&quantity=${newQty}`
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

// Remove from Cart
function removeFromCart(productId) {
    if (!confirm('Remove this item from cart?')) return;
    
    fetch('/api/cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=remove&product_id=${productId}`
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

// Update Cart Count
function updateCartCount(count) {
    const badge = document.getElementById('cartCount');
    if (badge) {
        badge.textContent = count;
    }
}

// Show Notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 25px;
        background: ${type === 'success' ? '#10b981' : '#2563eb'};
        color: white;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 99999;
        animation: slideIn 0.3s;
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Add animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
`;
document.head.appendChild(style);

console.log('Dorsh Palestine initialized!');
