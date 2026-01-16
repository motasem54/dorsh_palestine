<?php
$page_title = "Compare Products - Dorsch Palestine";
include 'header.php';
?>

<!-- Breadcrumb -->
<section class="breadcrumb-section" style="background: linear-gradient(135deg, #4A90E2 0%, #66A3E8 100%); padding: 60px 0; margin-top: 75px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-content text-center">
                    <h1 style="color: #fff; font-size: 48px; font-weight: 700; margin-bottom: 15px;">Compare Products</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center" style="background: transparent; margin: 0; padding: 0;">
                            <li class="breadcrumb-item"><a href="index.php" style="color: #fff; text-decoration: none;">Home</a></li>
                            <li class="breadcrumb-item active" style="color: rgba(255,255,255,0.8);">Compare</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Compare Section -->
<section class="compare-section" style="padding: 100px 0; background: #fff;">
    <div class="container-fluid">
        <!-- Compare Header -->
        <div class="compare-header" style="margin-bottom: 50px; text-align: center;">
            <h2 style="font-size: 36px; font-weight: 700; color: #1a1a1a; margin-bottom: 15px;">Product Comparison</h2>
            <p style="font-size: 16px; color: #666; margin-bottom: 25px;">Compare up to 4 products side by side</p>
            <button onclick="clearCompare()" style="background: transparent; border: 2px solid #e74c3c; color: #e74c3c; padding: 12px 30px; border-radius: 25px; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">
                <i class="fas fa-times" style="margin-right: 8px;"></i>Clear All
            </button>
        </div>

        <!-- Compare Table -->
        <div class="table-responsive">
            <table class="compare-table" style="width: 100%; border-collapse: separate; border-spacing: 15px;">
                <thead>
                    <tr>
                        <th style="width: 200px; padding: 20px; background: #f8f8f8; border-radius: 15px; font-size: 16px; font-weight: 700; color: #1a1a1a; text-align: left; vertical-align: top;">Features</th>

                        <!-- Product 1 -->
                        <td style="padding: 20px; background: #f8f8f8; border-radius: 15px; vertical-align: top; position: relative;">
                            <button onclick="removeProduct(this)" style="position: absolute; top: 10px; right: 10px; width: 35px; height: 35px; background: #fff; border: none; border-radius: 50%; color: #e74c3c; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                <i class="fas fa-times"></i>
                            </button>
                            <div style="text-align: center;">
                                <div style="width: 150px; height: 150px; background: #fff; border-radius: 15px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                    <img src="https://images.unsplash.com/photo-1556909212-d5b604d0c90d?w=200&h=200&fit=crop" alt="Product" style="max-width: 85%; max-height: 85%; object-fit: contain;">
                                </div>
                                <h4 style="font-size: 18px; font-weight: 700; color: #1a1a1a; margin-bottom: 10px;">Premium Casserole 28cm</h4>
                                <p style="font-size: 13px; color: #4A90E2; margin-bottom: 15px; font-family: 'Courier New', monospace;">DH-05468</p>
                                <p style="font-size: 24px; font-weight: 700; color: #4A90E2; margin-bottom: 15px;">$89.00</p>
                                <button onclick="addToCart(this)" style="width: 100%; background: #4A90E2; color: #fff; padding: 12px; border: none; border-radius: 25px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; margin-bottom: 10px;">
                                    <i class="fas fa-shopping-cart" style="margin-right: 8px;"></i>Add to Cart
                                </button>
                                <a href="product-detail.php" style="display: block; text-align: center; color: #4A90E2; text-decoration: none; font-weight: 600; font-size: 14px;">View Details</a>
                            </div>
                        </td>

                        <!-- Product 2 -->
                        <td style="padding: 20px; background: #f8f8f8; border-radius: 15px; vertical-align: top; position: relative;">
                            <button onclick="removeProduct(this)" style="position: absolute; top: 10px; right: 10px; width: 35px; height: 35px; background: #fff; border: none; border-radius: 50%; color: #e74c3c; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                <i class="fas fa-times"></i>
                            </button>
                            <div style="text-align: center;">
                                <div style="width: 150px; height: 150px; background: #fff; border-radius: 15px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                    <img src="https://images.unsplash.com/photo-1556909212-d5b604d0c90d?w=200&h=200&fit=crop" alt="Product" style="max-width: 85%; max-height: 85%; object-fit: contain;">
                                </div>
                                <h4 style="font-size: 18px; font-weight: 700; color: #1a1a1a; margin-bottom: 10px;">Premium Fry Pan 28cm</h4>
                                <p style="font-size: 13px; color: #4A90E2; margin-bottom: 15px; font-family: 'Courier New', monospace;">DH-05488</p>
                                <p style="font-size: 24px; font-weight: 700; color: #4A90E2; margin-bottom: 15px;">$75.00</p>
                                <button onclick="addToCart(this)" style="width: 100%; background: #4A90E2; color: #fff; padding: 12px; border: none; border-radius: 25px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; margin-bottom: 10px;">
                                    <i class="fas fa-shopping-cart" style="margin-right: 8px;"></i>Add to Cart
                                </button>
                                <a href="product-detail.php" style="display: block; text-align: center; color: #4A90E2; text-decoration: none; font-weight: 600; font-size: 14px;">View Details</a>
                            </div>
                        </td>

                        <!-- Product 3 -->
                        <td style="padding: 20px; background: #f8f8f8; border-radius: 15px; vertical-align: top; position: relative;">
                            <button onclick="removeProduct(this)" style="position: absolute; top: 10px; right: 10px; width: 35px; height: 35px; background: #fff; border: none; border-radius: 50%; color: #e74c3c; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                <i class="fas fa-times"></i>
                            </button>
                            <div style="text-align: center;">
                                <div style="width: 150px; height: 150px; background: #fff; border-radius: 15px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                    <img src="https://images.unsplash.com/photo-1585515320310-259814833e62?w=200&h=200&fit=crop" alt="Product" style="max-width: 85%; max-height: 85%; object-fit: contain;">
                                </div>
                                <h4 style="font-size: 18px; font-weight: 700; color: #1a1a1a; margin-bottom: 10px;">GoPress Pressure Cooker 6L</h4>
                                <p style="font-size: 13px; color: #4A90E2; margin-bottom: 15px; font-family: 'Courier New', monospace;">DH-06436</p>
                                <p style="font-size: 24px; font-weight: 700; color: #4A90E2; margin-bottom: 15px;">$129.00</p>
                                <button onclick="addToCart(this)" style="width: 100%; background: #4A90E2; color: #fff; padding: 12px; border: none; border-radius: 25px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; margin-bottom: 10px;">
                                    <i class="fas fa-shopping-cart" style="margin-right: 8px;"></i>Add to Cart
                                </button>
                                <a href="product-detail.php" style="display: block; text-align: center; color: #4A90E2; text-decoration: none; font-weight: 600; font-size: 14px;">View Details</a>
                            </div>
                        </td>
                    </tr>
                </thead>

                <tbody>
                    <!-- Collection -->
                    <tr>
                        <th style="padding: 20px; background: #f8f8f8; border-radius: 15px; font-size: 15px; font-weight: 600; color: #1a1a1a; text-align: left;">Collection</th>
                        <td style="padding: 20px; background: #f8f8f8; border-radius: 15px; text-align: center; color: #666; font-size: 15px;">Premium Cookware</td>
                        <td style="padding: 20px; background: #f8f8f8; border-radius: 15px; text-align: center; color: #666; font-size: 15px;">Premium Cookware</td>
                        <td style="padding: 20px; background: #f8f8f8; border-radius: 15px; text-align: center; color: #666; font-size: 15px;">GoPress</td>
                    </tr>

                    <!-- Material -->
                    <tr>
                        <th style="padding: 20px; background: #f8f8f8; border-radius: 15px; font-size: 15px; font-weight: 600; color: #1a1a1a; text-align: left;">Material</th>
                        <td style="padding: 20px; background: #f8f8f8; border-radius: 15px; text-align: center; color: #666; font-size: 15px;">Ceramic Coated Aluminum</td>
                        <td style="padding: 20px; background: #f8f8f8; border-radius: 15px; text-align: center; color: #666; font-size: 15px;">Ceramic Coated Aluminum</td>
                        <td style="padding: 20px; background: #f8f8f8; border-radius: 15px; text-align: center; color: #666; font-size: 15px;">Stainless Steel</td>
                    </tr>

                    <!-- Size -->
                    <tr>
                        <th style="padding: 20px; background: #f8f8f8; border-radius: 15px; font-size: 15px; font-weight: 600; color: #1a1a1a; text-align: left;">Size / Capacity</th>
                        <td style="padding: 20px; background: #f8f8f8; border-radius: 15px; text-align: center; color: #666; font-size: 15px;">28cm / 6L</td>
                        <td style="padding: 20px; background: #f8f8f8; border-radius: 15px; text-align: center; color: #666; font-size: 15px;">28cm</td>
                        <td style="padding: 20px; background: #f8f8f8; border-radius: 15px; text-align: center; color: #666; font-size: 15px;">6 Liters</td>
                    </tr>

                    <!-- Non-Stick Coating -->
                    <tr>
                        <th style="padding: 20px; background: #f8f8f8; border-radius: 15px; font-size: 15px; font-weight: 600; color: #1a1a1a; text-align: left;">Non-Stick Coating</th>
                        <td style="padding: 20px; background: #f8f8f8; border-radius: 15px; text-align: center;">
                            <i class="fas fa-check-circle" style="color: #27ae60; font-size: 24px;"></i>
                            <p style="margin: 5px 0 0; font-size: 13px; color: #27ae60; font-weight: 600;">PTFE & PFOA Free</p>
                        </td>
                        <td style="padding: 20px; background: #f8f8f8; border-radius: 15px; text-align: center;">
                            <i class="fas fa-check-circle" style="color: #27ae60; font-size: 24px;"></i>
                            <p style="margin: 5px 0 0; font-size: 13px; color: #27ae60; font-weight: 600;">PTFE & PFOA Free</p>
                        </td>
                        <td style="padding: 20px; background: #f8f8f8; border-radius: 15px; text-align: center;">
                            <i class="fas fa-times-circle" style="color: #e74c3c; font-size: 24px;"></i>
                            <p style="margin: 5px 0 0; font-size: 13px; color: #999;">Not Applicable</p>
                        </td>
                    </tr>

                    <!-- Dishwasher Safe -->
                    <tr>
                        <th style="padding: 20px; background: #f8f8f8; border-radius: 15px; font-size: 15px; font-weight: 600; color: #1a1a1a; text-align: left;">Dishwasher Safe</th>
                        <td style="padding: 20px; background: #f8f8f8; border-radius: 15px; text-align: center;">
                            <i class="fas fa-check-circle" style="color: #27ae60; font-size: 24px;"></i>
                        </td>
                        <td style="padding: 20px; background: #f8f8f8; border-radius: 15px; text-align: center;">
                            <i class="fas fa-check-circle" style="color: #27ae60; font-size: 24px;"></i>
                        </td>
                        <td style="padding: 20px; background: #f8f8f8; border-radius: 15px; text-align: center;">
                            <i class="fas fa-check-circle" style="color: #27ae60; font-size: 24px;"></i>
                        </td>
                    </tr>

                    <!-- Oven Safe -->
                    <tr>
                        <th style="padding: 20px; background: #f8f8f8; border-radius: 15px; font-size: 15px; font-weight: 600; color: #1a1a1a; text-align: left;">Oven Safe</th>
                        <td style="padding: 20px; background: #f8f8f8; border-radius: 15px; text-align: center;">
                            <i class="fas fa-check-circle" style="color: #27ae60; font-size: 24px;"></i>
                            <p style="margin: 5px 0 0; font-size: 13px; color: #666;">Up to 220¡ÆC</p>
                        </td>
                        <td style="padding: 20px; background: #f8f8f8; border-radius: 15px; text-align: center;">
                            <i class="fas fa-times-circle" style="color: #e74c3c; font-size: 24px;"></i>
                        </td>
                        <td style="padding: 20px; background: #f8f8f8; border-radius: 15px; text-align: center;">
                            <i class="fas fa-times-circle" style="color: #e74c3c; font-size: 24px;"></i>
                        </td>
                    </tr>

                    <!-- Induction Compatible -->
                    <tr>
                        <th style="padding: 20px; background: #f8f8f8; border-radius: 15px; font-size: 15px; font-weight: 600; color: #1a1a1a; text-align: left;">Induction Compatible</th>
                        <td style="padding: 20px; background: #f8f8f8; border-radius: 15px; text-align: center;">
                            <i class="fas fa-check-circle" style="color: #27ae60; font-size: 24px;"></i>
                        </td>
                        <td style="padding: 20px; background: #f8f8f8; border-radius: 15px; text-align: center;">
                            <i class="fas fa-check-circle" style="color: #27ae60; font-size: 24px;"></i>
                        </td>
                        <td style="padding: 20px; background: #f8f8f8; border-radius: 15px; text-align: center;">
                            <i class="fas fa-check-circle" style="color: #27ae60; font-size: 24px;"></i>
                        </td>
                    </tr>

                    <!-- LFGB Certified -->
                    <tr>
                        <th style="padding: 20px; background: #f8f8f8; border-radius: 15px; font-size: 15px; font-weight: 600; color: #1a1a1a; text-align: left;">LFGB Certified</th>
                        <td style="padding: 20px; background: #f8f8f8; border-radius: 15px; text-align: center;">
                            <i class="fas fa-certificate" style="color: #4A90E2; font-size: 24px;"></i>
                        </td>
                        <td style="padding: 20px; background: #f8f8f8; border-radius: 15px; text-align: center;">
                            <i class="fas fa-certificate" style="color: #4A90E2; font-size: 24px;"></i>
                        </td>
                        <td style="padding: 20px; background: #f8f8f8; border-radius: 15px; text-align: center;">
                            <i class="fas fa-certificate" style="color: #4A90E2; font-size: 24px;"></i>
                        </td>
                    </tr>

                    <!-- Warranty -->
                    <tr>
                        <th style="padding: 20px; background: #f8f8f8; border-radius: 15px; font-size: 15px; font-weight: 600; color: #1a1a1a; text-align: left;">Warranty</th>
                        <td style="padding: 20px; background: #f8f8f8; border-radius: 15px; text-align: center; color: #666; font-size: 15px;">2 Years</td>
                        <td style="padding: 20px; background: #f8f8f8; border-radius: 15px; text-align: center; color: #666; font-size: 15px;">2 Years</td>
                        <td style="padding: 20px; background: #f8f8f8; border-radius: 15px; text-align: center; color: #4A90E2; font-size: 15px; font-weight: 700;">Lifetime</td>
                    </tr>

                    <!-- Stock Status -->
                    <tr>
                        <th style="padding: 20px; background: #f8f8f8; border-radius: 15px; font-size: 15px; font-weight: 600; color: #1a1a1a; text-align: left;">Availability</th>
                        <td style="padding: 20px; background: #f8f8f8; border-radius: 15px; text-align: center;">
                            <span style="background: #27ae60; color: #fff; padding: 6px 20px; border-radius: 20px; font-size: 13px; font-weight: 600; display: inline-block;">In Stock</span>
                        </td>
                        <td style="padding: 20px; background: #f8f8f8; border-radius: 15px; text-align: center;">
                            <span style="background: #27ae60; color: #fff; padding: 6px 20px; border-radius: 20px; font-size: 13px; font-weight: 600; display: inline-block;">In Stock</span>
                        </td>
                        <td style="padding: 20px; background: #f8f8f8; border-radius: 15px; text-align: center;">
                            <span style="background: #ff9800; color: #fff; padding: 6px 20px; border-radius: 20px; font-size: 13px; font-weight: 600; display: inline-block;">Low Stock</span>
                        </td>
                    </tr>

                    <!-- Rating -->
                    <tr>
                        <th style="padding: 20px; background: #f8f8f8; border-radius: 15px; font-size: 15px; font-weight: 600; color: #1a1a1a; text-align: left;">Customer Rating</th>
                        <td style="padding: 20px; background: #f8f8f8; border-radius: 15px; text-align: center;">
                            <div style="color: #ffa500; font-size: 18px; margin-bottom: 5px;">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                            </div>
                            <p style="margin: 0; font-size: 14px; color: #666;">4.5/5 (128 reviews)</p>
                        </td>
                        <td style="padding: 20px; background: #f8f8f8; border-radius: 15px; text-align: center;">
                            <div style="color: #ffa500; font-size: 18px; margin-bottom: 5px;">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>
                            </div>
                            <p style="margin: 0; font-size: 14px; color: #666;">4.0/5 (95 reviews)</p>
                        </td>
                        <td style="padding: 20px; background: #f8f8f8; border-radius: 15px; text-align: center;">
                            <div style="color: #ffa500; font-size: 18px; margin-bottom: 5px;">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <p style="margin: 0; font-size: 14px; color: #666;">5.0/5 (214 reviews)</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<style>
