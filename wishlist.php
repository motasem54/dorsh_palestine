<?php
$page_title = "Wishlist - Dorsch Palestine";
include 'header.php';
?>

<!-- Breadcrumb -->
<section class="breadcrumb-section" style="background: linear-gradient(135deg, #4A90E2 0%, #66A3E8 100%); padding: 60px 0; margin-top: 75px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-content text-center">
                    <h1 style="color: #fff; font-size: 48px; font-weight: 700; margin-bottom: 15px;">My Wishlist</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center" style="background: transparent; margin: 0; padding: 0;">
                            <li class="breadcrumb-item"><a href="index.php" style="color: #fff; text-decoration: none;">Home</a></li>
                            <li class="breadcrumb-item active" style="color: rgba(255,255,255,0.8);">Wishlist</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Wishlist Section -->
<section class="wishlist-section" style="padding: 100px 0; background: #fff;">
    <div class="container">
        <!-- Wishlist Header -->
        <div class="wishlist-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 50px; flex-wrap: wrap; gap: 20px;">
            <div>
                <h2 style="font-size: 36px; font-weight: 700; color: #1a1a1a; margin-bottom: 10px;">Your Wishlist</h2>
                <p style="font-size: 16px; color: #666; margin: 0;">You have <strong><span id="wishlistCount">5</span> items</strong> in your wishlist</p>
            </div>
            <div style="display: flex; gap: 15px;">
                <button onclick="addAllToCart()" style="background: #4A90E2; color: #fff; padding: 14px 30px; border: 2px solid #4A90E2; border-radius: 25px; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">
                    <i class="fas fa-shopping-cart" style="margin-right: 8px;"></i>Add All to Cart
                </button>
                <button onclick="clearWishlist()" style="background: transparent; border: 2px solid #e74c3c; color: #e74c3c; padding: 14px 30px; border-radius: 25px; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">
                    <i class="fas fa-trash-alt" style="margin-right: 8px;"></i>Clear All
                </button>
            </div>
        </div>

        <!-- Wishlist Grid -->
        <div class="row">
            <!-- Wishlist Item 1 -->
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="wishlist-item" style="background: #f8f8f8; border-radius: 20px; padding: 25px; position: relative; transition: all 0.3s ease; height: 100%;">
                    <!-- Remove Button -->
                    <button onclick="removeFromWishlist(this)" style="position: absolute; top: 15px; right: 15px; width: 40px; height: 40px; background: #fff; border: none; border-radius: 50%; color: #e74c3c; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; z-index: 2; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                        <i class="fas fa-times"></i>
                    </button>

                    <!-- Sale Badge -->
                    <span style="position: absolute; top: 15px; left: 15px; background: #e74c3c; color: #fff; padding: 6px 15px; border-radius: 20px; font-size: 12px; font-weight: 700; z-index: 2;">SALE</span>

                    <!-- Product Image -->
                    <div style="width: 100%; height: 200px; background: #fff; border-radius: 15px; overflow: hidden; margin-bottom: 20px; display: flex; align-items: center; justify-content: center;">
                        <img src="https://images.unsplash.com/photo-1556909212-d5b604d0c90d?w=300&h=300&fit=crop" alt="Product" style="max-width: 85%; max-height: 85%; object-fit: contain;">
                    </div>

                    <!-- Product Info -->
                    <div>
                        <p style="font-size: 12px; color: #4A90E2; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; margin-bottom: 8px;">Premium Cookware</p>
                        <h4 style="font-size: 18px; font-weight: 600; color: #1a1a1a; margin-bottom: 10px; min-height: 45px;">Premium Casserole 28cm</h4>
                        <p style="font-size: 13px; color: #999; margin-bottom: 15px; font-family: 'Courier New', monospace;">DH-05468</p>

                        <!-- Price -->
                        <div style="margin-bottom: 15px;">
                            <span style="font-size: 24px; font-weight: 700; color: #4A90E2;">$89.00</span>
                            <span style="font-size: 16px; color: #999; text-decoration: line-through; margin-left: 10px;">$110.00</span>
                        </div>

                        <!-- Stock Status -->
                        <div style="display: flex; align-items: center; margin-bottom: 15px; gap: 8px;">
                            <i class="fas fa-check-circle" style="color: #27ae60; font-size: 14px;"></i>
                            <span style="font-size: 14px; color: #27ae60; font-weight: 600;">In Stock</span>
                        </div>

                        <!-- Add to Cart Button -->
                        <button onclick="addToCart(this)" style="width: 100%; background: #4A90E2; color: #fff; padding: 14px; border: 2px solid #4A90E2; border-radius: 25px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 10px;">
                            <i class="fas fa-shopping-cart"></i>Add to Cart
                        </button>
                    </div>
                </div>
            </div>

            <!-- Wishlist Item 2 -->
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="wishlist-item" style="background: #f8f8f8; border-radius: 20px; padding: 25px; position: relative; transition: all 0.3s ease; height: 100%;">
                    <button onclick="removeFromWishlist(this)" style="position: absolute; top: 15px; right: 15px; width: 40px; height: 40px; background: #fff; border: none; border-radius: 50%; color: #e74c3c; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; z-index: 2; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                        <i class="fas fa-times"></i>
                    </button>

                    <span style="position: absolute; top: 15px; left: 15px; background: #27ae60; color: #fff; padding: 6px 15px; border-radius: 20px; font-size: 12px; font-weight: 700; z-index: 2;">NEW</span>

                    <div style="width: 100%; height: 200px; background: #fff; border-radius: 15px; overflow: hidden; margin-bottom: 20px; display: flex; align-items: center; justify-content: center;">
                        <img src="https://images.unsplash.com/photo-1556909212-d5b604d0c90d?w=300&h=300&fit=crop" alt="Product" style="max-width: 85%; max-height: 85%; object-fit: contain;">
                    </div>

                    <div>
                        <p style="font-size: 12px; color: #4A90E2; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; margin-bottom: 8px;">Premium Cookware</p>
                        <h4 style="font-size: 18px; font-weight: 600; color: #1a1a1a; margin-bottom: 10px; min-height: 45px;">Premium Fry Pan 28cm</h4>
                        <p style="font-size: 13px; color: #999; margin-bottom: 15px; font-family: 'Courier New', monospace;">DH-05488</p>

                        <div style="margin-bottom: 15px;">
                            <span style="font-size: 24px; font-weight: 700; color: #4A90E2;">$75.00</span>
                        </div>

                        <div style="display: flex; align-items: center; margin-bottom: 15px; gap: 8px;">
                            <i class="fas fa-check-circle" style="color: #27ae60; font-size: 14px;"></i>
                            <span style="font-size: 14px; color: #27ae60; font-weight: 600;">In Stock</span>
                        </div>

                        <button onclick="addToCart(this)" style="width: 100%; background: #4A90E2; color: #fff; padding: 14px; border: 2px solid #4A90E2; border-radius: 25px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 10px;">
                            <i class="fas fa-shopping-cart"></i>Add to Cart
                        </button>
                    </div>
                </div>
            </div>

            <!-- Wishlist Item 3 -->
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="wishlist-item" style="background: #f8f8f8; border-radius: 20px; padding: 25px; position: relative; transition: all 0.3s ease; height: 100%;">
                    <button onclick="removeFromWishlist(this)" style="position: absolute; top: 15px; right: 15px; width: 40px; height: 40px; background: #fff; border: none; border-radius: 50%; color: #e74c3c; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; z-index: 2; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                        <i class="fas fa-times"></i>
                    </button>

                    <div style="width: 100%; height: 200px; background: #fff; border-radius: 15px; overflow: hidden; margin-bottom: 20px; display: flex; align-items: center; justify-content: center;">
                        <img src="https://images.unsplash.com/photo-1585515320310-259814833e62?w=300&h=300&fit=crop" alt="Product" style="max-width: 85%; max-height: 85%; object-fit: contain;">
                    </div>

                    <div>
                        <p style="font-size: 12px; color: #4A90E2; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; margin-bottom: 8px;">GoPress</p>
                        <h4 style="font-size: 18px; font-weight: 600; color: #1a1a1a; margin-bottom: 10px; min-height: 45px;">GoPress Pressure Cooker 6L</h4>
                        <p style="font-size: 13px; color: #999; margin-bottom: 15px; font-family: 'Courier New', monospace;">DH-06436</p>

                        <div style="margin-bottom: 15px;">
                            <span style="font-size: 24px; font-weight: 700; color: #4A90E2;">$129.00</span>
                        </div>

                        <div style="display: flex; align-items: center; margin-bottom: 15px; gap: 8px;">
                            <i class="fas fa-check-circle" style="color: #27ae60; font-size: 14px;"></i>
                            <span style="font-size: 14px; color: #27ae60; font-weight: 600;">In Stock</span>
                        </div>

                        <button onclick="addToCart(this)" style="width: 100%; background: #4A90E2; color: #fff; padding: 14px; border: 2px solid #4A90E2; border-radius: 25px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 10px;">
                            <i class="fas fa-shopping-cart"></i>Add to Cart
                        </button>
                    </div>
                </div>
            </div>

            <!-- Wishlist Item 4 -->
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                <div class="wishlist-item" style="background: #f8f8f8; border-radius: 20px; padding: 25px; position: relative; transition: all 0.3s ease; height: 100%;">
                    <button onclick="removeFromWishlist(this)" style="position: absolute; top: 15px; right: 15px; width: 40px; height: 40px; background: #fff; border: none; border-radius: 50%; color: #e74c3c; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; z-index: 2; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                        <i class="fas fa-times"></i>
                    </button>

                    <span style="position: absolute; top: 15px; left: 15px; background: #e74c3c; color: #fff; padding: 6px 15px; border-radius: 20px; font-size: 12px; font-weight: 700; z-index: 2;">SALE</span>

                    <div style="width: 100%; height: 200px; background: #fff; border-radius: 15px; overflow: hidden; margin-bottom: 20px; display: flex; align-items: center; justify-content: center;">
                        <img src="https://images.unsplash.com/photo-1602143407151-7111542de6e8?w=300&h=300&fit=crop" alt="Product" style="max-width: 85%; max-height: 85%; object-fit: contain;">
                    </div>

                    <div>
                        <p style="font-size: 12px; color: #4A90E2; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; margin-bottom: 8px;">Coffee & Tea</p>
                        <h4 style="font-size: 18px; font-weight: 600; color: #1a1a1a; margin-bottom: 10px; min-height: 45px;">Whistling Tea Kettle 2.5L</h4>
                        <p style="font-size: 13px; color: #999; margin-bottom: 15px; font-family: 'Courier New', monospace;">DH-02906</p>

                        <div style="margin-bottom: 15px;">
                            <span style="font-size: 24px; font-weight: 700; color: #4A90E2;">$45.00</span>
                            <span style="font-size: 16px; color: #999; text-decoration: line-through; margin-left: 10px;">$60.00</span>
                        </div>

                        <div style="display: flex; align-items: center; margin-bottom: 15px; gap: 8px;">
                            <i class="fas fa-exclamation-circle" style="color: #ff9800; font-size: 14px;"></i>
                            <span style="font-size: 14px; color: #ff9800; font-weight: 600;">Low Stock</span>
                        </div>

                        <button onclick="addToCart(this)" style="width: 100%; background: #4A90E2; color: #fff; padding: 14px; border: 2px solid #4A90E2; border-radius: 25px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 10px;">
                            <i class="fas fa-shopping-cart"></i>Add to Cart
                        </button>
                    </div>
                </div>
            </div>

            <!-- Wishlist Item 5 -->
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4" data-aos="fade-up" data-aos-delay="500">
                <div class="wishlist-item" style="background: #f8f8f8; border-radius: 20px; padding: 25px; position: relative; transition: all 0.3s ease; height: 100%;">
                    <button onclick="removeFromWishlist(this)" style="position: absolute; top: 15px; right: 15px; width: 40px; height: 40px; background: #fff; border: none; border-radius: 50%; color: #e74c3c; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; z-index: 2; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                        <i class="fas fa-times"></i>
                    </button>

                    <div style="width: 100%; height: 200px; background: #fff; border-radius: 15px; overflow: hidden; margin-bottom: 20px; display: flex; align-items: center; justify-content: center;">
                        <img src="https://images.unsplash.com/photo-1578926314433-e2789279f4aa?w=300&h=300&fit=crop" alt="Product" style="max-width: 85%; max-height: 85%; object-fit: contain;">
                    </div>

                    <div>
                        <p style="font-size: 12px; color: #4A90E2; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; margin-bottom: 8px;">Cutlery</p>
                        <h4 style="font-size: 18px; font-weight: 600; color: #1a1a1a; margin-bottom: 10px; min-height: 45px;">Safari Cutlery Set 72 Pcs</h4>
                        <p style="font-size: 13px; color: #999; margin-bottom: 15px; font-family: 'Courier New', monospace;">DH-01998</p>

                        <div style="margin-bottom: 15px;">
                            <span style="font-size: 24px; font-weight: 700; color: #4A90E2;">$199.00</span>
                        </div>

                        <div style="display: flex; align-items: center; margin-bottom: 15px; gap: 8px;">
                            <i class="fas fa-check-circle" style="color: #27ae60; font-size: 14px;"></i>
                            <span style="font-size: 14px; color: #27ae60; font-weight: 600;">In Stock</span>
                        </div>

                        <button onclick="addToCart(this)" style="width: 100%; background: #4A90E2; color: #fff; padding: 14px; border: 2px solid #4A90E2; border-radius: 25px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 10px;">
                            <i class="fas fa-shopping-cart"></i>Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty State (Hidden by default) -->
        <div id="emptyWishlist" style="display: none; text-align: center; padding: 80px 20px;">
            <i class="far fa-heart" style="font-size: 120px; color: #e0e0e0; margin-bottom: 30px;"></i>
            <h3 style="font-size: 32px; font-weight: 700; color: #1a1a1a; margin-bottom: 15px;">Your Wishlist is Empty</h3>
            <p style="font-size: 18px; color: #666; margin-bottom: 35px;">Start adding products you love!</p>
            <a href="products.php" style="background: #4A90E2; color: #fff; padding: 16px 40px; border: 2px solid #4A90E2; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-block; transition: all 0.3s ease;">
                <i class="fas fa-shopping-bag" style="margin-right: 10px;"></i>Browse Products
            </a>
        </div>
    </div>
