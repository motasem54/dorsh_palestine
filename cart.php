<?php
$page_title = "Shopping Cart - Dorsch Palestine";
include 'header.php';
?>

<!-- Breadcrumb -->
<section class="breadcrumb-section" style="background: linear-gradient(135deg, #4A90E2 0%, #66A3E8 100%); padding: 60px 0; margin-top: 75px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-content text-center">
                    <h1 style="color: #fff; font-size: 48px; font-weight: 700; margin-bottom: 15px;">Shopping Cart</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center" style="background: transparent; margin: 0; padding: 0;">
                            <li class="breadcrumb-item"><a href="index.php" style="color: #fff; text-decoration: none;">Home</a></li>
                            <li class="breadcrumb-item active" style="color: rgba(255,255,255,0.8);">Cart</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Cart Section -->
<section class="cart-section" style="padding: 100px 0; background: #fff;">
    <div class="container">
        <div class="row">
            <!-- Cart Items -->
            <div class="col-lg-8 mb-4">
                <div class="cart-items-wrapper" style="background: #f8f8f8; padding: 30px; border-radius: 20px;">
                    <div class="cart-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 2px solid #e0e0e0;">
                        <h3 style="font-size: 28px; font-weight: 700; color: #1a1a1a; margin: 0;">Cart Items (<span id="cartCount">3</span>)</h3>
                        <button onclick="clearCart()" style="background: transparent; border: 2px solid #e74c3c; color: #e74c3c; padding: 10px 25px; border-radius: 25px; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">
                            <i class="fas fa-trash-alt" style="margin-right: 8px;"></i>Clear Cart
                        </button>
                    </div>

                    <!-- Cart Item 1 -->
                    <div class="cart-item" style="background: #fff; padding: 25px; border-radius: 15px; margin-bottom: 20px; display: flex; align-items: center; gap: 25px; position: relative;">
                        <button class="remove-item" onclick="removeItem(this)" style="position: absolute; top: 15px; right: 15px; background: #f8f8f8; border: none; width: 35px; height: 35px; border-radius: 50%; color: #666; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-times"></i>
                        </button>

                        <div class="item-image" style="width: 120px; height: 120px; background: #f8f8f8; border-radius: 10px; overflow: hidden; flex-shrink: 0;">
                            <img src="https://images.unsplash.com/photo-1556909212-d5b604d0c90d?w=200&h=200&fit=crop" alt="Product" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>

                        <div class="item-details" style="flex: 1;">
                            <h4 style="font-size: 20px; font-weight: 600; color: #1a1a1a; margin-bottom: 8px;">Premium Casserole 28cm</h4>
                            <p style="font-size: 14px; color: #4A90E2; margin-bottom: 10px; font-family: 'Courier New', monospace;">DH-05468</p>
                            <p style="font-size: 14px; color: #666; margin: 0;">Color: <strong>Black</strong> | Size: <strong>28cm</strong></p>
                        </div>

                        <div class="item-quantity" style="display: flex; align-items: center; gap: 10px;">
                            <button onclick="updateQuantity(this, -1)" style="width: 35px; height: 35px; border: 2px solid #e0e0e0; background: #fff; border-radius: 8px; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; color: #1a1a1a; font-size: 18px;">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" value="1" min="1" readonly style="width: 60px; text-align: center; border: 2px solid #e0e0e0; border-radius: 8px; padding: 8px; font-weight: 600; font-size: 16px;">
                            <button onclick="updateQuantity(this, 1)" style="width: 35px; height: 35px; border: 2px solid #e0e0e0; background: #fff; border-radius: 8px; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; color: #1a1a1a; font-size: 18px;">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>

                        <div class="item-price" style="text-align: right; min-width: 100px;">
                            <p style="font-size: 24px; font-weight: 700; color: #4A90E2; margin: 0;" class="item-total">$89.00</p>
                            <p style="font-size: 14px; color: #999; text-decoration: line-through; margin: 0;">$110.00</p>
                        </div>
                    </div>

                    <!-- Cart Item 2 -->
                    <div class="cart-item" style="background: #fff; padding: 25px; border-radius: 15px; margin-bottom: 20px; display: flex; align-items: center; gap: 25px; position: relative;">
                        <button class="remove-item" onclick="removeItem(this)" style="position: absolute; top: 15px; right: 15px; background: #f8f8f8; border: none; width: 35px; height: 35px; border-radius: 50%; color: #666; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-times"></i>
                        </button>

                        <div class="item-image" style="width: 120px; height: 120px; background: #f8f8f8; border-radius: 10px; overflow: hidden; flex-shrink: 0;">
                            <img src="https://images.unsplash.com/photo-1556909212-d5b604d0c90d?w=200&h=200&fit=crop" alt="Product" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>

                        <div class="item-details" style="flex: 1;">
                            <h4 style="font-size: 20px; font-weight: 600; color: #1a1a1a; margin-bottom: 8px;">Premium Fry Pan 28cm</h4>
                            <p style="font-size: 14px; color: #4A90E2; margin-bottom: 10px; font-family: 'Courier New', monospace;">DH-05488</p>
                            <p style="font-size: 14px; color: #666; margin: 0;">Color: <strong>Red</strong> | Size: <strong>28cm</strong></p>
                        </div>

                        <div class="item-quantity" style="display: flex; align-items: center; gap: 10px;">
                            <button onclick="updateQuantity(this, -1)" style="width: 35px; height: 35px; border: 2px solid #e0e0e0; background: #fff; border-radius: 8px; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; color: #1a1a1a; font-size: 18px;">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" value="2" min="1" readonly style="width: 60px; text-align: center; border: 2px solid #e0e0e0; border-radius: 8px; padding: 8px; font-weight: 600; font-size: 16px;">
                            <button onclick="updateQuantity(this, 1)" style="width: 35px; height: 35px; border: 2px solid #e0e0e0; background: #fff; border-radius: 8px; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; color: #1a1a1a; font-size: 18px;">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>

                        <div class="item-price" style="text-align: right; min-width: 100px;">
                            <p style="font-size: 24px; font-weight: 700; color: #4A90E2; margin: 0;" class="item-total">$150.00</p>
                        </div>
                    </div>

                    <!-- Cart Item 3 -->
                    <div class="cart-item" style="background: #fff; padding: 25px; border-radius: 15px; display: flex; align-items: center; gap: 25px; position: relative;">
                        <button class="remove-item" onclick="removeItem(this)" style="position: absolute; top: 15px; right: 15px; background: #f8f8f8; border: none; width: 35px; height: 35px; border-radius: 50%; color: #666; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-times"></i>
                        </button>

                        <div class="item-image" style="width: 120px; height: 120px; background: #f8f8f8; border-radius: 10px; overflow: hidden; flex-shrink: 0;">
                            <img src="https://images.unsplash.com/photo-1585515320310-259814833e62?w=200&h=200&fit=crop" alt="Product" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>

                        <div class="item-details" style="flex: 1;">
                            <h4 style="font-size: 20px; font-weight: 600; color: #1a1a1a; margin-bottom: 8px;">GoPress Pressure Cooker 6L</h4>
                            <p style="font-size: 14px; color: #4A90E2; margin-bottom: 10px; font-family: 'Courier New', monospace;">DH-06436</p>
                            <p style="font-size: 14px; color: #666; margin: 0;">Capacity: <strong>6 Liters</strong></p>
                        </div>

                        <div class="item-quantity" style="display: flex; align-items: center; gap: 10px;">
                            <button onclick="updateQuantity(this, -1)" style="width: 35px; height: 35px; border: 2px solid #e0e0e0; background: #fff; border-radius: 8px; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; color: #1a1a1a; font-size: 18px;">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" value="1" min="1" readonly style="width: 60px; text-align: center; border: 2px solid #e0e0e0; border-radius: 8px; padding: 8px; font-weight: 600; font-size: 16px;">
                            <button onclick="updateQuantity(this, 1)" style="width: 35px; height: 35px; border: 2px solid #e0e0e0; background: #fff; border-radius: 8px; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; color: #1a1a1a; font-size: 18px;">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>

                        <div class="item-price" style="text-align: right; min-width: 100px;">
                            <p style="font-size: 24px; font-weight: 700; color: #4A90E2; margin: 0;" class="item-total">$129.00</p>
                        </div>
                    </div>

                    <!-- Continue Shopping -->
                    <div style="margin-top: 30px;">
                        <a href="products.php" style="background: transparent; border: 2px solid #4A90E2; color: #4A90E2; padding: 14px 35px; border-radius: 25px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; transition: all 0.3s ease;">
                            <i class="fas fa-arrow-left" style="margin-right: 10px;"></i>Continue Shopping
                        </a>
                    </div>
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="col-lg-4">
                <!-- Summary Box -->
                <div class="cart-summary" style="background: #f8f8f8; padding: 35px; border-radius: 20px; margin-bottom: 25px; position: sticky; top: 100px;">
                    <h3 style="font-size: 24px; font-weight: 700; color: #1a1a1a; margin-bottom: 25px; padding-bottom: 20px; border-bottom: 2px solid #e0e0e0;">Order Summary</h3>

                    <div class="summary-row" style="display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 16px; color: #666;">
                        <span>Subtotal:</span>
                        <span id="subtotal" style="font-weight: 600; color: #1a1a1a;">$368.00</span>
                    </div>

                    <div class="summary-row" style="display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 16px; color: #666;">
                        <span>Shipping:</span>
                        <span style="color: #27ae60; font-weight: 600;">FREE</span>
                    </div>

                    <div class="summary-row" style="display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 16px; color: #666;">
                        <span>Tax (VAT 16%):</span>
                        <span id="tax" style="font-weight: 600; color: #1a1a1a;">$58.88</span>
                    </div>

                    <div class="summary-row" style="display: flex; justify-content: space-between; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 2px solid #e0e0e0; font-size: 16px; color: #666;">
                        <span>Discount:</span>
                        <span style="color: #e74c3c; font-weight: 600;">-$0.00</span>
                    </div>

                    <div class="summary-total" style="display: flex; justify-content: space-between; margin-bottom: 25px; font-size: 20px;">
                        <span style="font-weight: 700; color: #1a1a1a;">Total:</span>
                        <span id="total" style="font-weight: 700; color: #4A90E2; font-size: 28px;">$426.88</span>
                    </div>

                    <!-- Coupon Code -->
                    <div class="coupon-box" style="margin-bottom: 25px;">
                        <input type="text" placeholder="Coupon Code" style="width: 100%; padding: 14px 20px; border: 2px solid #e0e0e0; border-radius: 10px; margin-bottom: 10px; font-size: 15px; outline: none;">
                        <button onclick="applyCoupon()" style="width: 100%; background: transparent; border: 2px solid #4A90E2; color: #4A90E2; padding: 12px; border-radius: 10px; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">
                            Apply Coupon
                        </button>
                    </div>

                    <!-- Checkout Button -->
                    <button onclick="checkout()" style="width: 100%; background: #4A90E2; color: #fff; padding: 18px; border: 2px solid #4A90E2; border-radius: 50px; font-size: 16px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; transition: all 0.3s ease; margin-bottom: 15px;">
                        <i class="fas fa-lock" style="margin-right: 10px;"></i>Proceed to Checkout
                    </button>

                    <!-- Payment Methods -->
                    <div style="text-align: center; padding-top: 20px; border-top: 2px solid #e0e0e0;">
                        <p style="font-size: 13px; color: #999; margin-bottom: 15px; text-transform: uppercase; letter-spacing: 1px;">We Accept</p>
                        <div style="display: flex; justify-content: center; gap: 10px; flex-wrap: wrap;">
                            <i class="fab fa-cc-visa" style="font-size: 36px; color: #1a1f71;"></i>
                            <i class="fab fa-cc-mastercard" style="font-size: 36px; color: #eb001b;"></i>
                            <i class="fab fa-cc-paypal" style="font-size: 36px; color: #003087;"></i>
                            <i class="fab fa-cc-amex" style="font-size: 36px; color: #006fcf;"></i>
                        </div>
                    </div>
                </div>

                <!-- Trust Badges -->
                <div class="trust-badges" style="background: #fff; padding: 25px; border-radius: 15px; text-align: center;">
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <i class="fas fa-shield-alt" style="font-size: 28px; color: #4A90E2;"></i>
                            <div style="text-align: left;">
                                <h5 style="font-size: 15px; font-weight: 600; color: #1a1a1a; margin: 0;">Secure Payment</h5>
                                <p style="font-size: 13px; color: #999; margin: 0;">100% Protected</p>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <i class="fas fa-shipping-fast" style="font-size: 28px; color: #4A90E2;"></i>
                            <div style="text-align: left;">
                                <h5 style="font-size: 15px; font-weight: 600; color: #1a1a1a; margin: 0;">Free Shipping</h5>
                                <p style="font-size: 13px; color: #999; margin: 0;">Orders over $100</p>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <i class="fas fa-undo-alt" style="font-size: 28px; color: #4A90E2;"></i>
                            <div style="text-align: left;">
                                <h5 style="font-size: 15px; font-weight: 600; color: #1a1a1a; margin: 0;">Easy Returns</h5>
                                <p style="font-size: 13px; color: #999; margin: 0;">30 Days Money Back</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