/* Hover Effects */
button[onclick*="removeProduct"]:hover {
    background: #e74c3c !important;
    color: #fff !important;
    transform: scale(1.1);
}

button[onclick*="addToCart"]:hover {
    background: #1a1a1a !important;
    transform: scale(1.05);
}

button[onclick*="clearCompare"]:hover {
    background: #e74c3c !important;
    color: #fff !important;
}

/* Responsive Table */
@media (max-width: 991px) {
    .table-responsive {
        overflow-x: auto;
    }

    .compare-table td,
    .compare-table th {
        min-width: 250px;
    }
}
</style>

<script>
// Remove Product from Compare
function removeProduct(button) {
    if (confirm('Remove this product from comparison?')) {
        const column = button.closest('td');
        const columnIndex = Array.from(column.parentElement.children).indexOf(column);

        // Remove from all rows
        document.querySelectorAll('.compare-table tr').forEach(row => {
            const cell = row.children[columnIndex];
            if (cell) {
                cell.style.opacity = '0';
                cell.style.transform = 'scale(0.8)';
                setTimeout(() => cell.remove(), 300);
            }
        });

        checkEmptyCompare();
    }
}

// Clear All Compare
function clearCompare() {
    if (confirm('Remove all products from comparison?')) {
        window.location.href = 'products.php';
    }
}