</section>

<!-- Share Wishlist -->
<section class="share-wishlist" style="padding: 80px 0; background: #f8f8f8;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 style="font-size: 32px; font-weight: 700; color: #1a1a1a; margin-bottom: 15px;">Share Your Wishlist</h3>
                <p style="font-size: 18px; color: #666; margin: 0;">Share your favorite products with friends and family</p>
            </div>
            <div class="col-lg-4 text-lg-end" style="display: flex; gap: 15px; justify-content: flex-end; flex-wrap: wrap;">
                <button onclick="shareWishlist('facebook')" style="width: 50px; height: 50px; border-radius: 50%; background: #1877f2; border: none; color: #fff; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                    <i class="fab fa-facebook-f"></i>
                </button>
                <button onclick="shareWishlist('whatsapp')" style="width: 50px; height: 50px; border-radius: 50%; background: #25d366; border: none; color: #fff; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                    <i class="fab fa-whatsapp"></i>
                </button>
                <button onclick="shareWishlist('email')" style="width: 50px; height: 50px; border-radius: 50%; background: #ea4335; border: none; color: #fff; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                    <i class="fas fa-envelope"></i>
                </button>
                <button onclick="copyWishlistLink()" style="width: 50px; height: 50px; border-radius: 50%; background: #666; border: none; color: #fff; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                    <i class="fas fa-link"></i>
                </button>
            </div>
        </div>
    </div>
