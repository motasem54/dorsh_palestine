<?php
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/functions.php';
require_once 'includes/language.php';

$page_title = 'Home';

// Get featured products
$featured_products = $db->query(
    "SELECT * FROM products WHERE featured = 1 AND status = 'active' ORDER BY created_at DESC LIMIT 8"
)->fetchAll();

// Get new arrivals
$new_arrivals = $db->query(
    "SELECT * FROM products WHERE status = 'active' ORDER BY created_at DESC LIMIT 8"
)->fetchAll();

include 'includes/header.php';
?>

    <!-- Hero Video Section - Like Emaar -->
    <section id="home" class="hero-video-section">
        <div class="video-container-hero">
            <video class="hero-video-bg" autoplay muted loop playsinline>
                <source src="videos/vid.mp4" type="video/mp4">
            </video>
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <img src="images/logo.png" alt="Dorsch Palestine" class="hero-logo">
                <p class="subtitle">Premium Kitchen Accessories & Cookware</p>
                <a href="#collections" class="btn-primary-custom">EXPLORE COLLECTIONS</a>
            </div>
        </div>
    </section>

    <!-- Collections Grid -->
    <section id="collections" class="collections-grid-section">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>Product Collections</h2>
                <p>Discover our premium range of kitchen accessories designed with German standards for modern cooking</p>
            </div>
            <div class="row">
                <!-- Premium Cookware -->
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="collection-item">
                        <img src="https://images.unsplash.com/photo-1584990347449-39e6082f2b6c?w=800&h=600&fit=crop" alt="Premium Cookware">
                        <div class="collection-content">
                            <span class="collection-badge">Premium</span>
                            <h3>Premium Cookware</h3>
                            <p>Ceramic coated, PTFE & PFOA free. Multi-layer non-stick coating for healthy cooking.</p>
                            <a href="products.php?collection=premium" class="collection-link">View Collection <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Lifetime Series -->
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="collection-item">
                        <img src="https://images.unsplash.com/photo-1556909212-d5b604d0c90d?w=800&h=600&fit=crop" alt="Lifetime Series">
                        <div class="collection-content">
                            <span class="collection-badge">Lifetime Warranty</span>
                            <h3>Lifetime Series</h3>
                            <p>Durable cookware with lifetime guarantee. Built to last generations.</p>
                            <a href="products.php?collection=lifetime" class="collection-link">View Collection <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- SteelPro -->
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="collection-item">
                        <img src="https://images.unsplash.com/photo-1565557623262-b51c2513a641?w=600&h=600&fit=crop" alt="SteelPro">
                        <div class="collection-content">
                            <span class="collection-badge">Stainless Steel</span>
                            <h3>SteelPro</h3>
                            <p>Professional grade stainless steel cookware.</p>
                            <a href="products.php?collection=steelpro" class="collection-link">Shop Now <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- GoPress -->
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="collection-item">
                        <img src="https://images.unsplash.com/photo-1585515320310-259814833e62?w=600&h=600&fit=crop" alt="GoPress">
                        <div class="collection-content">
                            <span class="collection-badge">70% Faster</span>
                            <h3>GoPress</h3>
                            <p>High-performance pressure cookers.</p>
                            <a href="products.php?collection=gopress" class="collection-link">Shop Now <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Bakeware -->
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="collection-item">
                        <img src="https://images.unsplash.com/photo-1495147466023-ac5c588e2e94?w=600&h=600&fit=crop" alt="Bakeware">
                        <div class="collection-content">
                            <span class="collection-badge">New</span>
                            <h3>Bakeware</h3>
                            <p>Professional baking pans and molds.</p>
                            <a href="products.php?collection=bakeware" class="collection-link">Shop Now <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products Slider -->
    <?php if (!empty($featured_products)): ?>
    <section id="products" class="products-slider-section">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2><?php echo t('featured_products'); ?></h2>
                <p>Explore our best-selling premium kitchen accessories from the catalog</p>
            </div>
            <div class="swiper productsSwiper" data-aos="fade-up" data-aos-delay="200">
                <div class="swiper-wrapper">
                    <?php foreach ($featured_products as $product): ?>
                    <div class="swiper-slide">
                        <div class="product-card">
                            <div class="product-thumb">
                                <?php if ($product['compare_price'] && $product['compare_price'] > $product['price']): ?>
                                <span class="product-badge">Sale</span>
                                <?php endif; ?>
                                <img src="<?php echo $product['main_image'] ?: 'images/products/default.jpg'; ?>" alt="<?php echo h(translate($product, 'name')); ?>">
                                <div class="product-actions">
                                    <button title="Add to Wishlist" class="add-to-wishlist" data-product-id="<?php echo $product['id']; ?>"><i class="far fa-heart"></i></button>
                                    <button title="Quick View" onclick="quickView(<?php echo $product['id']; ?>)"><i class="far fa-eye"></i></button>
                                    <button title="Add to Cart" class="add-to-cart" data-product-id="<?php echo $product['id']; ?>"><i class="fas fa-shopping-cart"></i></button>
                                </div>
                            </div>
                            <div class="product-info">
                                <span class="category"><?php echo h(translate($product, 'category')); ?></span>
                                <h4><a href="product.php?id=<?php echo $product['id']; ?>"><?php echo h(translate($product, 'name')); ?></a></h4>
                                <p class="product-code"><?php echo $product['sku'] ?? 'DH-' . str_pad($product['id'], 5, '0', STR_PAD_LEFT); ?></p>
                                <div class="product-price">
                                    $<?php echo number_format($product['price'], 2); ?>
                                    <?php if ($product['compare_price'] && $product['compare_price'] > $product['price']): ?>
                                    <del>$<?php echo number_format($product['compare_price'], 2); ?></del>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Reviews Section -->
    <section class="reviews-section" style="padding: 100px 0; background: #fff;">
        <div class="container">
            <div class="section-title" data-aos="fade-up" style="margin-bottom: 60px; text-align: center;">
                <h2 style="font-size: 48px; font-weight: 700; color: #1a1a1a; margin-bottom: 20px;">Customer Reviews</h2>
                <p style="font-size: 18px; color: #666; max-width: 700px; margin: 0 auto; line-height: 1.8;">See what our customers say about Dorsch products</p>
            </div>

            <!-- Reviews Swiper -->
            <div class="swiper reviewsSwiper" data-aos="fade-up" data-aos-delay="200">
                <div class="swiper-wrapper">
                    <!-- Review 1 -->
                    <div class="swiper-slide">
                        <div class="review-card" style="background: #f8f8f8; padding: 40px; border-radius: 20px; height: 100%; display: flex; flex-direction: column; transition: all 0.3s ease;">
                            <div class="review-stars" style="color: #ffa500; font-size: 20px; margin-bottom: 20px;">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <p style="font-size: 16px; color: #666; line-height: 1.8; margin-bottom: 25px; flex: 1;">
                                "The Premium Casserole is absolutely amazing! The non-stick coating works perfectly and cleaning is so easy. I love that it's PFOA free - perfect for healthy cooking."
                            </p>
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #4A90E2, #66A3E8); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 24px; font-weight: 700;">
                                    S
                                </div>
                                <div>
                                    <h5 style="font-size: 18px; font-weight: 600; color: #1a1a1a; margin-bottom: 5px;">Sarah Johnson</h5>
                                    <p style="font-size: 14px; color: #999; margin: 0;">Verified Buyer</p>
                                </div>
                            </div>
                            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e0e0e0;">
                                <span style="font-size: 13px; color: #4A90E2; font-weight: 600;">
                                    <i class="fas fa-check-circle" style="margin-right: 5px;"></i>
                                    Premium Casserole 28cm
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Review 2 -->
                    <div class="swiper-slide">
                        <div class="review-card" style="background: #f8f8f8; padding: 40px; border-radius: 20px; height: 100%; display: flex; flex-direction: column; transition: all 0.3s ease;">
                            <div class="review-stars" style="color: #ffa500; font-size: 20px; margin-bottom: 20px;">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <p style="font-size: 16px; color: #666; line-height: 1.8; margin-bottom: 25px; flex: 1;">
                                "Best pressure cooker I've ever used! The GoPress 6L cooks meals 70% faster and the quality is outstanding. German engineering at its finest!"
                            </p>
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #4A90E2, #66A3E8); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 24px; font-weight: 700;">
                                    M
                                </div>
                                <div>
                                    <h5 style="font-size: 18px; font-weight: 600; color: #1a1a1a; margin-bottom: 5px;">Mohammed Ali</h5>
                                    <p style="font-size: 14px; color: #999; margin: 0;">Verified Buyer</p>
                                </div>
                            </div>
                            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e0e0e0;">
                                <span style="font-size: 13px; color: #4A90E2; font-weight: 600;">
                                    <i class="fas fa-check-circle" style="margin-right: 5px;"></i>
                                    GoPress Pressure Cooker 6L
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Review 3 -->
                    <div class="swiper-slide">
                        <div class="review-card" style="background: #f8f8f8; padding: 40px; border-radius: 20px; height: 100%; display: flex; flex-direction: column; transition: all 0.3s ease;">
                            <div class="review-stars" style="color: #ffa500; font-size: 20px; margin-bottom: 20px;">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <p style="font-size: 16px; color: #666; line-height: 1.8; margin-bottom: 25px; flex: 1;">
                                "I bought the Safari Cutlery Set and it's gorgeous! The quality is premium and it looks amazing on my dining table. Worth every penny!"
                            </p>
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #4A90E2, #66A3E8); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 24px; font-weight: 700;">
                                    L
                                </div>
                                <div>
                                    <h5 style="font-size: 18px; font-weight: 600; color: #1a1a1a; margin-bottom: 5px;">Laila Hassan</h5>
                                    <p style="font-size: 14px; color: #999; margin: 0;">Verified Buyer</p>
                                </div>
                            </div>
                            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e0e0e0;">
                                <span style="font-size: 13px; color: #4A90E2; font-weight: 600;">
                                    <i class="fas fa-check-circle" style="margin-right: 5px;"></i>
                                    Safari Cutlery Set 72 Pcs
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Review 4 -->
                    <div class="swiper-slide">
                        <div class="review-card" style="background: #f8f8f8; padding: 40px; border-radius: 20px; height: 100%; display: flex; flex-direction: column; transition: all 0.3s ease;">
                            <div class="review-stars" style="color: #ffa500; font-size: 20px; margin-bottom: 20px;">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <p style="font-size: 16px; color: #666; line-height: 1.8; margin-bottom: 25px; flex: 1;">
                                "The Lifetime Series lives up to its name! Durable, high-quality, and the lifetime warranty gives me peace of mind. Highly recommended!"
                            </p>
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #4A90E2, #66A3E8); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 24px; font-weight: 700;">
                                    A
                                </div>
                                <div>
                                    <h5 style="font-size: 18px; font-weight: 600; color: #1a1a1a; margin-bottom: 5px;">Ahmad Khalil</h5>
                                    <p style="font-size: 14px; color: #999; margin: 0;">Verified Buyer</p>
                                </div>
                            </div>
                            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e0e0e0;">
                                <span style="font-size: 13px; color: #4A90E2; font-weight: 600;">
                                    <i class="fas fa-check-circle" style="margin-right: 5px;"></i>
                                    Lifetime Series Cookware Set
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Review 5 -->
                    <div class="swiper-slide">
                        <div class="review-card" style="background: #f8f8f8; padding: 40px; border-radius: 20px; height: 100%; display: flex; flex-direction: column; transition: all 0.3s ease;">
                            <div class="review-stars" style="color: #ffa500; font-size: 20px; margin-bottom: 20px;">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <p style="font-size: 16px; color: #666; line-height: 1.8; margin-bottom: 25px; flex: 1;">
                                "Love my new frying pan! It heats evenly and nothing sticks. The ceramic coating is fantastic and I feel good about cooking healthy meals for my family."
                            </p>
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #4A90E2, #66A3E8); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 24px; font-weight: 700;">
                                    R
                                </div>
                                <div>
                                    <h5 style="font-size: 18px; font-weight: 600; color: #1a1a1a; margin-bottom: 5px;">Rania Khaled</h5>
                                    <p style="font-size: 14px; color: #999; margin: 0;">Verified Buyer</p>
                                </div>
                            </div>
                            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e0e0e0;">
                                <span style="font-size: 13px; color: #4A90E2; font-weight: 600;">
                                    <i class="fas fa-check-circle" style="margin-right: 5px;"></i>
                                    Premium Fry Pan 28cm
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Review 6 -->
                    <div class="swiper-slide">
                        <div class="review-card" style="background: #f8f8f8; padding: 40px; border-radius: 20px; height: 100%; display: flex; flex-direction: column; transition: all 0.3s ease;">
                            <div class="review-stars" style="color: #ffa500; font-size: 20px; margin-bottom: 20px;">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                            <p style="font-size: 16px; color: #666; line-height: 1.8; margin-bottom: 25px; flex: 1;">
                                "Great quality knives! Sharp, durable, and the set comes with everything I need. The only reason I didn't give 5 stars is the price, but the quality justifies it."
                            </p>
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #4A90E2, #66A3E8); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 24px; font-weight: 700;">
                                    Y
                                </div>
                                <div>
                                    <h5 style="font-size: 18px; font-weight: 600; color: #1a1a1a; margin-bottom: 5px;">Youssef Nasser</h5>
                                    <p style="font-size: 14px; color: #999; margin: 0;">Verified Buyer</p>
                                </div>
                            </div>
                            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e0e0e0;">
                                <span style="font-size: 13px; color: #4A90E2; font-weight: 600;">
                                    <i class="fas fa-check-circle" style="margin-right: 5px;"></i>
                                    Classic Knife Set 14 Pcs
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>

            <!-- Review Stats -->
            <div class="review-stats" style="margin-top: 60px; text-align: center; background: #f8f8f8; padding: 50px; border-radius: 20px;" data-aos="fade-up" data-aos-delay="300">
                <div class="row">
                    <div class="col-md-3">
                        <div style="padding: 20px;">
                            <h3 style="font-size: 48px; font-weight: 700; color: #4A90E2; margin-bottom: 10px;">4.8</h3>
                            <div style="color: #ffa500; font-size: 24px; margin-bottom: 10px;">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <p style="font-size: 14px; color: #666; margin: 0;">Average Rating</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div style="padding: 20px; border-left: 1px solid #e0e0e0;">
                            <h3 style="font-size: 48px; font-weight: 700; color: #4A90E2; margin-bottom: 10px;">12,500+</h3>
                            <p style="font-size: 14px; color: #666; margin: 0;">Total Reviews</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div style="padding: 20px; border-left: 1px solid #e0e0e0;">
                            <h3 style="font-size: 48px; font-weight: 700; color: #4A90E2; margin-bottom: 10px;">96%</h3>
                            <p style="font-size: 14px; color: #666; margin: 0;">Recommend Us</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div style="padding: 20px; border-left: 1px solid #e0e0e0;">
                            <h3 style="font-size: 48px; font-weight: 700; color: #4A90E2; margin-bottom: 10px;">50+</h3>
                            <p style="font-size: 14px; color: #666; margin: 0;">Countries</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
    /* Review Card Hover Effect */
    .review-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 40px rgba(74, 144, 226, 0.15);
    }

    /* Reviews Swiper */
    .reviewsSwiper {
        padding: 20px 0 60px;
    }

    .reviewsSwiper .swiper-button-next,
    .reviewsSwiper .swiper-button-prev {
        color: #4A90E2;
        width: 50px;
        height: 50px;
        background: #fff;
        border-radius: 50%;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .reviewsSwiper .swiper-button-next:after,
    .reviewsSwiper .swiper-button-prev:after {
        font-size: 20px;
    }

    .reviewsSwiper .swiper-pagination-bullet {
        background: #4A90E2;
        width: 12px;
        height: 12px;
        opacity: 0.3;
    }

    .reviewsSwiper .swiper-pagination-bullet-active {
        opacity: 1;
        width: 30px;
        border-radius: 6px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .review-stats .col-md-3 {
            margin-bottom: 20px;
        }
        .review-stats .col-md-3 div {
            border-left: none !important;
            border-bottom: 1px solid #e0e0e0;
        }
        .review-stats .col-md-3:last-child div {
            border-bottom: none;
        }
    }
    </style>

    <script>
    // Initialize Reviews Swiper
    const reviewsSwiper = new Swiper('.reviewsSwiper', {
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
    </script>
    
    <!-- Video Showcase -->
    <section id="about" class="video-showcase">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5" data-aos="fade-right">
                    <h2 style="font-size: 48px; font-weight: 700; margin-bottom: 25px; line-height: 1.2;">German Quality Standards</h2>
                    <p style="font-size: 18px; color: var(--secondary-gray); line-height: 1.8; margin-bottom: 30px;">
                        At Dorsch, we aim for a healthy, green earth. Our products are made in compliance with LFGB German Standards, ensuring the highest quality and safety for your family.
                    </p>
                    <ul style="list-style: none; padding: 0; margin-bottom: 35px;">
                        <li style="padding: 12px 0; font-size: 17px; display: flex; align-items: center;">
                            <i class="fas fa-check-circle" style="color: var(--primary-gold); margin-right: 15px; font-size: 20px;"></i>
                            LFGB German Standards Certified
                        </li>
                        <li style="padding: 12px 0; font-size: 17px; display: flex; align-items: center;">
                            <i class="fas fa-check-circle" style="color: var(--primary-gold); margin-right: 15px; font-size: 20px;"></i>
                            PTFE & PFOA Free Coating
                        </li>
                        <li style="padding: 12px 0; font-size: 17px; display: flex; align-items: center;">
                            <i class="fas fa-check-circle" style="color: var(--primary-gold); margin-right: 15px; font-size: 20px;"></i>
                            Recyclable & Eco-Friendly Materials
                        </li>
                        <li style="padding: 12px 0; font-size: 17px; display: flex; align-items: center;">
                            <i class="fas fa-check-circle" style="color: var(--primary-gold); margin-right: 15px; font-size: 20px;"></i>
                            Lifetime Warranty on Selected Products
                        </li>
                    </ul>
                    <div>
                        <h4 style="font-size: 24px; font-weight: 600; margin-bottom: 15px;">Our Vision</h4>
                        <p style="font-size: 16px; color: var(--secondary-gray); line-height: 1.8;">
                            We want to be the leading supplier of pots and pans with a focus on sustainability, the environment, and healthy cooking.
                        </p>
                    </div>
                </div>
                <div class="col-lg-7" data-aos="fade-left" data-aos-delay="200">
                    <div class="video-wrapper" style="margin-top: 30px;">
                        <video controls poster="https://images.unsplash.com/photo-1556910103-1c02745aae4d?w=800&h=500&fit=crop">
                            <source src="images/quality-video.mp4" type="video/mp4">
                        </video>
                        <div class="video-info-overlay">
                            <h3>Quality You Can Trust</h3>
                            <p>Made with German precision for lasting performance</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-item">
                        <div class="stat-number">25+</div>
                        <div class="stat-label">Years Experience</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-item">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Products</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-item">
                        <div class="stat-number">50+</div>
                        <div class="stat-label">Countries</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="stat-item">
                        <div class="stat-number">100%</div>
                        <div class="stat-label">Quality Guarantee</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="features-highlight">
        <div class="container">
            <div class="section-title" data-aos="fade-up" style="margin-bottom: 60px;">
                <h2 style="color: var(--white);">Why Choose Dorsch</h2>
                <p style="color: #ccc;">Premium quality and exceptional service for your kitchen</p>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <h4>Free Worldwide Shipping</h4>
                        <p>Free delivery on orders over $100 to anywhere in the world</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4>Lifetime Warranty</h4>
                        <p>Comprehensive warranty on selected Lifetime series products</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <h4>Eco-Friendly</h4>
                        <p>Recyclable materials and sustainable production methods</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fas fa-certificate"></i>
                        </div>
                        <h4>German Standards</h4>
                        <p>LFGB certified products for safety and quality assurance</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php include 'includes/footer.php'; ?>