<section class="related-products" style="padding: 100px 0; background: #f8f8f8;">
    <div class="container">
        <div class="section-title text-center" style="margin-bottom: 50px;">
            <h2 style="font-size: 42px; font-weight: 700; color: #1a1a1a; margin-bottom: 15px;">You May Also Like</h2>
            <p style="font-size: 16px; color: #666;">Complete your kitchen with these premium products</p>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="product-card" style="background: #fff; border-radius: 15px; padding: 20px; text-align: center; transition: all 0.3s ease;">
                    <div style="width: 100%; height: 200px; background: #f8f8f8; border-radius: 10px; margin-bottom: 20px; overflow: hidden;">
                        <img src="https://images.unsplash.com/photo-1602143407151-7111542de6e8?w=300&h=300&fit=crop" alt="Product" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <h4 style="font-size: 16px; font-weight: 600; color: #1a1a1a; margin-bottom: 10px;">Whistling Kettle 2.5L</h4>
                    <p style="font-size: 18px; font-weight: 700; color: #4A90E2; margin-bottom: 15px;">$45.00</p>
                    <button style="width: 100%; background: #4A90E2; color: #fff; padding: 12px; border: none; border-radius: 25px; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">Add to Cart</button>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="product-card" style="background: #fff; border-radius: 15px; padding: 20px; text-align: center; transition: all 0.3s ease;">
                    <div style="width: 100%; height: 200px; background: #f8f8f8; border-radius: 10px; margin-bottom: 20px; overflow: hidden;">
                        <img src="https://images.unsplash.com/photo-1578926314433-e2789279f4aa?w=300&h=300&fit=crop" alt="Product" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <h4 style="font-size: 16px; font-weight: 600; color: #1a1a1a; margin-bottom: 10px;">Safari Cutlery Set 72 Pcs</h4>
                    <p style="font-size: 18px; font-weight: 700; color: #4A90E2; margin-bottom: 15px;">$199.00</p>
                    <button style="width: 100%; background: #4A90E2; color: #fff; padding: 12px; border: none; border-radius: 25px; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">Add to Cart</button>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="product-card" style="background: #fff; border-radius: 15px; padding: 20px; text-align: center; transition: all 0.3s ease;">
                    <div style="width: 100%; height: 200px; background: #f8f8f8; border-radius: 10px; margin-bottom: 20px; overflow: hidden;">
                        <img src="https://images.unsplash.com/photo-1593618998160-e34014e67546?w=300&h=300&fit=crop" alt="Product" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <h4 style="font-size: 16px; font-weight: 600; color: #1a1a1a; margin-bottom: 10px;">Classic Knife Set 14 Pcs</h4>
                    <p style="font-size: 18px; font-weight: 700; color: #4A90E2; margin-bottom: 15px;">$149.00</p>
                    <button style="width: 100%; background: #4A90E2; color: #fff; padding: 12px; border: none; border-radius: 25px; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">Add to Cart</button>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="product-card" style="background: #fff; border-radius: 15px; padding: 20px; text-align: center; transition: all 0.3s ease;">
                    <div style="width: 100%; height: 200px; background: #f8f8f8; border-radius: 10px; margin-bottom: 20px; overflow: hidden;">
                        <img src="https://images.unsplash.com/photo-1495147466023-ac5c588e2e94?w=300&h=300&fit=crop" alt="Product" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <h4 style="font-size: 16px; font-weight: 600; color: #1a1a1a; margin-bottom: 10px;">Muffin Pan 12 Cups</h4>
                    <p style="font-size: 18px; font-weight: 700; color: #4A90E2; margin-bottom: 15px;">$35.00</p>
                    <button style="width: 100%; background: #4A90E2; color: #fff; padding: 12px; border: none; border-radius: 25px; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">Add to Cart</button>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Hover Effects */