</section>

<style>
/* Hover Effects */
.wishlist-item:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 50px rgba(0,0,0,0.15);
}

.wishlist-item button[onclick*="removeFromWishlist"]:hover {
    background: #e74c3c !important;
    color: #fff !important;
    transform: scale(1.1);
}

.wishlist-item button[onclick*="addToCart"]:hover {
    background: transparent !important;
    color: #4A90E2 !important;
}

button[onclick*="addAllToCart"]:hover {
    background: transparent !important;
    color: #4A90E2 !important;
    transform: translateY(-2px);
}

button[onclick*="clearWishlist"]:hover {
    background: #e74c3c !important;
    color: #fff !important;
    transform: translateY(-2px);
}

button[onclick*="shareWishlist"]:hover,
button[onclick*="copyWishlistLink"]:hover {
    transform: translateY(-5px) scale(1.1);
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}
</style>

<script>
// Remove from Wishlist
function removeFromWishlist(button) {
    if (confirm('Remove this item from your wishlist?')) {
        const item = button.closest('.wishlist-item').parentElement;
        item.style.opacity = '0';
        item.style.transform = 'scale(0.8)';

        setTimeout(() => {
            item.remove();
            updateWishlistCount();
            checkEmptyWishlist();
        }, 300);
    }
}

// Add to Cart
function addToCart(button) {
    const item = button.closest('.wishlist-item');
    const productName = item.querySelector('h4').textContent;

    // Animation
    button.innerHTML = '<i class="fas fa-check"></i>Added';
    button.style.background = '#27ae60';
    button.style.borderColor = '#27ae60';

    setTimeout(() => {
        button.innerHTML = '<i class="fas fa-shopping-cart"></i>Add to Cart';
        button.style.background = '#4A90E2';
        button.style.borderColor = '#4A90E2';
    }, 2000);

    // Update cart count
    const cartCount = document.querySelector('.cart-count');
    cartCount.textContent = parseInt(cartCount.textContent) + 1;

    // Show notification
    showNotification(productName + ' added to cart!');
}

