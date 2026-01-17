/**
 * Dorsch Palestine - Main JavaScript
 * All interactive functionality
 */

// ============================================================
// PRELOADER
// ============================================================
window.addEventListener('load', function() {
    const preloader = document.querySelector('.preloader-wrap');
    if (preloader) {
        setTimeout(() => {
            preloader.style.opacity = '0';
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 500);
        }, 1000);
    }
});

// ============================================================
// HEADER SCROLL EFFECT
// ============================================================
let lastScroll = 0;
const header = document.querySelector('.header-area');

window.addEventListener('scroll', function() {
    const currentScroll = window.pageYOffset;
    
    if (currentScroll > 100) {
        header.classList.add('scrolled');
        document.body.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
        document.body.classList.remove('scrolled');
    }
    
    lastScroll = currentScroll;
});

// ============================================================
// MOBILE MENU
// ============================================================
function toggleMobileMenu() {
    const mobileMenu = document.getElementById('mobileMenu');
    if (mobileMenu) {
        mobileMenu.classList.toggle('active');
        document.body.style.overflow = mobileMenu.classList.contains('active') ? 'hidden' : '';
    }
}

function closeMobileMenu() {
    const mobileMenu = document.getElementById('mobileMenu');
    if (mobileMenu) {
        mobileMenu.classList.remove('active');
        document.body.style.overflow = '';
    }
}

// ============================================================
// SEARCH BOX
// ============================================================
function openSearch(event) {
    event.preventDefault();
    const searchBox = document.getElementById('searchBox');
    const searchInput = document.getElementById('searchInput');
    
    if (searchBox) {
        searchBox.classList.add('active');
        document.body.style.overflow = 'hidden';
        
        if (searchInput) {
            setTimeout(() => searchInput.focus(), 300);
        }
    }
}

function closeSearch() {
    const searchBox = document.getElementById('searchBox');
    if (searchBox) {
        searchBox.classList.remove('active');
        document.body.style.overflow = '';
    }
}

// Close search on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeSearch();
        closeMobileMenu();
        closeChatbot();
    }
});

// ============================================================
// LANGUAGE SWITCHER
// ============================================================
let languageDropdownOpen = false;

function toggleLanguage() {
    const switcher = document.querySelector('.language-switcher');
    
    if (!languageDropdownOpen) {
        // Create dropdown if not exists
        let dropdown = document.getElementById('languageDropdown');
        
        if (!dropdown) {
            dropdown = document.createElement('div');
            dropdown.id = 'languageDropdown';
            dropdown.className = 'language-dropdown';
            dropdown.innerHTML = `
                <a href="#" onclick="changeLanguage('en'); return false;" class="lang-option">
                    <i class="fas fa-globe"></i>
                    <span>English</span>
                </a>
                <a href="#" onclick="changeLanguage('ar'); return false;" class="lang-option">
                    <i class="fas fa-globe"></i>
                    <span>العربية</span>
                </a>
                <a href="#" onclick="changeLanguage('he'); return false;" class="lang-option">
                    <i class="fas fa-globe"></i>
                    <span>עברית</span>
                </a>
            `;
            
            // Add styles
            const style = document.createElement('style');
            style.textContent = `
                .language-dropdown {
                    position: absolute;
                    top: calc(100% + 10px);
                    right: 0;
                    background: #fff;
                    border-radius: 12px;
                    box-shadow: 0 10px 40px rgba(0,0,0,0.15);
                    min-width: 180px;
                    overflow: hidden;
                    z-index: 1000;
                    animation: slideDown 0.3s ease;
                }
                
                @keyframes slideDown {
                    from {
                        opacity: 0;
                        transform: translateY(-10px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
                
                .lang-option {
                    display: flex;
                    align-items: center;
                    gap: 12px;
                    padding: 12px 20px;
                    color: #1a1a1a;
                    text-decoration: none;
                    transition: all 0.3s ease;
                    border-bottom: 1px solid #f0f0f0;
                }
                
                .lang-option:last-child {
                    border-bottom: none;
                }
                
                .lang-option:hover {
                    background: #f8f8f8;
                    color: #4A90E2;
                    padding-left: 25px;
                }
                
                .lang-option i {
                    color: #4A90E2;
                    font-size: 16px;
                }
                
                .lang-option span {
                    font-size: 14px;
                    font-weight: 600;
                }
            `;
            document.head.appendChild(style);
            
            switcher.style.position = 'relative';
            switcher.appendChild(dropdown);
        }
        
        dropdown.style.display = 'block';
        languageDropdownOpen = true;
    } else {
        const dropdown = document.getElementById('languageDropdown');
        if (dropdown) {
            dropdown.style.display = 'none';
        }
        languageDropdownOpen = false;
    }
}