.remove-item:hover {
    background: #e74c3c !important;
    color: #fff !important;
}

button[onclick*="updateQuantity"]:hover {
    border-color: #4A90E2 !important;
    color: #4A90E2 !important;
}

button[onclick="checkout()"]:hover {
    background: transparent !important;
    color: #4A90E2 !important;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(201, 164, 92, 0.3);
}

button[onclick="applyCoupon()"]:hover {
    background: #4A90E2 !important;
    color: #fff !important;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.1);
}

.product-card button:hover {
    background: #1a1a1a !important;
    transform: scale(1.05);
}
</style>

<script>
// Update Quantity
function updateQuantity(button, change) {
    const input = button.parentElement.querySelector('input');
    let currentValue = parseInt(input.value);
    currentValue += change;

    if (currentValue < 1) currentValue = 1;

    input.value = currentValue;
    updateCartTotals();
}

// Remove Item
function removeItem(button) {
    if (confirm('Are you sure you want to remove this item?')) {
        button.closest('.cart-item').remove();
        updateCartCount();
        updateCartTotals();
    }
}

// Clear Cart
function clearCart() {
    if (confirm('Are you sure you want to clear your cart?')) {
        document.querySelectorAll('.cart-item').forEach(item => item.remove());
        updateCartCount();
        updateCartTotals();
        alert('Your cart has been cleared');
    }
}