// Add All to Cart
function addAllToCart() {
    const items = document.querySelectorAll('.wishlist-item');
    if (items.length === 0) {
        alert('Your wishlist is empty');
        return;
    }

    if (confirm('Add all ' + items.length + ' items to cart?')) {
        const cartCount = document.querySelector('.cart-count');
        cartCount.textContent = parseInt(cartCount.textContent) + items.length;

        showNotification('All items added to cart!');
    }
}

// Clear Wishlist
function clearWishlist() {
    const items = document.querySelectorAll('.wishlist-item');
    if (items.length === 0) {
        alert('Your wishlist is already empty');
        return;
    }

    if (confirm('Are you sure you want to clear your entire wishlist?')) {
        items.forEach(item => {
            item.parentElement.remove();
        });
        updateWishlistCount();
        checkEmptyWishlist();
        showNotification('Wishlist cleared');
    }
}

// Update Wishlist Count
function updateWishlistCount() {
    const count = document.querySelectorAll('.wishlist-item').length;
    document.getElementById('wishlistCount').textContent = count;
}

// Check if Wishlist is Empty
function checkEmptyWishlist() {
    const items = document.querySelectorAll('.wishlist-item');
    const emptyState = document.getElementById('emptyWishlist');
    const header = document.querySelector('.wishlist-header');

    if (items.length === 0) {
        emptyState.style.display = 'block';
        header.style.display = 'none';
    } else {
        emptyState.style.display = 'none';
        header.style.display = 'flex';
    }
}

