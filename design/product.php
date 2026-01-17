<?php
$page_title = "Product Details - Dorsch Palestine";
include 'header.php';
?>

<!-- Breadcrumb -->
<section class="breadcrumb-section" style="background: linear-gradient(135deg, #4A90E2 0%, #66A3E8 100%); padding: 60px 0; margin-top: 75px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-content text-center">
                    <h1 style="color: #fff; font-size: 48px; font-weight: 700; margin-bottom: 15px;">Product Details</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center" style="background: transparent; margin: 0; padding: 0;">
                            <li class="breadcrumb-item"><a href="index.php" style="color: #fff; text-decoration: none;">Home</a></li>
                            <li class="breadcrumb-item"><a href="products.php" style="color: #fff; text-decoration: none;">Products</a></li>
                            <li class="breadcrumb-item active" style="color: rgba(255,255,255,0.8);">Premium Casserole</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Product Detail Section -->
<section class="product-detail-section" style="padding: 100px 0; background: #fff;">
    <div class="container">
        <div class="row">
            <!-- Product Images Gallery -->
            <div class="col-lg-6" data-aos="fade-right">
                <div class="product-gallery">
                    <!-- Main Image -->
                    <div class="main-image-container" style="position: relative; margin-bottom: 20px; border-radius: 20px; overflow: hidden; background: #f8f8f8; padding: 40px;">
                        <span class="product-badge" style="position: absolute; top: 20px; left: 20px; background: #e74c3c; color: #fff; padding: 8px 20px; border-radius: 25px; font-weight: 600; font-size: 13px; z-index: 10;">
                            Sale -20%
                        </span>
                        <span class="wishlist-btn" style="position: absolute; top: 20px; right: 20px; width: 45px; height: 45px; background: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 4px 15px rgba(0,0,0,0.1); z-index: 10; transition: all 0.3s ease;">
                            <i class="far fa-heart" style="font-size: 20px; color: #e74c3c;"></i>
                        </span>
                        <img id="mainImage" src="https://images.unsplash.com/photo-1584990347449-39e6082f2b6c?w=700&h=700&fit=crop&q=90" alt="Premium Casserole" style="width: 100%; display: block; border-radius: 15px;">
                    </div>

                    <!-- Thumbnail Images -->
                    <div class="thumbnail-images" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px;">
                        <div class="thumb-item active" onclick="changeImage(this)" style="border-radius: 15px; overflow: hidden; cursor: pointer; border: 3px solid #4A90E2; transition: all 0.3s ease;">
                            <img src="https://images.unsplash.com/photo-1584990347449-39e6082f2b6c?w=200&h=200&fit=crop&q=80" alt="View 1" style="width: 100%; display: block;">
                        </div>
                        <div class="thumb-item" onclick="changeImage(this)" style="border-radius: 15px; overflow: hidden; cursor: pointer; border: 3px solid transparent; transition: all 0.3s ease;">
                            <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=200&h=200&fit=crop&q=80" alt="View 2" style="width: 100%; display: block;">
                        </div>
                        <div class="thumb-item" onclick="changeImage(this)" style="border-radius: 15px; overflow: hidden; cursor: pointer; border: 3px solid transparent; transition: all 0.3s ease;">
                            <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=200&h=200&fit=crop&q=80&brightness=110" alt="View 3" style="width: 100%; display: block;">
                        </div>
                        <div class="thumb-item" onclick="changeImage(this)" style="border-radius: 15px; overflow: hidden; cursor: pointer; border: 3px solid transparent; transition: all 0.3s ease;">
                            <img src="https://images.unsplash.com/photo-1556909212-d5b604d0c90d?w=200&h=200&fit=crop&q=80" alt="View 4" style="width: 100%; display: block;">
                        </div>
                    </div>

                    <!-- Certifications Badges -->
                    <div class="certifications" style="display: flex; gap: 15px; margin-top: 30px; padding: 25px; background: #f8f8f8; border-radius: 15px;">
                        <div style="flex: 1; text-align: center; padding: 15px; background: #fff; border-radius: 10px;">
                            <i class="fas fa-certificate" style="font-size: 32px; color: #4A90E2; margin-bottom: 8px;"></i>
                            <p style="font-size: 12px; font-weight: 600; color: #1a1a1a; margin: 0;">LFGB Certified</p>
                        </div>
                        <div style="flex: 1; text-align: center; padding: 15px; background: #fff; border-radius: 10px;">
                            <i class="fas fa-shield-alt" style="font-size: 32px; color: #27ae60; margin-bottom: 8px;"></i>
                            <p style="font-size: 12px; font-weight: 600; color: #1a1a1a; margin: 0;">PTFE Free</p>
                        </div>
                        <div style="flex: 1; text-align: center; padding: 15px; background: #fff; border-radius: 10px;">
                            <i class="fas fa-leaf" style="font-size: 32px; color: #27ae60; margin-bottom: 8px;"></i>
                            <p style="font-size: 12px; font-weight: 600; color: #1a1a1a; margin: 0;">Eco-Friendly</p>
                        </div>
                        <div style="flex: 1; text-align: center; padding: 15px; background: #fff; border-radius: 10px;">
                            <i class="fas fa-award" style="font-size: 32px; color: #4A90E2; margin-bottom: 8px;"></i>
                            <p style="font-size: 12px; font-weight: 600; color: #1a1a1a; margin: 0;">2 Year Warranty</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-lg-6" data-aos="fade-left">
                <div class="product-detail-info">
                    <!-- Category & Code -->
                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 15px;">
                        <span style="background: #4A90E2; color: #fff; padding: 6px 18px; border-radius: 20px; font-size: 13px; font-weight: 600;">Premium Cookware</span>
                        <span style="color: #999; font-size: 14px; font-family: 'Courier New', monospace;">SKU: DH-05468</span>
                    </div>

                    <!-- Product Title -->
                    <h1 style="font-size: 42px; font-weight: 700; color: #1a1a1a; margin-bottom: 20px; line-height: 1.2;">Premium Casserole 28cm with Lid</h1>

                    <!-- Rating -->
                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 25px;">
                        <div style="color: #ffa500; font-size: 18px;">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <span style="color: #666; font-size: 15px;">4.5/5 (128 reviews)</span>
                        <a href="#reviews" style="color: #4A90E2; text-decoration: none; font-weight: 600; font-size: 14px;">Write a Review</a>
                    </div>

                    <!-- Price -->
                    <div style="margin-bottom: 30px;">
                        <div style="display: flex; align-items: baseline; gap: 15px; margin-bottom: 10px;">
                            <span style="font-size: 48px; font-weight: 700; color: #4A90E2;">$89.00</span>
                            <span style="font-size: 28px; color: #999; text-decoration: line-through;">$110.00</span>
                            <span style="background: #27ae60; color: #fff; padding: 6px 15px; border-radius: 20px; font-size: 14px; font-weight: 600;">Save $21</span>
                        </div>
                        <p style="color: #27ae60; font-size: 14px; font-weight: 600; margin: 0;">
                            <i class="fas fa-check-circle" style="margin-right: 5px;"></i>
                            In Stock - Ships within 24 hours
                        </p>
                    </div>

                    <!-- Short Description -->
                    <p style="font-size: 17px; color: #666; line-height: 1.8; margin-bottom: 30px;">
                        Premium ceramic coated casserole with multi-layer non-stick technology. Perfect for healthy cooking with even heat distribution. LFGB certified and PTFE & PFOA free for safe, eco-friendly cooking.
                    </p>

                    <!-- Key Features -->
                    <div style="background: #f8f8f8; padding: 25px; border-radius: 15px; margin-bottom: 30px;">
                        <h4 style="font-size: 18px; font-weight: 600; color: #1a1a1a; margin-bottom: 20px;">Key Features</h4>
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            <li style="padding: 10px 0; font-size: 15px; color: #666; display: flex; align-items: center;">
                                <i class="fas fa-check" style="color: #4A90E2; margin-right: 12px; font-size: 16px;"></i>
                                Ceramic non-stick coating - PTFE & PFOA Free
                            </li>
                            <li style="padding: 10px 0; font-size: 15px; color: #666; display: flex; align-items: center;">
                                <i class="fas fa-check" style="color: #4A90E2; margin-right: 12px; font-size: 16px;"></i>
                                Suitable for all cooktops including induction
                            </li>
                            <li style="padding: 10px 0; font-size: 15px; color: #666; display: flex; align-items: center;">
                                <i class="fas fa-check" style="color: #4A90E2; margin-right: 12px; font-size: 16px;"></i>
                                Oven safe up to 220°C with glass lid
                            </li>
                            <li style="padding: 10px 0; font-size: 15px; color: #666; display: flex; align-items: center;">
                                <i class="fas fa-check" style="color: #4A90E2; margin-right: 12px; font-size: 16px;"></i>
                                Dishwasher safe for easy cleaning
                            </li>
                            <li style="padding: 10px 0; font-size: 15px; color: #666; display: flex; align-items: center;">
                                <i class="fas fa-check" style="color: #4A90E2; margin-right: 12px; font-size: 16px;"></i>
                                2 Year manufacturer warranty
                            </li>
                        </ul>
                    </div>

                    <!-- Size Selection -->
                    <div style="margin-bottom: 25px;">
                        <label style="display: block; font-weight: 600; color: #1a1a1a; margin-bottom: 12px; font-size: 15px;">Size:</label>
                        <div style="display: flex; gap: 10px;">
                            <button class="size-btn" style="padding: 12px 24px; border: 2px solid #e0e0e0; border-radius: 10px; background: #fff; cursor: pointer; font-weight: 600; transition: all 0.3s ease;">24cm</button>
                            <button class="size-btn active" style="padding: 12px 24px; border: 2px solid #4A90E2; border-radius: 10px; background: #4A90E2; color: #fff; cursor: pointer; font-weight: 600; transition: all 0.3s ease;">28cm</button>
                            <button class="size-btn" style="padding: 12px 24px; border: 2px solid #e0e0e0; border-radius: 10px; background: #fff; cursor: pointer; font-weight: 600; transition: all 0.3s ease;">32cm</button>
                        </div>
                    </div>

                    <!-- Color Selection -->
                    <div style="margin-bottom: 30px;">
                        <label style="display: block; font-weight: 600; color: #1a1a1a; margin-bottom: 12px; font-size: 15px;">Color:</label>
                        <div style="display: flex; gap: 12px;">
                            <div class="color-option active" style="width: 45px; height: 45px; background: #2c3e50; border-radius: 50%; cursor: pointer; border: 3px solid #4A90E2; position: relative; transition: all 0.3s ease;">
                                <i class="fas fa-check" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #fff; font-size: 18px;"></i>
                            </div>
                            <div class="color-option" style="width: 45px; height: 45px; background: #c0392b; border-radius: 50%; cursor: pointer; border: 3px solid transparent; transition: all 0.3s ease;"></div>
                            <div class="color-option" style="width: 45px; height: 45px; background: #16a085; border-radius: 50%; cursor: pointer; border: 3px solid transparent; transition: all 0.3s ease;"></div>
                            <div class="color-option" style="width: 45px; height: 45px; background: #e67e22; border-radius: 50%; cursor: pointer; border: 3px solid transparent; transition: all 0.3s ease;"></div>
                        </div>
                    </div>

                    <!-- Quantity & Add to Cart -->
                    <div style="display: flex; gap: 15px; margin-bottom: 25px;">
                        <div style="display: flex; align-items: center; border: 2px solid #e0e0e0; border-radius: 10px; overflow: hidden;">
                            <button onclick="decreaseQty()" style="width: 45px; height: 55px; background: #f8f8f8; border: none; cursor: pointer; font-size: 18px; font-weight: 600; transition: all 0.3s ease;">-</button>
                            <input type="number" id="quantity" value="1" min="1" style="width: 70px; height: 55px; border: none; text-align: center; font-size: 18px; font-weight: 600; outline: none;">
                            <button onclick="increaseQty()" style="width: 45px; height: 55px; background: #f8f8f8; border: none; cursor: pointer; font-size: 18px; font-weight: 600; transition: all 0.3s ease;">+</button>
                        </div>
                        <button class="add-to-cart-btn" style="flex: 1; background: #4A90E2; color: #fff; border: none; padding: 0 40px; border-radius: 10px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 10px;">
                            <i class="fas fa-shopping-cart"></i>
                            Add to Cart
                        </button>
                    </div>

                    <!-- Action Buttons -->
                    <div style="display: flex; gap: 10px; margin-bottom: 30px;">
                        <button style="flex: 1; background: #fff; color: #4A90E2; border: 2px solid #4A90E2; padding: 14px; border-radius: 10px; font-size: 15px; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">
                            <i class="fas fa-heart" style="margin-right: 8px;"></i>
                            Add to Wishlist
                        </button>
                        <button style="flex: 1; background: #fff; color: #4A90E2; border: 2px solid #4A90E2; padding: 14px; border-radius: 10px; font-size: 15px; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">
                            <i class="fas fa-balance-scale" style="margin-right: 8px;"></i>
                            Compare
                        </button>
                    </div>

                    <!-- Payment & Shipping Info -->
                    <div style="display: flex; gap: 15px; padding: 20px; background: #f8f8f8; border-radius: 15px;">
                        <div style="flex: 1; text-align: center; padding: 15px; background: #fff; border-radius: 10px;">
                            <i class="fas fa-truck" style="font-size: 28px; color: #4A90E2; margin-bottom: 8px;"></i>
                            <p style="font-size: 13px; font-weight: 600; color: #1a1a1a; margin: 0;">Free Shipping</p>
                            <p style="font-size: 11px; color: #999; margin: 5px 0 0;">Orders over $100</p>
                        </div>
                        <div style="flex: 1; text-align: center; padding: 15px; background: #fff; border-radius: 10px;">
                            <i class="fas fa-undo" style="font-size: 28px; color: #4A90E2; margin-bottom: 8px;"></i>
                            <p style="font-size: 13px; font-weight: 600; color: #1a1a1a; margin: 0;">30 Days Return</p>
                            <p style="font-size: 11px; color: #999; margin: 5px 0 0;">Money back guarantee</p>
                        </div>
                        <div style="flex: 1; text-align: center; padding: 15px; background: #fff; border-radius: 10px;">
                            <i class="fas fa-headset" style="font-size: 28px; color: #4A90E2; margin-bottom: 8px;"></i>
                            <p style="font-size: 13px; font-weight: 600; color: #1a1a1a; margin: 0;">24/7 Support</p>
                            <p style="font-size: 11px; color: #999; margin: 5px 0 0;">Customer service</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Product Tabs (Description, Specifications, Reviews) -->