// Update Cart Count
function updateCartCount() {
    const count = document.querySelectorAll('.cart-item').length;
    document.getElementById('cartCount').textContent = count;
    document.querySelector('.cart-count').textContent = count;
}

// Update Cart Totals
function updateCartTotals() {
    let subtotal = 0;

    document.querySelectorAll('.cart-item').forEach(item => {
        const priceText = item.querySelector('.item-total').textContent;
        const price = parseFloat(priceText.replace('$', ''));
        subtotal += price;
    });

    const tax = subtotal * 0.16;
    const total = subtotal + tax;

    document.getElementById('subtotal').textContent = '$' + subtotal.toFixed(2);
    document.getElementById('tax').textContent = '$' + tax.toFixed(2);
    document.getElementById('total').textContent = '$' + total.toFixed(2);
}

// Apply Coupon
function applyCoupon() {
    const input = document.querySelector('.coupon-box input');
    const code = input.value.trim().toUpperCase();

    if (code === 'DORSCH10') {
        alert('Coupon applied! 10% discount');
        input.value = '';
    } else if (code === '') {
        alert('Please enter a coupon code');
    } else {
        alert('Invalid coupon code');
    }
}

// Checkout
function checkout() {
    const count = document.querySelectorAll('.cart-item').length;
    if (count === 0) {
        alert('Your cart is empty');
        return;
    }

    window.location.href = 'checkout.php';
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateCartTotals();
});
</script>

<?php include 'footer.php'; ?>