// Share Wishlist
function shareWishlist(platform) {
    const url = window.location.href;
    const text = 'Check out my Dorsch Wishlist!';

    switch(platform) {
        case 'facebook':
            window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(url), '_blank');
            break;
        case 'whatsapp':
            window.open('https://wa.me/?text=' + encodeURIComponent(text + ' ' + url), '_blank');
            break;
        case 'email':
            window.location.href = 'mailto:?subject=' + encodeURIComponent(text) + '&body=' + encodeURIComponent(url);
            break;
    }
}

// Copy Wishlist Link
function copyWishlistLink() {
    const url = window.location.href;
    navigator.clipboard.writeText(url).then(() => {
        showNotification('Wishlist link copied to clipboard!');
    });
}

// Show Notification
function showNotification(message) {
    const notification = document.createElement('div');
    notification.innerHTML = '<i class="fas fa-check-circle" style="margin-right: 10px;"></i>' + message;
    notification.style.cssText = 'position: fixed; top: 100px; right: 30px; background: #27ae60; color: #fff; padding: 18px 30px; border-radius: 50px; font-weight: 600; z-index: 9999; box-shadow: 0 8px 30px rgba(0,0,0,0.2); animation: slideIn 0.3s ease;';

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// CSS Animation
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(400px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(400px); opacity: 0; }
    }
`;
document.head.appendChild(style);

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    checkEmptyWishlist();
});
</script>

<?php include 'footer.php'; ?>