function changeLanguage(lang) {
    // Send AJAX request to change language
    fetch('api/change-language.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ lang: lang })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Reload page to apply new language
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error changing language:', error);
        // Fallback: reload anyway
        location.reload();
    });
    
    // Close dropdown
    const dropdown = document.getElementById('languageDropdown');
    if (dropdown) {
        dropdown.style.display = 'none';
    }
    languageDropdownOpen = false;
}

// Close dropdown when clicking outside
document.addEventListener('click', function(e) {
    const switcher = document.querySelector('.language-switcher');
    const dropdown = document.getElementById('languageDropdown');
    
    if (switcher && dropdown && !switcher.contains(e.target)) {
        dropdown.style.display = 'none';
        languageDropdownOpen = false;
    }
});

// ============================================================
// CHATBOT
// ============================================================
function toggleChatbot() {
    const chatbot = document.getElementById('chatbotWindow');
    const button = document.querySelector('.chatbot-button');
    
    if (chatbot && button) {
        chatbot.classList.toggle('active');
        button.classList.toggle('active');
    }
}

function closeChatbot() {
    const chatbot = document.getElementById('chatbotWindow');
    const button = document.querySelector('.chatbot-button');
    
    if (chatbot && button) {
        chatbot.classList.remove('active');
        button.classList.remove('active');
    }
}

function handleKeyPress(event) {
    if (event.key === 'Enter') {
        sendMessage();
    }
}

function sendMessage() {
    const input = document.getElementById('chatbotInput');
    const message = input.value.trim();
    
    if (message) {
        addUserMessage(message);
        input.value = '';
        
        // Show typing indicator
        showTyping();
        
        // Simulate bot response
        setTimeout(() => {
            hideTyping();
            addBotMessage(getBotResponse(message));
        }, 1500);
    }
}

function sendQuickMessage(message) {
    const input = document.getElementById('chatbotInput');
    input.value = message;
    sendMessage();
}

function addUserMessage(message) {
    const chatBody = document.getElementById('chatbotBody');
    const messageDiv = document.createElement('div');
    messageDiv.className = 'chatbot-message user';
    messageDiv.innerHTML = `
        <div class="message-content">${escapeHtml(message)}</div>
    `;
    
    // Remove typing before last message
    const typing = chatBody.querySelector('.typing-indicator').parentElement;
    chatBody.insertBefore(messageDiv, typing);
    chatBody.scrollTop = chatBody.scrollHeight;
}

function addBotMessage(message) {
    const chatBody = document.getElementById('chatbotBody');
    const messageDiv = document.createElement('div');
    messageDiv.className = 'chatbot-message bot';
    messageDiv.innerHTML = `
        <div class="message-avatar">
            <i class="fas fa-robot"></i>
        </div>
        <div class="message-content">${message}</div>
    `;
    
    // Remove typing before last message
    const typing = chatBody.querySelector('.typing-indicator').parentElement;
    chatBody.insertBefore(messageDiv, typing);
    chatBody.scrollTop = chatBody.scrollHeight;
}

function showTyping() {
    const indicator = document.getElementById('typingIndicator');
    if (indicator) {
        indicator.classList.add('active');
    }
}

function hideTyping() {
    const indicator = document.getElementById('typingIndicator');
    if (indicator) {
        indicator.classList.remove('active');
    }
}

function getBotResponse(message) {
    message = message.toLowerCase();
    
    if (message.includes('premium') || message.includes('cookware')) {
        return 'Our Premium Cookware collection features ceramic-coated, PTFE & PFOA free products. Perfect for healthy cooking! Would you like to see our best sellers?';
    } else if (message.includes('lfgb') || message.includes('certified')) {
        return 'LFGB is the German food safety standard. All our products are certified to ensure the highest quality and safety for your family. 🇩🇪';
    } else if (message.includes('pressure') || message.includes('cooker')) {
        return 'Our GoPress pressure cookers cook 70% faster while preserving nutrients. Available in 4L, 6L, and 8L sizes. Check them out!';
    } else if (message.includes('warranty')) {
        return 'We offer different warranty periods: Lifetime warranty on selected series, and standard warranty on all products. Which product are you interested in?';
    } else if (message.includes('price') || message.includes('cost')) {
        return 'Our products range from $25 to $350. We offer free worldwide shipping on orders over $100. What\'s your budget?';
    } else if (message.includes('shipping') || message.includes('delivery')) {
        return 'We offer free worldwide shipping on orders over $100. Standard delivery takes 5-7 business days. Express shipping is also available!';
    } else {
        return 'Thanks for your message! I can help you with product information, specifications, pricing, and more. Feel free to ask me anything! 😊';
    }
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// ============================================================
// CART FUNCTIONS
// ============================================================
function addToCart(productId, quantity = 1) {
    fetch('api/cart-add.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateCartCount(data.cart_count);
            showNotification('Product added to cart!', 'success');
        } else {
            showNotification(data.message || 'Error adding to cart', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error adding to cart', 'error');
    });
}

function updateCartCount(count) {
    const counters = document.querySelectorAll('.cart-count');
    counters.forEach(counter => {
        counter.textContent = count;
        
        // Animate
        counter.style.transform = 'scale(1.3)';
        setTimeout(() => {
            counter.style.transform = 'scale(1)';
        }, 300);
    });
}

// ============================================================
// WISHLIST FUNCTIONS
// ============================================================
function toggleWishlist(productId, element) {
    fetch('api/wishlist-toggle.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ product_id: productId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.added) {
                element.classList.add('active');
                element.querySelector('i').className = 'fas fa-heart';
                showNotification('Added to wishlist!', 'success');
            } else {
                element.classList.remove('active');
                element.querySelector('i').className = 'far fa-heart';
                showNotification('Removed from wishlist', 'info');
            }
            updateWishlistCount(data.wishlist_count);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error updating wishlist', 'error');
    });
}