// Add to Cart
function addToCart(button) {
    const productName = button.closest('td').querySelector('h4').textContent;

    button.innerHTML = '<i class="fas fa-check"></i>Added';
    button.style.background = '#27ae60';

    setTimeout(() => {
        button.innerHTML = '<i class="fas fa-shopping-cart"></i>Add to Cart';
        button.style.background = '#4A90E2';
    }, 2000);

    const cartCount = document.querySelector('.cart-count');
    cartCount.textContent = parseInt(cartCount.textContent) + 1;

    showNotification(productName + ' added to cart!');
}

// Check if Compare is Empty
function checkEmptyCompare() {
    const products = document.querySelectorAll('.compare-table thead td');
    if (products.length === 0) {
        window.location.href = 'products.php';
    }
}

// Show Notification
function showNotification(message) {
    const notification = document.createElement('div');
    notification.innerHTML = '<i class="fas fa-check-circle" style="margin-right: 10px;"></i>' + message;
    notification.style.cssText = 'position: fixed; top: 100px; right: 30px; background: #27ae60; color: #fff; padding: 18px 30px; border-radius: 50px; font-weight: 600; z-index: 9999; box-shadow: 0 8px 30px rgba(0,0,0,0.2);';

    document.body.appendChild(notification);

    setTimeout(() => notification.remove(), 3000);
}
</script>

<?php include 'footer.php'; ?>