<section class="product-tabs-section" style="padding: 0 0 100px; background: #fff;">
    <div class="container">
        <div class="product-tabs">
            <!-- Tabs Navigation -->
            <ul class="nav nav-tabs" style="border-bottom: 2px solid #e0e0e0; display: flex; justify-content: center; gap: 0; margin-bottom: 50px;">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#description" style="background: transparent; border: none; padding: 20px 40px; font-size: 16px; font-weight: 600; color: #666; cursor: pointer; border-bottom: 3px solid transparent; transition: all 0.3s ease;">Description</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#specifications" style="background: transparent; border: none; padding: 20px 40px; font-size: 16px; font-weight: 600; color: #666; cursor: pointer; border-bottom: 3px solid transparent; transition: all 0.3s ease;">Specifications</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#reviews" style="background: transparent; border: none; padding: 20px 40px; font-size: 16px; font-weight: 600; color: #666; cursor: pointer; border-bottom: 3px solid transparent; transition: all 0.3s ease;">Reviews (128)</button>
                </li>
            </ul>

            <!-- Tabs Content -->
            <div class="tab-content">
                <!-- Description Tab -->
                <div class="tab-pane fade show active" id="description">
                    <div class="row">
                        <div class="col-lg-8 mx-auto">
                            <h3 style="font-size: 32px; font-weight: 700; color: #1a1a1a; margin-bottom: 25px;">Product Description</h3>
                            <p style="font-size: 17px; color: #666; line-height: 1.8; margin-bottom: 25px;">
                                The Premium Casserole 28cm is the perfect addition to your kitchen. Featuring advanced ceramic coating technology, this casserole ensures food doesn't stick while maintaining the natural flavors of your ingredients. The multi-layer construction provides excellent heat distribution for perfect cooking results every time.
                            </p>
                            <p style="font-size: 17px; color: #666; line-height: 1.8; margin-bottom: 30px;">
                                Made with LFGB German Standard certified materials, this casserole is completely PTFE and PFOA free, making it safe for you and your family. The ergonomic handles stay cool during cooking, and the tempered glass lid allows you to monitor your food without losing heat or moisture.
                            </p>

                            <h4 style="font-size: 24px; font-weight: 600; color: #1a1a1a; margin-bottom: 20px;">What Makes It Special?</h4>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div style="display: flex; gap: 15px;">
                                        <div style="width: 50px; height: 50px; background: #4A90E2; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                            <i class="fas fa-fire" style="font-size: 24px; color: #fff;"></i>
                                        </div>
                                        <div>
                                            <h5 style="font-size: 16px; font-weight: 600; color: #1a1a1a; margin-bottom: 8px;">Even Heat Distribution</h5>
                                            <p style="font-size: 14px; color: #666; margin: 0; line-height: 1.6;">Multi-layer aluminum core ensures uniform heating for perfect results.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div style="display: flex; gap: 15px;">
                                        <div style="width: 50px; height: 50px; background: #27ae60; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                            <i class="fas fa-leaf" style="font-size: 24px; color: #fff;"></i>
                                        </div>
                                        <div>
                                            <h5 style="font-size: 16px; font-weight: 600; color: #1a1a1a; margin-bottom: 8px;">Healthy Cooking</h5>
                                            <p style="font-size: 14px; color: #666; margin: 0; line-height: 1.6;">PTFE & PFOA free ceramic coating for safe, healthy meals.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div style="display: flex; gap: 15px;">
                                        <div style="width: 50px; height: 50px; background: #4A90E2; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                            <i class="fas fa-water" style="font-size: 24px; color: #fff;"></i>
                                        </div>
                                        <div>
                                            <h5 style="font-size: 16px; font-weight: 600; color: #1a1a1a; margin-bottom: 8px;">Easy to Clean</h5>
                                            <p style="font-size: 14px; color: #666; margin: 0; line-height: 1.6;">Non-stick surface and dishwasher safe for effortless cleaning.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div style="display: flex; gap: 15px;">
                                        <div style="width: 50px; height: 50px; background: #27ae60; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                            <i class="fas fa-bolt" style="font-size: 24px; color: #fff;"></i>
                                        </div>
                                        <div>
                                            <h5 style="font-size: 16px; font-weight: 600; color: #1a1a1a; margin-bottom: 8px;">Versatile Cooking</h5>
                                            <p style="font-size: 14px; color: #666; margin: 0; line-height: 1.6;">Works on all cooktops including induction and oven safe.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Specifications Tab -->
                <div class="tab-pane fade" id="specifications">
                    <div class="row">
                        <div class="col-lg-8 mx-auto">
                            <h3 style="font-size: 32px; font-weight: 700; color: #1a1a1a; margin-bottom: 30px;">Technical Specifications</h3>
                            <table style="width: 100%; border-collapse: separate; border-spacing: 0 15px;">
                                <tr>
                                    <td style="padding: 20px; background: #f8f8f8; border-radius: 10px; font-weight: 600; color: #1a1a1a; width: 40%;">Product Code</td>
                                    <td style="padding: 20px; background: #f8f8f8; border-radius: 10px; color: #666;">DH-05468</td>
                                </tr>
                                <tr>
                                    <td style="padding: 20px; background: #f8f8f8; border-radius: 10px; font-weight: 600; color: #1a1a1a;">Size</td>
                                    <td style="padding: 20px; background: #f8f8f8; border-radius: 10px; color: #666;">28cm Diameter / 6 Liters Capacity</td>
                                </tr>
                                <tr>
                                    <td style="padding: 20px; background: #f8f8f8; border-radius: 10px; font-weight: 600; color: #1a1a1a;">Material</td>
                                    <td style="padding: 20px; background: #f8f8f8; border-radius: 10px; color: #666;">Ceramic Coated Aluminum Body</td>
                                </tr>
                                <tr>
                                    <td style="padding: 20px; background: #f8f8f8; border-radius: 10px; font-weight: 600; color: #1a1a1a;">Coating</td>
                                    <td style="padding: 20px; background: #f8f8f8; border-radius: 10px; color: #666;">Multi-layer Ceramic Non-Stick (PTFE & PFOA Free)</td>
                                </tr>
                                <tr>
                                    <td style="padding: 20px; background: #f8f8f8; border-radius: 10px; font-weight: 600; color: #1a1a1a;">Handles</td>
                                    <td style="padding: 20px; background: #f8f8f8; border-radius: 10px; color: #666;">Bakelite Cool Touch Handles</td>
                                </tr>
                                <tr>
                                    <td style="padding: 20px; background: #f8f8f8; border-radius: 10px; font-weight: 600; color: #1a1a1a;">Lid</td>
                                    <td style="padding: 20px; background: #f8f8f8; border-radius: 10px; color: #666;">Tempered Glass with Steam Vent</td>
                                </tr>
                                <tr>
                                    <td style="padding: 20px; background: #f8f8f8; border-radius: 10px; font-weight: 600; color: #1a1a1a;">Cooktop Compatibility</td>
                                    <td style="padding: 20px; background: #f8f8f8; border-radius: 10px; color: #666;">Gas, Electric, Ceramic, Induction</td>
                                </tr>
                                <tr>
                                    <td style="padding: 20px; background: #f8f8f8; border-radius: 10px; font-weight: 600; color: #1a1a1a;">Oven Safe</td>
                                    <td style="padding: 20px; background: #f8f8f8; border-radius: 10px; color: #666;">Yes, up to 220°C (with glass lid)</td>
                                </tr>
                                <tr>
                                    <td style="padding: 20px; background: #f8f8f8; border-radius: 10px; font-weight: 600; color: #1a1a1a;">Dishwasher Safe</td>
                                    <td style="padding: 20px; background: #f8f8f8; border-radius: 10px; color: #666;">Yes</td>
                                </tr>
                                <tr>
                                    <td style="padding: 20px; background: #f8f8f8; border-radius: 10px; font-weight: 600; color: #1a1a1a;">Certification</td>
                                    <td style="padding: 20px; background: #f8f8f8; border-radius: 10px; color: #666;">LFGB German Standards</td>
                                </tr>
                                <tr>
                                    <td style="padding: 20px; background: #f8f8f8; border-radius: 10px; font-weight: 600; color: #1a1a1a;">Warranty</td>
                                    <td style="padding: 20px; background: #f8f8f8; border-radius: 10px; color: #666;">2 Years Manufacturer Warranty</td>
                                </tr>
                                <tr>
                                    <td style="padding: 20px; background: #f8f8f8; border-radius: 10px; font-weight: 600; color: #1a1a1a;">Weight</td>
                                    <td style="padding: 20px; background: #f8f8f8; border-radius: 10px; color: #666;">2.8 kg (with lid)</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Reviews Tab -->
                <div class="tab-pane fade" id="reviews">
                    <div class="row">
                        <div class="col-lg-10 mx-auto">
                            <h3 style="font-size: 32px; font-weight: 700; color: #1a1a1a; margin-bottom: 30px;">Customer Reviews</h3>

                            <!-- Rating Summary -->
                            <div class="rating-summary" style="display: flex; gap: 40px; padding: 40px; background: #f8f8f8; border-radius: 20px; margin-bottom: 40px;">
                                <div style="text-align: center; padding-right: 40px; border-right: 2px solid #e0e0e0;">
                                    <h2 style="font-size: 72px; font-weight: 700; color: #4A90E2; margin-bottom: 10px;">4.5</h2>
                                    <div style="color: #ffa500; font-size: 24px; margin-bottom: 10px;">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                    <p style="font-size: 14px; color: #666; margin: 0;">Based on 128 reviews</p>
                                </div>
                                <div style="flex: 1;">
                                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 12px;">
                                        <span style="font-size: 14px; color: #666; width: 60px;">5 stars</span>
                                        <div style="flex: 1; height: 8px; background: #e0e0e0; border-radius: 10px; overflow: hidden;">
                                            <div style="width: 75%; height: 100%; background: #ffa500;"></div>
                                        </div>
                                        <span style="font-size: 14px; color: #666; width: 40px; text-align: right;">96</span>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 12px;">
                                        <span style="font-size: 14px; color: #666; width: 60px;">4 stars</span>
                                        <div style="flex: 1; height: 8px; background: #e0e0e0; border-radius: 10px; overflow: hidden;">
                                            <div style="width: 18%; height: 100%; background: #ffa500;"></div>
                                        </div>
                                        <span style="font-size: 14px; color: #666; width: 40px; text-align: right;">23</span>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 12px;">
                                        <span style="font-size: 14px; color: #666; width: 60px;">3 stars</span>
                                        <div style="flex: 1; height: 8px; background: #e0e0e0; border-radius: 10px; overflow: hidden;">
                                            <div style="width: 5%; height: 100%; background: #ffa500;"></div>
                                        </div>
                                        <span style="font-size: 14px; color: #666; width: 40px; text-align: right;">7</span>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 12px;">
                                        <span style="font-size: 14px; color: #666; width: 60px;">2 stars</span>
                                        <div style="flex: 1; height: 8px; background: #e0e0e0; border-radius: 10px; overflow: hidden;">
                                            <div style="width: 2%; height: 100%; background: #ffa500;"></div>
                                        </div>
                                        <span style="font-size: 14px; color: #666; width: 40px; text-align: right;">2</span>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 15px;">
                                        <span style="font-size: 14px; color: #666; width: 60px;">1 star</span>
                                        <div style="flex: 1; height: 8px; background: #e0e0e0; border-radius: 10px; overflow: hidden;">
                                            <div style="width: 0%; height: 100%; background: #ffa500;"></div>
                                        </div>
                                        <span style="font-size: 14px; color: #666; width: 40px; text-align: right;">0</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Individual Reviews -->
                            <div class="reviews-list">
                                <!-- Review 1 -->
                                <div style="padding: 30px; background: #f8f8f8; border-radius: 15px; margin-bottom: 20px;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 15px;">
                                        <div style="display: flex; align-items: center; gap: 15px;">
                                            <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #4A90E2, #66A3E8); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 20px; font-weight: 700;">S</div>
                                            <div>
                                                <h5 style="font-size: 16px; font-weight: 600; color: #1a1a1a; margin-bottom: 3px;">Sarah Johnson</h5>
                                                <p style="font-size: 13px; color: #999; margin: 0;">Verified Purchase • 2 weeks ago</p>
                                            </div>
                                        </div>
                                        <div style="color: #ffa500; font-size: 16px;">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                    </div>
                                    <h6 style="font-size: 17px; font-weight: 600; color: #1a1a1a; margin-bottom: 12px;">Excellent quality and performance!</h6>
                                    <p style="font-size: 15px; color: #666; line-height: 1.7; margin: 0;">
                                        I've been using this casserole for 2 weeks now and I'm absolutely in love with it! The non-stick coating works perfectly, nothing sticks and it's so easy to clean. The size is perfect for my family of 4. Highly recommend!
                                    </p>
                                </div>

                                <!-- Review 2 -->
                                <div style="padding: 30px; background: #f8f8f8; border-radius: 15px; margin-bottom: 20px;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 15px;">
                                        <div style="display: flex; align-items: center; gap: 15px;">
                                            <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #4A90E2, #66A3E8); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 20px; font-weight: 700;">M</div>
                                            <div>
                                                <h5 style="font-size: 16px; font-weight: 600; color: #1a1a1a; margin-bottom: 3px;">Mohammed Ali</h5>
                                                <p style="font-size: 13px; color: #999; margin: 0;">Verified Purchase • 1 month ago</p>
                                            </div>
                                        </div>
                                        <div style="color: #ffa500; font-size: 16px;">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                        </div>
                                    </div>
                                    <h6 style="font-size: 17px; font-weight: 600; color: #1a1a1a; margin-bottom: 12px;">Great product, worth the money</h6>
                                    <p style="font-size: 15px; color: #666; line-height: 1.7; margin: 0;">
                                        Very good quality cookware. The heat distribution is excellent and it works great on my induction cooktop. The only minor issue is that the handles get slightly warm, but overall I'm very satisfied with this purchase.
                                    </p>
                                </div>

                                <!-- Review 3 -->
                                <div style="padding: 30px; background: #f8f8f8; border-radius: 15px;">
                                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 15px;">
                                        <div style="display: flex; align-items: center; gap: 15px;">
                                            <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #4A90E2, #66A3E8); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 20px; font-weight: 700;">L</div>
                                            <div>
                                                <h5 style="font-size: 16px; font-weight: 600; color: #1a1a1a; margin-bottom: 3px;">Laila Hassan</h5>
                                                <p style="font-size: 13px; color: #999; margin: 0;">Verified Purchase • 3 months ago</p>
                                            </div>
                                        </div>
                                        <div style="color: #ffa500; font-size: 16px;">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                    </div>
                                    <h6 style="font-size: 17px; font-weight: 600; color: #1a1a1a; margin-bottom: 12px;">Best casserole I've ever owned</h6>
                                    <p style="font-size: 15px; color: #666; line-height: 1.7; margin: 0;">
                                        After 3 months of regular use, this casserole still looks brand new! The ceramic coating hasn't scratched at all and it cleans up beautifully. The glass lid is a nice touch. Can't recommend this enough!
                                    </p>
                                </div>
                            </div>

                            <!-- Write Review Button -->
                            <div style="text-align: center; margin-top: 40px;">
                                <button style="background: #4A90E2; color: #fff; border: none; padding: 16px 40px; border-radius: 10px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">
                                    <i class="fas fa-edit" style="margin-right: 10px;"></i>
                                    Write a Review
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
<section class="related-products-section" style="padding: 100px 0; background: #f8f8f8;">
    <div class="container">
        <div class="section-title" style="margin-bottom: 50px; text-align: center;">
            <h2 style="font-size: 42px; font-weight: 700; color: #1a1a1a; margin-bottom: 15px;">You May Also Like</h2>
            <p style="font-size: 16px; color: #666;">Complete your kitchen with these premium products</p>
        </div>

        <div class="row">
            <!-- Product 1 -->
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="product-card" style="background: #fff; border-radius: 15px; overflow: hidden; transition: all 0.3s ease;">
                    <div style="position: relative; overflow: hidden;">
                        <img src="https://images.unsplash.com/photo-1556909212-d5b604d0c90d?w=500&h=500&fit=crop&q=85" alt="Fry Pan" style="width: 100%; display: block;">
                        <div style="position: absolute; top: 15px; right: 15px; background: #fff; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                            <i class="far fa-heart" style="color: #e74c3c;"></i>
                        </div>
                    </div>
                    <div style="padding: 20px;">
                        <span style="background: #4A90E2; color: #fff; padding: 4px 12px; border-radius: 15px; font-size: 11px; font-weight: 600;">Premium Cookware</span>
                        <h4 style="font-size: 16px; font-weight: 600; color: #1a1a1a; margin: 15px 0 10px;">Premium Fry Pan 28cm</h4>
                        <p style="font-size: 13px; color: #999; margin-bottom: 12px;">DH-05488</p>
                        <div style="font-size: 20px; font-weight: 700; color: #4A90E2;">$75.00</div>
                        <button style="width: 100%; background: #4A90E2; color: #fff; border: none; padding: 12px; border-radius: 8px; font-weight: 600; cursor: pointer; margin-top: 15px; transition: all 0.3s ease;">Add to Cart</button>
                    </div>
                </div>
            </div>

            <!-- Product 2 -->
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="product-card" style="background: #fff; border-radius: 15px; overflow: hidden; transition: all 0.3s ease;">
                    <div style="position: relative; overflow: hidden;">
                        <img src="https://images.unsplash.com/photo-1585515320310-259814833e62?w=500&h=500&fit=crop&q=85" alt="Pressure Cooker" style="width: 100%; display: block;">
                        <div style="position: absolute; top: 15px; right: 15px; background: #fff; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                            <i class="far fa-heart" style="color: #e74c3c;"></i>
                        </div>
                    </div>
                    <div style="padding: 20px;">
                        <span style="background: #4A90E2; color: #fff; padding: 4px 12px; border-radius: 15px; font-size: 11px; font-weight: 600;">GoPress</span>
                        <h4 style="font-size: 16px; font-weight: 600; color: #1a1a1a; margin: 15px 0 10px;">GoPress Pressure Cooker 6L</h4>
                        <p style="font-size: 13px; color: #999; margin-bottom: 12px;">DH-06436</p>
                        <div style="font-size: 20px; font-weight: 700; color: #4A90E2;">$129.00</div>
                        <button style="width: 100%; background: #4A90E2; color: #fff; border: none; padding: 12px; border-radius: 8px; font-weight: 600; cursor: pointer; margin-top: 15px; transition: all 0.3s ease;">Add to Cart</button>
                    </div>
                </div>
            </div>

            <!-- Product 3 -->
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="product-card" style="background: #fff; border-radius: 15px; overflow: hidden; transition: all 0.3s ease;">
                    <div style="position: relative; overflow: hidden;">
                        <span style="position: absolute; top: 15px; left: 15px; background: #27ae60; color: #fff; padding: 6px 15px; border-radius: 20px; font-weight: 600; font-size: 12px; z-index: 10;">New</span>
                        <img src="https://images.unsplash.com/photo-1565557623262-b51c2513a641?w=500&h=500&fit=crop&q=85" alt="Stock Pot" style="width: 100%; display: block;">
                        <div style="position: absolute; top: 15px; right: 15px; background: #fff; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                            <i class="far fa-heart" style="color: #e74c3c;"></i>
                        </div>
                    </div>
                    <div style="padding: 20px;">
                        <span style="background: #4A90E2; color: #fff; padding: 4px 12px; border-radius: 15px; font-size: 11px; font-weight: 600;">SteelPro</span>
                        <h4 style="font-size: 16px; font-weight: 600; color: #1a1a1a; margin: 15px 0 10px;">Stock Pot 32cm</h4>
                        <p style="font-size: 13px; color: #999; margin-bottom: 12px;">DH-03832</p>
                        <div style="font-size: 20px; font-weight: 700; color: #4A90E2;">$95.00</div>
                        <button style="width: 100%; background: #4A90E2; color: #fff; border: none; padding: 12px; border-radius: 8px; font-weight: 600; cursor: pointer; margin-top: 15px; transition: all 0.3s ease;">Add to Cart</button>
                    </div>
                </div>
            </div>

            <!-- Product 4 -->
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                <div class="product-card" style="background: #fff; border-radius: 15px; overflow: hidden; transition: all 0.3s ease;">
                    <div style="position: relative; overflow: hidden;">
                        <img src="https://images.unsplash.com/photo-1578926314433-e2789279f4aa?w=500&h=500&fit=crop&q=85" alt="Cutlery Set" style="width: 100%; display: block;">
                        <div style="position: absolute; top: 15px; right: 15px; background: #fff; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                            <i class="far fa-heart" style="color: #e74c3c;"></i>
                        </div>
                    </div>
                    <div style="padding: 20px;">
                        <span style="background: #4A90E2; color: #fff; padding: 4px 12px; border-radius: 15px; font-size: 11px; font-weight: 600;">Cutlery</span>
                        <h4 style="font-size: 16px; font-weight: 600; color: #1a1a1a; margin: 15px 0 10px;">Safari Cutlery Set 72 Pcs</h4>
                        <p style="font-size: 13px; color: #999; margin-bottom: 12px;">DH-01998</p>
                        <div style="font-size: 20px; font-weight: 700; color: #4A90E2;">$199.00</div>
                        <button style="width: 100%; background: #4A90E2; color: #fff; border: none; padding: 12px; border-radius: 8px; font-weight: 600; cursor: pointer; margin-top: 15px; transition: all 0.3s ease;">Add to Cart</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Tab Navigation Active State */