function updateWishlistCount(count) {
    const counters = document.querySelectorAll('.wishlist-count');
    counters.forEach(counter => {
        counter.textContent = count;
    });
}

// ============================================================
// COMPARE FUNCTIONS
// ============================================================
function toggleCompare(productId, element) {
    fetch('api/compare-toggle.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ product_id: productId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.added) {
                element.classList.add('active');
                showNotification('Added to compare (max 4)', 'success');
            } else {
                element.classList.remove('active');
                showNotification('Removed from compare', 'info');
            }
            updateCompareCount(data.compare_count);
        } else {
            showNotification(data.message || 'Error', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function updateCompareCount(count) {
    const counters = document.querySelectorAll('.compare-count');
    counters.forEach(counter => {
        counter.textContent = count;
    });
}

// ============================================================
// NOTIFICATIONS
// ============================================================
function showNotification(message, type = 'info') {
    // Remove existing notifications
    const existing = document.querySelector('.toast-notification');
    if (existing) {
        existing.remove();
    }
    
    // Create notification
    const notification = document.createElement('div');
    notification.className = `toast-notification toast-${type}`;
    
    const icons = {
        success: 'fa-check-circle',
        error: 'fa-exclamation-circle',
        warning: 'fa-exclamation-triangle',
        info: 'fa-info-circle'
    };
    
    notification.innerHTML = `
        <i class="fas ${icons[type] || icons.info}"></i>
        <span>${message}</span>
    `;
    
    document.body.appendChild(notification);
    
    // Show
    setTimeout(() => notification.classList.add('show'), 100);
    
    // Hide and remove
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Add notification styles
const notificationStyle = document.createElement('style');
notificationStyle.textContent = `
    .toast-notification {
        position: fixed;
        top: 100px;
        right: 30px;
        background: #fff;
        padding: 15px 25px;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        display: flex;
        align-items: center;
        gap: 12px;
        z-index: 10000;
        transform: translateX(400px);
        transition: all 0.3s ease;
        min-width: 250px;
    }
    
    .toast-notification.show {
        transform: translateX(0);
    }
    
    .toast-notification i {
        font-size: 20px;
    }
    
    .toast-success i { color: #27ae60; }
    .toast-error i { color: #e74c3c; }
    .toast-warning i { color: #f39c12; }
    .toast-info i { color: #4A90E2; }
    
    .toast-notification span {
        font-size: 14px;
        font-weight: 600;
        color: #1a1a1a;
    }
    
    @media (max-width: 768px) {
        .toast-notification {
            right: 15px;
            left: 15px;
            top: 80px;
        }
    }
`;
document.head.appendChild(notificationStyle);

// ============================================================
// AOS ANIMATION INIT
// ============================================================
if (typeof AOS !== 'undefined') {
    AOS.init({
        duration: 1000,
        once: true,
        offset: 100
    });
}

// ============================================================
// SWIPER SLIDERS INIT
// ============================================================
document.addEventListener('DOMContentLoaded', function() {
    // Products Swiper
    if (document.querySelector('.productsSwiper')) {
        new Swiper('.productsSwiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 3,
                },
                1024: {
                    slidesPerView: 4,
                },
            },
        });
    }
    
    // Reviews Swiper
    if (document.querySelector('.reviewsSwiper')) {
        new Swiper('.reviewsSwiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                640: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            },
        });
    }
});

console.log('✅ Dorsch Palestine - Main.js Loaded');