.nav-link.active {
    color: #4A90E2 !important;
    border-bottom-color: #4A90E2 !important;
}

.nav-link:hover {
    color: #4A90E2 !important;
}

/* Thumbnail Active State */
.thumb-item:hover {
    border-color: #4A90E2 !important;
    opacity: 0.8;
}

/* Size Button */
.size-btn:hover {
    border-color: #4A90E2 !important;
    color: #4A90E2 !important;
}

/* Color Option */
.color-option:hover {
    border-color: #4A90E2 !important;
    transform: scale(1.1);
}

/* Add to Cart Button Hover */
.add-to-cart-btn:hover {
    background: #3a7bc8 !important;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(74, 144, 226, 0.3);
}

/* Product Card Hover */
.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.1);
}

/* Wishlist Button Hover */
.wishlist-btn:hover {
    background: #e74c3c !important;
}

.wishlist-btn:hover i {
    color: #fff !important;
}

/* Quantity Buttons Hover */
button[onclick*="Qty"]:hover {
    background: #4A90E2 !important;
    color: #fff !important;
}

/* Responsive */
@media (max-width: 768px) {
    .certifications {
        flex-wrap: wrap;
    }

    .product-detail-info {
        margin-top: 30px;
    }
}
</style>

<script>
// Change Main Image
function changeImage(thumb) {
    const mainImage = document.getElementById('mainImage');
    const newSrc = thumb.querySelector('img').src.replace('200', '700').replace('150', '700');
    mainImage.src = newSrc;

    // Update active thumbnail
    document.querySelectorAll('.thumb-item').forEach(item => {
        item.style.borderColor = 'transparent';
    });
    thumb.style.borderColor = '#4A90E2';
}

// Quantity Controls
function increaseQty() {
    const input = document.getElementById('quantity');
    input.value = parseInt(input.value) + 1;
}

function decreaseQty() {
    const input = document.getElementById('quantity');
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

// Size Selection
document.querySelectorAll('.size-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.size-btn').forEach(b => {
            b.style.borderColor = '#e0e0e0';
            b.style.background = '#fff';
            b.style.color = '#1a1a1a';
        });
        this.style.borderColor = '#4A90E2';
        this.style.background = '#4A90E2';
        this.style.color = '#fff';
    });
});

// Color Selection
document.querySelectorAll('.color-option').forEach(option => {
    option.addEventListener('click', function() {
        document.querySelectorAll('.color-option').forEach(opt => {
            opt.style.borderColor = 'transparent';
            opt.classList.remove('active');
            const check = opt.querySelector('i');
            if (check) check.remove();
        });
        this.style.borderColor = '#4A90E2';
        this.classList.add('active');
        this.innerHTML = '<i class="fas fa-check" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #fff; font-size: 18px;"></i>';
    });
});

// Add to Cart
document.querySelector('.add-to-cart-btn').addEventListener('click', function() {
    const originalText = this.innerHTML;
    this.innerHTML = '<i class="fas fa-check"></i> Added to Cart';
    this.style.background = '#27ae60';

    setTimeout(() => {
        this.innerHTML = originalText;
        this.style.background = '#4A90E2';
    }, 2000);
});

// Wishlist Toggle
document.querySelector('.wishlist-btn').addEventListener('click', function() {
    const icon = this.querySelector('i');
    if (icon.classList.contains('far')) {
        icon.classList.remove('far');
        icon.classList.add('fas');
        this.style.background = '#e74c3c';
        icon.style.color = '#fff';
    } else {
        icon.classList.remove('fas');
        icon.classList.add('far');
        this.style.background = '#fff';
        icon.style.color = '#e74c3c';
    }
});
</script>

<?php include 'footer.php'; ?>