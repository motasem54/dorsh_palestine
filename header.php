<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dorsch Palestine - Your Kitchen Partner | Premium Kitchen Accessories</title>
    <meta name="description" content="Leading supplier of premium kitchen appliances focusing on sustainability and healthy cooking.">

    <!-- Favicon -->
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        :root {
            --primary-gold: #4A90E2;
            --primary-dark: #1a1a1a;
            --secondary-gray: #666;
            --light-bg: #f8f8f8;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Work Sans', sans-serif;
            color: var(--primary-dark);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Preloader */
        .preloader-wrap {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--white);
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .preloader {
            text-align: center;
        }

        .preloader .dot {
            width: 24px;
            height: 24px;
            background: var(--primary-gold);
            border-radius: 50%;
            display: inline-block;
            animation: pulse 1.5s infinite ease-in-out;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(0.8); opacity: 0.5; }
            50% { transform: scale(1.2); opacity: 1; }
        }

        /* Header - Fixed on Top */
        .header-area {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 999;
            transition: all 0.3s ease;
            padding: 15px 0;
            background: var(--white);
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        .header-area.scrolled {
            padding: 10px 0;
            box-shadow: 0 2px 20px rgba(0,0,0,0.15);
        }

        .header-logo img {
            height: 45px;
            transition: all 0.3s ease;
        }

        .header-logo-text {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .logo-name {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-dark);
            font-family: 'Lato', sans-serif;
        }

        .logo-country {
            font-size: 14px;
            color: var(--primary-gold);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .main-menu {
            list-style: none;
            display: flex;
            align-items: center;
            margin: 0;
            padding: 0;
            gap: 35px;
        }

        .main-menu li a {
            text-decoration: none;
            color: var(--primary-dark);
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            padding: 5px 0;
            display: inline-block;
            position: relative;
        }

        .main-menu li a::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary-gold);
            transition: width 0.3s ease;
        }

        .main-menu li a:hover::after,
        .main-menu li a.active::after {
            width: 100%;
        }

        .main-menu li a:hover,
        .main-menu li a.active {
            color: var(--primary-gold);
        }

        .header-action-area {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header-action-cart a {
            position: relative;
            color: var(--primary-dark);
            font-size: 22px;
            transition: all 0.3s ease;
        }

        .header-action-cart a:hover {
            color: var(--primary-gold);
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--primary-gold);
            color: var(--white);
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 600;
        }

        .btn-menu {
            display: none;
            flex-direction: column;
            gap: 5px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 10px;
        }

        .btn-menu span {
            width: 25px;
            height: 2px;
            background: var(--primary-dark);
            transition: all 0.3s ease;
        }

        /* Hero Video Section - Like Emaar (Under Header) */
        .hero-video-section {
            position: relative;
            width: 100%;
            margin-top: 75px;
            overflow: hidden;
        }

        .video-container-hero {
            position: relative;
            width: 100%;
            height: 0;
            padding-bottom: 56.25%; /* 16:9 aspect ratio */
            overflow: hidden;
        }

        .hero-video-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0,0,0,0.5), rgba(26,26,26,0.7));
            z-index: 1;
        }

        .hero-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
            text-align: center;
            color: var(--white);
            padding: 20px;
            max-width: 900px;
            width: 100%;
        }

        .hero-logo {
            width: 180px;
            margin-bottom: 30px;
            filter: brightness(0) invert(1);
            animation: fadeInDown 1s ease;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-content h1 {
            font-family: 'Lato', sans-serif;
            font-size: 68px;
            font-weight: 700;
            margin-bottom: 20px;
            letter-spacing: 3px;
            text-transform: uppercase;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.6);
            animation: fadeInUp 1s ease 0.3s both;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-content .subtitle {
            font-size: 26px;
            font-weight: 300;
            margin-bottom: 40px;
            color: var(--primary-gold);
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
            letter-spacing: 2px;
            animation: fadeInUp 1s ease 0.6s both;
        }

        .btn-primary-custom {
            background: var(--primary-gold);
            color: var(--white);
            padding: 18px 55px;
            font-size: 15px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            border: 2px solid var(--primary-gold);
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.4s ease;
            text-decoration: none;
            display: inline-block;
            animation: fadeInUp 1s ease 0.9s both;
        }

        .btn-primary-custom:hover {
            background: transparent;
            color: var(--white);
            border-color: var(--white);
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(201, 164, 92, 0.4);
        }

        /* Floating Action Buttons */
        .floating-buttons {
            position: fixed;
            bottom: 100px;
            right: 30px;
            z-index: 998;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .float-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 28px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            animation: bounceIn 1s ease;
            text-decoration: none;
        }

        @keyframes bounceIn {
            0% { transform: scale(0); opacity: 0; }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); opacity: 1; }
        }

        .float-btn:hover {
            transform: translateY(-5px) scale(1.1);
            box-shadow: 0 8px 30px rgba(0,0,0,0.3);
        }

        .whatsapp-btn {
            background: linear-gradient(135deg, #25D366, #128C7E);
        }

        .whatsapp-btn:hover {
            background: linear-gradient(135deg, #128C7E, #075E54);
        }

        .ai-bot-btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .ai-bot-btn:hover {
            background: linear-gradient(135deg, #764ba2, #667eea);
        }

        .float-btn .tooltip-text {
            position: absolute;
            right: 75px;
            background: var(--primary-dark);
            color: var(--white);
            padding: 8px 15px;
            border-radius: 8px;
            font-size: 14px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: all 0.3s ease;
        }

        .float-btn:hover .tooltip-text {
            opacity: 1;
            right: 70px;
        }

        /* Product Collections Grid */
        .collections-grid-section {
            padding: 100px 0;
            background: var(--white);
        }

        .section-title {
            text-align: center;
            margin-bottom: 70px;
        }

        .section-title h2 {
            font-family: 'Lato', sans-serif;
            font-size: 48px;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: var(--primary-gold);
        }

        .section-title p {
            font-size: 18px;
            color: var(--secondary-gray);
            max-width: 700px;
            margin: 25px auto 0;
            line-height: 1.8;
        }

        .collection-item {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            height: 450px;
            cursor: pointer;
            transition: all 0.5s ease;
            margin-bottom: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            background: linear-gradient(135deg, #f0f0f0, #e0e0e0);
        }

        .collection-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(0,0,0,0.1), rgba(0,0,0,0.6));
            z-index: 1;
            transition: all 0.5s ease;
        }

        .collection-item:hover::before {
            background: linear-gradient(to bottom, rgba(201,164,92,0.3), rgba(201,164,92,0.7));
        }

        .collection-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.6s ease;
        }

        .collection-item:hover img {
            transform: scale(1.15);
        }

        .collection-content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 2;
            color: var(--white);
            padding: 40px;
            transform: translateY(0);
            transition: all 0.5s ease;
        }

        .collection-item:hover .collection-content {
            transform: translateY(-10px);
        }

        .collection-badge {
            display: inline-block;
            background: var(--primary-gold);
            color: var(--white);
            padding: 8px 22px;
            border-radius: 25px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
        }

        .collection-content h3 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 12px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.7);
        }

        .collection-content p {
            font-size: 16px;
            opacity: 0.95;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.7);
            margin-bottom: 15px;
        }

        .collection-link {
            color: var(--white);
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            opacity: 0;
            transform: translateX(-20px);
            transition: all 0.5s ease;
        }

        .collection-item:hover .collection-link {
            opacity: 1;
            transform: translateX(0);
        }

        .collection-link i {
            transition: transform 0.3s ease;
        }

        .collection-link:hover i {
            transform: translateX(5px);
        }

        /* Products Slider Section - BIGGER */
        .products-slider-section {
            padding: 100px 0;
            background: var(--light-bg);
        }

        .product-card {
            background: var(--white);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s ease;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        }

        .product-thumb {
            position: relative;
            padding-top: 100%;
            background: linear-gradient(135deg, #f8f8f8 0%, #e8e8e8 100%);
            overflow: hidden;
        }

        .product-thumb img {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 85%;
            max-height: 85%;
            object-fit: contain;
            transition: all 0.4s ease;
        }

        .product-card:hover .product-thumb img {
            transform: translate(-50%, -50%) scale(1.1);
        }

        .product-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: #e74c3c;
            color: var(--white);
            padding: 6px 18px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            z-index: 2;
            text-transform: uppercase;
        }

        .product-badge.new {
            background: #27ae60;
        }

        .product-actions {
            position: absolute;
            top: 15px;
            right: 15px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            opacity: 0;
            transform: translateX(20px);
            transition: all 0.3s ease;
            z-index: 2;
        }

        .product-card:hover .product-actions {
            opacity: 1;
            transform: translateX(0);
        }

        .product-actions button {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            border: none;
            background: var(--white);
            color: var(--primary-dark);
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            font-size: 16px;
        }

        .product-actions button:hover {
            background: var(--primary-gold);
            color: var(--white);
            transform: scale(1.1);
        }

        .product-info {
            padding: 30px;
            text-align: center;
        }

        .product-info .category {
            font-size: 13px;
            color: var(--primary-gold);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .product-info h4 {
            font-size: 20px;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 10px;
            min-height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-info h4 a {
            color: var(--primary-dark);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .product-info h4 a:hover {
            color: var(--primary-gold);
        }

        .product-code {
            font-size: 13px;
            color: var(--secondary-gray);
            margin-bottom: 12px;
            font-family: 'Courier New', monospace;
        }

        .product-price {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-gold);
        }

        .product-price del {
            font-size: 20px;
            color: #999;
            margin-left: 10px;
        }

        /* Swiper Navigation */
        .swiper-button-next,
        .swiper-button-prev {
            color: var(--primary-gold);
            background: var(--white);
            width: 55px;
            height: 55px;
            border-radius: 50%;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }

        .swiper-button-next::after,
        .swiper-button-prev::after {
            font-size: 22px;
        }

        .swiper-pagination-bullet {
            background: var(--primary-gold);
            opacity: 0.5;
            width: 12px;
            height: 12px;
        }

        .swiper-pagination-bullet-active {
            opacity: 1;
            width: 30px;
            border-radius: 6px;
        }

        /* Features with Icons */
        .features-highlight {
            padding: 100px 0;
            background: var(--primary-dark);
            color: var(--white);
        }

        .feature-box {
            text-align: center;
            padding: 40px 25px;
            transition: all 0.3s ease;
        }

        .feature-box:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            width: 85px;
            height: 85px;
            background: linear-gradient(135deg, var(--primary-gold), #66A3E8);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            font-size: 38px;
            color: var(--white);
            transition: all 0.4s ease;
        }

        .feature-box:hover .feature-icon {
            transform: rotateY(360deg);
            box-shadow: 0 10px 30px rgba(201, 164, 92, 0.5);
        }

        .feature-box h4 {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--white);
        }

        .feature-box p {
            font-size: 15px;
            color: #ccc;
            line-height: 1.8;
        }

        /* Video Showcase Section */
        .video-showcase {
            padding: 100px 0;
            background: var(--white);
        }

        .video-wrapper {
            position: relative;
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        }

        .video-wrapper video {
            width: 100%;
            height: auto;
            display: block;
        }

        .video-info-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            padding: 40px;
            color: var(--white);
            z-index: 2;
        }

        .video-info-overlay h3 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 12px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
        }

        .video-info-overlay p {
            font-size: 18px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.8);
            opacity: 0.95;
        }

        /* Stats Section */
        .stats-section {
            padding: 80px 0;
            background: linear-gradient(135deg, var(--primary-gold), #66A3E8);
        }

        .stat-item {
            text-align: center;
            color: var(--white);
            padding: 20px;
        }

        .stat-number {
            font-size: 60px;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .stat-label {
            font-size: 18px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Footer */
        .footer {
            background: #0a0a0a;
            color: var(--white);
            padding: 80px 0 30px;
        }

        .footer-widget h4 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 25px;
            color: var(--primary-gold);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .footer-widget ul {
            list-style: none;
            padding: 0;
        }

        .footer-widget ul li {
            margin-bottom: 12px;
        }

        .footer-widget ul li a {
            color: #ccc;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
        }

        .footer-widget ul li a:hover {
            color: var(--primary-gold);
            padding-left: 8px;
        }

        .footer-widget ul li a i {
            margin-right: 10px;
            color: var(--primary-gold);
        }

        .footer-logo {
            width: 150px;
            margin-bottom: 20px;
        }

        .footer-widget p {
            font-size: 14px;
            color: #ccc;
            line-height: 1.8;
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-links a {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: 18px;
        }

        .social-links a:hover {
            background: var(--primary-gold);
            transform: translateY(-5px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            margin-top: 50px;
            padding-top: 30px;
            text-align: center;
        }

        .footer-bottom p {
            font-size: 14px;
            color: #999;
            margin: 0;
        }

        .footer-bottom a {
            color: var(--primary-gold);
            text-decoration: none;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .main-menu {
                display: none;
                position: fixed;
                top: 75px;
                left: 0;
                width: 100%;
                background: var(--white);
                flex-direction: column;
                padding: 20px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            }

            .main-menu.active {
                display: flex;
            }

            .btn-menu {
                display: flex;
            }

            .hero-content h1 {
                font-size: 42px;
            }

            .hero-content .subtitle {
                font-size: 20px;
            }

            .collection-item {
                height: 350px;
            }

            .floating-buttons {
                bottom: 20px;
                right: 20px;
            }

            .float-btn {
                width: 55px;
                height: 55px;
                font-size: 24px;
            }
        }

        @media (max-width: 768px) {
            .hero-video-section {
                margin-top: 65px;
            }

            .hero-content h1 {
                font-size: 32px;
                letter-spacing: 1px;
            }

            .hero-content .subtitle {
                font-size: 16px;
            }

            .hero-logo {
                width: 120px;
                margin-bottom: 20px;
            }

            .btn-primary-custom {
                padding: 14px 35px;
                font-size: 13px;
            }

            .section-title h2 {
                font-size: 36px;
            }

            .collection-item {
                height: 300px;
            }

            .collection-content h3 {
                font-size: 24px;
            }

            .stat-number {
                font-size: 46px;
            }

            .floating-buttons {
                bottom: 15px;
                right: 15px;
                gap: 10px;
            }

            .float-btn {
                width: 50px;
                height: 50px;
                font-size: 22px;
            }

            .float-btn .tooltip-text {
                display: none;
            }
        }
        
/* ========== ضيف هذا CSS داخل الـ <style> الموجود ========== */

/* Top Bar Styles */
.top-bar {
    background: #1a1a1a;
    color: #fff;
    padding: 12px 0;
    font-size: 13px;
    border-bottom: 1px solid rgba(201, 164, 92, 0.2);
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
}

.top-bar-left {
    display: flex;
    align-items: center;
    gap: 30px;
}

.top-bar-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #ccc;
    text-decoration: none;
    transition: all 0.3s ease;
}

.top-bar-item:hover {
    color: #4A90E2;
}

.top-bar-item i {
    color: #4A90E2;
    font-size: 14px;
}

.top-bar-right {
    display: flex;
    align-items: center;
    gap: 25px;
    justify-content: flex-end;
}

.social-top-links {
    display: flex;
    gap: 12px;
    align-items: center;
}

.social-top-links a {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: rgba(255,255,255,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    transition: all 0.3s ease;
    text-decoration: none;
    font-size: 14px;
}

.social-top-links a:hover {
    background: #4A90E2;
    transform: translateY(-3px);
}

.language-switcher {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 6px 15px;
    border-radius: 20px;
    background: rgba(255,255,255,0.1);
    cursor: pointer;
    transition: all 0.3s ease;
}

.language-switcher:hover {
    background: rgba(201, 164, 92, 0.2);
}

.language-switcher i {
    font-size: 14px;
    color: #4A90E2;
}

.language-switcher span {
    color: #ccc;
    font-size: 13px;
    font-weight: 600;
}

.language-switcher .fa-chevron-down {
    font-size: 10px;
    color: #999;
}

/* Update Header Position */
.header-area {
    top: 46px !important;
}

.header-area.scrolled {
    top: 0 !important;
}

/* Header Action Items */
.header-action-item {
    position: relative;
}

.header-action-item a {
    position: relative;
    color: #1a1a1a;
    font-size: 20px;
    transition: all 0.3s ease;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 45px;
    height: 45px;
    border-radius: 50%;
}

.header-action-item a:hover {
    color: #4A90E2;
    background: rgba(201, 164, 92, 0.1);
    transform: translateY(-2px);
}

.action-count {
    position: absolute;
    top: 2px;
    right: 2px;
    background: #4A90E2;
    color: #fff;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 700;
    border: 2px solid #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}

/* Search Box Overlay */
.search-box-wrapper {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.95);
    z-index: 10000;
    display: none;
    align-items: center;
    justify-content: center;
    animation: fadeIn 0.3s ease;
}

.search-box-wrapper.active {
    display: flex;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.search-box-inner {
    max-width: 900px;
    width: 90%;
    position: relative;
}

.search-box-inner input {
    width: 100%;
    padding: 28px 90px 28px 35px;
    font-size: 28px;
    border: 3px solid #4A90E2;
    border-radius: 50px;
    background: #fff;
    color: #1a1a1a;
    outline: none;
    font-weight: 500;
}

.search-box-inner button {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    width: 65px;
    height: 65px;
    border-radius: 50%;
    background: #4A90E2;
    border: none;
    color: #fff;
    font-size: 24px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.search-box-inner button:hover {
    background: #1a1a1a;
    transform: translateY(-50%) scale(1.1);
}

.search-close {
    position: absolute;
    top: 50px;
    right: 50px;
    width: 55px;
    height: 55px;
    border-radius: 50%;
    background: rgba(255,255,255,0.1);
    border: 2px solid #fff;
    color: #fff;
    font-size: 26px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.search-close:hover {
    background: #4A90E2;
    border-color: #4A90E2;
    transform: rotate(90deg);
}

/* Mobile Menu Overlay */
.mobile-menu-overlay {
    position: fixed;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: #fff;
    z-index: 9999;
    transition: all 0.4s ease;
    overflow-y: auto;
}

.mobile-menu-overlay.active {
    left: 0;
}

.mobile-menu-header {
    padding: 25px;
    border-bottom: 2px solid #f8f8f8;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.mobile-menu-close {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: #f8f8f8;
    border: none;
    color: #1a1a1a;
    font-size: 24px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.mobile-menu-close:hover {
    background: #4A90E2;
    color: #fff;
}

.mobile-menu-content {
    padding: 30px 25px;
}

.mobile-menu-nav ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.mobile-menu-nav ul li {
    border-bottom: 1px solid #f8f8f8;
}

.mobile-menu-nav ul li a {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 15px;
    color: #1a1a1a;
    text-decoration: none;
    font-weight: 600;
    font-size: 16px;
    text-transform: uppercase;
    transition: all 0.3s ease;
}

.mobile-menu-nav ul li a:hover {
    color: #4A90E2;
    padding-left: 25px;
    background: rgba(201, 164, 92, 0.05);
}

.mobile-menu-nav ul li a i {
    font-size: 14px;
    color: #4A90E2;
}

.mobile-menu-actions {
    margin-top: 30px;
    padding-top: 30px;
    border-top: 2px solid #f8f8f8;
}

.mobile-action-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px;
    margin-bottom: 10px;
    background: #f8f8f8;
    border-radius: 12px;
    text-decoration: none;
    color: #1a1a1a;
    transition: all 0.3s ease;
}

.mobile-action-item:hover {
    background: #4A90E2;
    color: #fff;
    transform: translateX(5px);
}

.mobile-action-left {
    display: flex;
    align-items: center;
    gap: 15px;
}

.mobile-action-icon {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.mobile-action-text {
    font-weight: 600;
    font-size: 15px;
}

.mobile-action-badge {
    background: #4A90E2;
    color: #fff;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 700;
}

.mobile-action-item:hover .mobile-action-badge {
    background: #fff;
    color: #4A90E2;
}

.mobile-menu-footer {
    margin-top: 30px;
    padding-top: 30px;
    border-top: 2px solid #f8f8f8;
}

.mobile-contact-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    margin-bottom: 10px;
    background: #f8f8f8;
    border-radius: 10px;
    color: #1a1a1a;
    text-decoration: none;
    transition: all 0.3s ease;
}

.mobile-contact-item:hover {
    background: #4A90E2;
    color: #fff;
}

.mobile-contact-item i {
    color: #4A90E2;
    font-size: 18px;
}

.mobile-contact-item:hover i {
    color: #fff;
}

.mobile-social-links {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-top: 25px;
}

.mobile-social-links a {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: #f8f8f8;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #1a1a1a;
    text-decoration: none;
    font-size: 18px;
    transition: all 0.3s ease;
}

.mobile-social-links a:hover {
    background: #4A90E2;
    color: #fff;
    transform: translateY(-5px);
}

/* Responsive */
@media (max-width: 991px) {
    .top-bar {
        display: none;
    }

    .header-area {
        top: 0 !important;
    }

    .header-action-item a {
        width: 42px;
        height: 42px;
        font-size: 19px;
    }
}

@media (max-width: 768px) {
    .search-box-inner input {
        font-size: 22px;
        padding: 22px 75px 22px 25px;
    }

    .search-box-inner button {
        width: 55px;
        height: 55px;
        font-size: 20px;
    }

    .search-close {
        top: 25px;
        right: 25px;
        width: 50px;
        height: 50px;
        font-size: 22px;
    }

    .header-action-item a {
        width: 38px;
        height: 38px;
        font-size: 17px;
    }
}
/* ========== استبدل CSS الـ Top Bar والـ Header بهذا ========== */

/* Top Bar - More Height & Better Spacing */
.top-bar {
    background: #1a1a1a;
    color: #fff;
    padding: 15px 0;
    font-size: 14px;
    border-bottom: 1px solid rgba(201, 164, 92, 0.3);
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1001;
}

.top-bar-left {
    display: flex;
    align-items: center;
    gap: 35px;
}

.top-bar-item {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #ccc;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 14px;
    padding: 5px 0;
}

.top-bar-item:hover {
    color: #4A90E2;
}

.top-bar-item i {
    color: #4A90E2;
    font-size: 15px;
}

.top-bar-right {
    display: flex;
    align-items: center;
    gap: 30px;
    justify-content: flex-end;
}

.social-top-links {
    display: flex;
    gap: 15px;
    align-items: center;
}

.social-top-links a {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(255,255,255,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    transition: all 0.3s ease;
    text-decoration: none;
    font-size: 15px;
}

.social-top-links a:hover {
    background: #4A90E2;
    transform: translateY(-3px);
}

.language-switcher {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 8px 18px;
    border-radius: 25px;
    background: rgba(255,255,255,0.1);
    cursor: pointer;
    transition: all 0.3s ease;
}

.language-switcher:hover {
    background: rgba(201, 164, 92, 0.3);
}

.language-switcher i {
    font-size: 15px;
    color: #4A90E2;
}

.language-switcher span {
    color: #fff;
    font-size: 14px;
    font-weight: 600;
}

.language-switcher .fa-chevron-down {
    font-size: 11px;
    color: #ccc;
}

/* Header - More Height & Always Fixed */
.header-area {
    position: fixed;
    top: 50px;
    left: 0;
    width: 100%;
    z-index: 1000;
    transition: all 0.4s ease;
    padding: 25px 0;
    background: #fff;
    box-shadow: 0 3px 20px rgba(0,0,0,0.08);
}

.header-area.scrolled {
    top: 0;
    padding: 18px 0;
    box-shadow: 0 3px 25px rgba(0,0,0,0.15);
}

/* Logo Size */
.header-logo img {
    height: 60px;
    transition: all 0.3s ease;
}

.header-area.scrolled .header-logo img {
    height: 50px;
}

/* Menu Items - Better Spacing */
.main-menu {
    list-style: none;
    display: flex;
    align-items: center;
    margin: 0;
    padding: 0;
    gap: 40px;
}

.main-menu li a {
    text-decoration: none;
    color: #1a1a1a;
    font-weight: 600;
    font-size: 15px;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    transition: all 0.3s ease;
    padding: 10px 0;
    display: inline-block;
    position: relative;
}

.main-menu li a::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 3px;
    background: #4A90E2;
    transition: width 0.3s ease;
}

.main-menu li a:hover::after,
.main-menu li a.active::after {
    width: 100%;
}

.main-menu li a:hover,
.main-menu li a.active {
    color: #4A90E2;
}

/* Header Action Items - Bigger Size */
.header-action-area {
    display: flex;
    align-items: center;
    gap: 18px;
}

.header-action-item a {
    position: relative;
    color: #1a1a1a;
    font-size: 22px;
    transition: all 0.3s ease;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 50px;
    height: 50px;
    border-radius: 50%;
}

.header-action-item a:hover {
    color: #4A90E2;
    background: rgba(201, 164, 92, 0.1);
    transform: translateY(-3px);
}

.action-count {
    position: absolute;
    top: 3px;
    right: 3px;
    background: #4A90E2;
    color: #fff;
    border-radius: 50%;
    width: 22px;
    height: 22px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 700;
    border: 2px solid #fff;
    box-shadow: 0 2px 10px rgba(0,0,0,0.2);
}

/* Mobile Menu Button - Better Size */
.btn-menu {
    display: none;
    flex-direction: column;
    gap: 7px;
    background: none;
    border: none;
    cursor: pointer;
    padding: 10px;
    transition: all 0.3s ease;
}

.btn-menu:hover {
    background: rgba(201, 164, 92, 0.1);
    border-radius: 8px;
}

.btn-menu span {
    width: 30px;
    height: 3px;
    background: #1a1a1a;
    transition: all 0.3s ease;
    border-radius: 2px;
}

/* Content Margin - Add space for fixed header */
.hero-video-section {
    margin-top: 140px !important;
}

/* When scrolled, reduce margin */
body.scrolled .hero-video-section {
    margin-top: 120px !important;
}

/* Responsive */
@media (max-width: 991px) {
    .top-bar {
        display: none;
    }

    .header-area {
        top: 0 !important;
        padding: 20px 0;
    }

    .header-area.scrolled {
        padding: 15px 0;
    }

    .header-logo img {
        height: 50px;
    }

    .header-area.scrolled .header-logo img {
        height: 45px;
    }

    .main-menu {
        display: none;
    }

    .btn-menu {
        display: flex;
    }

    .header-action-item a {
        width: 45px;
        height: 45px;
        font-size: 20px;
    }

    .hero-video-section {
        margin-top: 90px !important;
    }
}

@media (max-width: 768px) {
    .header-area {
        padding: 15px 0;
    }

    .header-area.scrolled {
        padding: 12px 0;
    }

    .header-action-area {
        gap: 12px;
    }

    .header-action-item a {
        width: 42px;
        height: 42px;
        font-size: 18px;
    }

    .action-count {
        width: 20px;
        height: 20px;
        font-size: 11px;
    }

    .hero-video-section {
        margin-top: 75px !important;
    }
}
    </style>
</head>
<body>

    <!-- Preloader -->
    <div class="preloader-wrap">
        <div class="preloader">
            <span class="dot"></span>
        </div>
    </div>
<div class="top-bar">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="top-bar-left">
                    <a href="tel:+972599000000" class="top-bar-item">
                        <i class="fas fa-phone-alt"></i>
                        <span>+972 59 900 0000</span>
                    </a>
                    <a href="mailto:info@dorsch.ps" class="top-bar-item">
                        <i class="fas fa-envelope"></i>
                        <span>info@dorsch.ps</span>
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="top-bar-right">
                    <div class="social-top-links">
                        <a href="#" target="_blank" title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" target="_blank" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" target="_blank" title="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" target="_blank" title="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" target="_blank" title="YouTube">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                    <div class="language-switcher" onclick="toggleLanguage()">
                        <i class="fas fa-globe"></i>
                        <span id="currentLang">EN</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- Header - Fixed -->
    <header class="header-area">
        <div class="container">
            <br>
            <div class="row align-items-center">
                <div class="col-3 col-lg-2">
                    <div class="header-logo">
                        <a href="index.php" class="header-logo-text">
                            <img src="images/logo.png" alt="Dorsch Palestine">
                           
                        </a>
                    </div>
                </div>
                <div class="col-9 col-lg-10">
                    <div class="d-flex align-items-center justify-content-end gap-4">
                        <nav class="header-navigation">
                            <ul class="main-menu">
                                <li><a href="index.php" class="active">HOME</a></li>
                                <li><a href="products.php">PRODUCTS</a></li>
                                <li><a href="#collections">COLLECTIONS</a></li>
                                <li><a href="about.php">ABOUT</a></li>
                                <li><a href="contact.php">CONTACT</a></li>
                            </ul>
                        </nav>
                      <div class="header-action-area">
    <!-- Search -->
    <div class="header-action-item">
        <a href="#" onclick="openSearch(event)">
            <i class="fas fa-search"></i>
        </a>
    </div>

    <!-- Wishlist -->
    <div class="header-action-item">
        <a href="wishlist.php">
            <i class="far fa-heart"></i>
            <span class="action-count wishlist-count">5</span>
        </a>
    </div>

    <!-- Compare -->
    <div class="header-action-item">
        <a href="compare.php">
            <i class="fas fa-exchange-alt"></i>
            <span class="action-count compare-count">3</span>
        </a>
    </div>

    <!-- Cart -->
    <div class="header-action-item">
        <a href="cart.php">
            <i class="fas fa-shopping-cart"></i>
            <span class="action-count cart-count">0</span>
        </a>
    </div>

    <button class="btn-menu" onclick="toggleMobileMenu()">
        <span></span>
        <span></span>
        <span></span>
    </button>
</div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="search-box-wrapper" id="searchBox">
    <button class="search-close" onclick="closeSearch()">
        <i class="fas fa-times"></i>
    </button>
    <div class="search-box-inner">
        <form action="products.php" method="GET">
            <input type="text" name="search" placeholder="Search for products..." autocomplete="off" id="searchInput">
            <button type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
</div>
<!-- ========== Mobile Menu Overlay - ضيف بعد Search Box ========== -->
<div class="mobile-menu-overlay" id="mobileMenu">
    <div class="mobile-menu-header">
        <div class="header-logo">
            <img src="images/logo.png" alt="Dorsch Palestine" style="height: 45px;">
        </div>
        <button class="mobile-menu-close" onclick="closeMobileMenu()">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <div class="mobile-menu-content">
        <nav class="mobile-menu-nav">
            <ul>
                <li><a href="index.php">HOME <i class="fas fa-chevron-right"></i></a></li>
                <li><a href="products.php">PRODUCTS <i class="fas fa-chevron-right"></i></a></li>
                <li><a href="index.php#collections">COLLECTIONS <i class="fas fa-chevron-right"></i></a></li>
                <li><a href="about.php">ABOUT <i class="fas fa-chevron-right"></i></a></li>
                <li><a href="contact.php">CONTACT <i class="fas fa-chevron-right"></i></a></li>
            </ul>
        </nav>

        <div class="mobile-menu-actions">
            <a href="wishlist.php" class="mobile-action-item">
                <div class="mobile-action-left">
                    <div class="mobile-action-icon">
                        <i class="far fa-heart" style="color: #4A90E2;"></i>
                    </div>
                    <span class="mobile-action-text">My Wishlist</span>
                </div>
                <div class="mobile-action-badge">5</div>
            </a>

            <a href="compare.php" class="mobile-action-item">
                <div class="mobile-action-left">
                    <div class="mobile-action-icon">
                        <i class="fas fa-exchange-alt" style="color: #4A90E2;"></i>
                    </div>
                    <span class="mobile-action-text">Compare</span>
                </div>
                <div class="mobile-action-badge">3</div>
            </a>

            <a href="cart.php" class="mobile-action-item">
                <div class="mobile-action-left">
                    <div class="mobile-action-icon">
                        <i class="fas fa-shopping-cart" style="color: #4A90E2;"></i>
                    </div>
                    <span class="mobile-action-text">Shopping Cart</span>
                </div>
                <div class="mobile-action-badge cart-count">0</div>
            </a>
        </div>

        <div class="mobile-menu-footer">
            <div class="mobile-contact-info">
                <a href="tel:+972599000000" class="mobile-contact-item">
                    <i class="fas fa-phone-alt"></i>
                    <span>+972 59 900 0000</span>
                </a>
                <a href="mailto:info@dorsch.ps" class="mobile-contact-item">
                    <i class="fas fa-envelope"></i>
                    <span>info@dorsch.ps</span>
                </a>
            </div>

            <div class="mobile-social-links">
                <a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
                <a href="#" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                <a href="#" target="_blank"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </div>
</div>
<style>
    .floating-buttons {
    position: fixed;
    right: 20px;
    bottom: 20px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    z-index: 9999;
}

.float-btn {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 22px;
    text-decoration: none;
    box-shadow: 0 8px 20px rgba(0,0,0,0.25);
    transition: all 0.3s ease;
    position: relative;
}

/* Hover effect */
.float-btn:hover {
    transform: translateY(-4px) scale(1.05);
    box-shadow: 0 12px 28px rgba(0,0,0,0.35);
}

/* Tooltip */
.tooltip-text {
    position: absolute;
    right: 65px;
    background: #222;
    color: #fff;
    padding: 6px 10px;
    border-radius: 6px;
    font-size: 12px;
    white-space: nowrap;
    opacity: 0;
    pointer-events: none;
    transform: translateY(5px);
    transition: all 0.3s ease;
}

.float-btn:hover .tooltip-text {
    opacity: 1;
    transform: translateY(0);
}

/* Buttons colors */
.whatsapp-btn {
    background: #25D366;
}

.ai-bot-btn {
    background: linear-gradient(135deg, #6a5acd, #8a2be2);
}

/* Map button – نفس الفخامة */
.map-btn {
    background: linear-gradient(135deg, #555, #777);
}

</style>
        <!-- Floating Action Buttons -->
  <div class="floating-buttons" style="margin-top:-100px;">

    <!-- Map Marker Button -->
    <a href="#" class="float-btn map-btn" title="Location">
        <i class="fas fa-map-marker-alt"></i>
        <span class="tooltip-text">Our Location</span>
    </a>

    <!-- WhatsApp Button -->
    <a href="https://wa.me/972568000068" target="_blank" class="float-btn whatsapp-btn" title="WhatsApp">
        <i class="fab fa-whatsapp"></i>
        <span class="tooltip-text">Chat on WhatsApp</span>
    </a>

  

</div>


<!-- AI Chatbot Widget -->
<style>
/* Chatbot Button */
.chatbot-button {
    position: fixed;
    bottom: 150px;
    right: 25px;
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #4A90E2 0%, #66A3E8 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 4px 20px rgba(74, 144, 226, 0.4);
    z-index: 9998;
    transition: all 0.3s ease;
    border: none;
}

.chatbot-button:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 30px rgba(74, 144, 226, 0.6);
}

.chatbot-button i {
    font-size: 28px;
    color: #fff;
}

.chatbot-button.active i.fa-comments {
    display: none;
}

.chatbot-button.active i.fa-times {
    display: block;
}

.chatbot-button i.fa-times {
    display: none;
}

/* Chatbot Window */
.chatbot-window {
    position: fixed;
    bottom: 100px;
    right: 30px;
    width: 400px;
    height: 600px;
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    z-index: 9997;
    display: none;
    flex-direction: column;
    overflow: hidden;
    animation: slideUp 0.3s ease;
}

.chatbot-window.active {
    display: flex;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Chatbot Header */
.chatbot-header {
    background: linear-gradient(135deg, #4A90E2 0%, #66A3E8 100%);
    color: #fff;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
}

.chatbot-avatar {
    width: 45px;
    height: 45px;
    background: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: #4A90E2;
}

.chatbot-info h4 {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
}

.chatbot-info p {
    margin: 0;
    font-size: 12px;
    opacity: 0.9;
}

/* Chatbot Body */
.chatbot-body {
    flex: 1;
    padding: 20px;
    overflow-y: auto;
    background: #f8f8f8;
}

.chatbot-message {
    margin-bottom: 15px;
    display: flex;
    gap: 10px;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.chatbot-message.bot {
    justify-content: flex-start;
}

.chatbot-message.user {
    justify-content: flex-end;
}

.message-avatar {
    width: 35px;
    height: 35px;
    background: #4A90E2;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 16px;
    flex-shrink: 0;
}

.message-content {
    max-width: 75%;
    padding: 12px 16px;
    border-radius: 18px;
    font-size: 14px;
    line-height: 1.5;
}

.chatbot-message.bot .message-content {
    background: #fff;
    color: #1a1a1a;
    border-bottom-left-radius: 4px;
}

.chatbot-message.user .message-content {
    background: #4A90E2;
    color: #fff;
    border-bottom-right-radius: 4px;
}

/* Typing Indicator */
.typing-indicator {
    display: none;
    padding: 12px 16px;
    background: #fff;
    border-radius: 18px;
    width: fit-content;
}

.typing-indicator.active {
    display: block;
}

.typing-indicator span {
    display: inline-block;
    width: 8px;
    height: 8px;
    background: #4A90E2;
    border-radius: 50%;
    margin: 0 2px;
    animation: typing 1.4s infinite;
}

.typing-indicator span:nth-child(2) {
    animation-delay: 0.2s;
}

.typing-indicator span:nth-child(3) {
    animation-delay: 0.4s;
}

@keyframes typing {
    0%, 60%, 100% { transform: translateY(0); }
    30% { transform: translateY(-10px); }
}

/* Quick Suggestions */
.quick-suggestions {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 10px;
}

.suggestion-btn {
    background: #fff;
    border: 2px solid #4A90E2;
    color: #4A90E2;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.suggestion-btn:hover {
    background: #4A90E2;
    color: #fff;
}

/* Chatbot Footer */
.chatbot-footer {
    padding: 15px;
    background: #fff;
    border-top: 1px solid #e0e0e0;
    display: flex;
    gap: 10px;
}

.chatbot-input {
    flex: 1;
    padding: 12px 16px;
    border: 2px solid #e0e0e0;
    border-radius: 25px;
    font-size: 14px;
    outline: none;
    transition: all 0.3s ease;
}

.chatbot-input:focus {
    border-color: #4A90E2;
}

.chatbot-send {
    width: 45px;
    height: 45px;
    background: #4A90E2;
    border: none;
    border-radius: 50%;
    color: #fff;
    font-size: 18px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.chatbot-send:hover {
    background: #3a7bc8;
    transform: scale(1.05);
}

.chatbot-send:disabled {
    background: #ccc;
    cursor: not-allowed;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .chatbot-window {
        width: calc(100% - 20px);
        height: calc(100% - 120px);
        right: 10px;
        bottom: 90px;
    }

    .chatbot-button {
        bottom: 20px;
        right: 20px;
    }
}
</style>

<!-- Chatbot Button -->
<button class="chatbot-button" onclick="toggleChatbot()">
    <i class="fas fa-comments"></i>
    <i class="fas fa-times"></i>
</button>

<!-- Chatbot Window -->
<div class="chatbot-window" id="chatbotWindow">
    <!-- Header -->
    <div class="chatbot-header">
        <div class="chatbot-avatar">
            <i class="fas fa-robot"></i>
        </div>
        <div class="chatbot-info">
            <h4>Dorsch Assistant</h4>
            <p>Ask me about our products!</p>
        </div>
    </div>

    <!-- Body -->
    <div class="chatbot-body" id="chatbotBody">
        <!-- Welcome Message -->
        <div class="chatbot-message bot">
            <div class="message-avatar">
                <i class="fas fa-robot"></i>
            </div>
            <div>
                <div class="message-content">
                    Hello! 👋 I'm Dorsch Assistant. How can I help you today?
                </div>
                <div class="quick-suggestions">
                    <button class="suggestion-btn" onclick="sendQuickMessage('Tell me about Premium Cookware')">Premium Cookware</button>
                    <button class="suggestion-btn" onclick="sendQuickMessage('What is LFGB certified?')">LFGB Certified</button>
                    <button class="suggestion-btn" onclick="sendQuickMessage('Show me pressure cookers')">Pressure Cookers</button>
                    <button class="suggestion-btn" onclick="sendQuickMessage('Warranty information')">Warranty Info</button>
                </div>
            </div>
        </div>

        <!-- Typing Indicator -->
        <div class="chatbot-message bot">
            <div class="message-avatar">
                <i class="fas fa-robot"></i>
            </div>
            <div class="typing-indicator" id="typingIndicator">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="chatbot-footer">
        <input type="text" class="chatbot-input" id="chatbotInput" placeholder="Type your message..." onkeypress="handleKeyPress(event)">
        <button class="chatbot-send" onclick="sendMessage()" id="sendButton">
            <i class="fas fa-paper-plane"></i>
        </button>
    </div>
</div>

<script>
// Configuration
const OPENAI_API_KEY = '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';
const CATALOGUE_URL = 'https://mt-apps.com/DorschPalestinePP/doc.pdf';

// System Prompt with Company Information
const SYSTEM_PROMPT = `You are Dorsch Assistant, an AI customer service representative for Dorsch Palestine, a leading supplier of premium kitchen appliances and cookware.

Company Information:
- Company: Dorsch Palestine
- Focus: Sustainability, environment, and healthy cooking
- Vision: Leading supplier of pots and pans with focus on sustainability
- Mission: Provide innovative kitchen appliances for healthy meal preparation
- Standards: LFGB German Standards certified
- Safety: PTFE & PFOA Free products
- Materials: Ceramic coated aluminum, stainless steel
- Warranty: 2 years standard, Lifetime for selected series
- Locations: Palestine (Nablus), Turkey (Istanbul), Denmark (Bagsværd), Australia (Craigieburn)

Product Collections:
1. Premium Cookware - Ceramic coated aluminum, LFGB certified
2. GoPress Series - Pressure cookers with lifetime warranty
3. Lifetime Series - Premium quality with lifetime guarantee
4. Kitchen Accessories - Complete range of kitchen tools

Key Features:
- All products are LFGB certified
- PTFE & PFOA free non-stick coating
- Dishwasher safe
- Induction compatible
- Oven safe (selected models up to 220°C)
- Eco-friendly and recyclable materials

Contact Information:
- Palestine: +972 59 900 0000
- Turkey: +90 212 659 86 87
- Denmark: +45 305 444 55
- Australia: +61 4222 96 244
- Email: info@dorsch-palestine.com

Instructions:
1. Be friendly, professional, and helpful
2. Provide accurate product information
3. Mention LFGB certification and safety features
4. Recommend products based on customer needs
5. Always be positive about product quality
6. If you don't know something, suggest contacting customer service
7. Keep responses concise (2-3 paragraphs max)
8. Use emojis sparingly for friendliness`;

// Chat History
let chatHistory = [];

// Toggle Chatbot
function toggleChatbot() {
    const button = document.querySelector('.chatbot-button');
    const window = document.getElementById('chatbotWindow');

    button.classList.toggle('active');
    window.classList.toggle('active');

    // Focus input when opened
    if (window.classList.contains('active')) {
        document.getElementById('chatbotInput').focus();
    }
}

// Handle Key Press
function handleKeyPress(event) {
    if (event.key === 'Enter') {
        sendMessage();
    }
}

// Send Quick Message
function sendQuickMessage(message) {
    document.getElementById('chatbotInput').value = message;
    sendMessage();
}

// Send Message
async function sendMessage() {
    const input = document.getElementById('chatbotInput');
    const message = input.value.trim();

    if (!message) return;

    // Clear input
    input.value = '';

    // Add user message to chat
    addMessage(message, 'user');

    // Show typing indicator
    showTyping();

    // Disable send button
    document.getElementById('sendButton').disabled = true;

    // Add to chat history
    chatHistory.push({
        role: 'user',
        content: message
    });

    try {
        // Call OpenAI API
        const response = await fetch('https://api.openai.com/v1/chat/completions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${OPENAI_API_KEY}`
            },
            body: JSON.stringify({
                model: 'gpt-4',
                messages: [
                    { role: 'system', content: SYSTEM_PROMPT },
                    ...chatHistory
                ],
                temperature: 0.7,
                max_tokens: 500
            })
        });

        const data = await response.json();

        if (data.choices && data.choices[0]) {
            const botMessage = data.choices[0].message.content;

            // Add to chat history
            chatHistory.push({
                role: 'assistant',
                content: botMessage
            });

            // Hide typing and show response
            hideTyping();
            addMessage(botMessage, 'bot');
        } else {
            throw new Error('Invalid response from API');
        }

    } catch (error) {
        console.error('Error:', error);
        hideTyping();
        addMessage('Sorry, I encountered an error. Please try again or contact us at info@dorsch-palestine.com', 'bot');
    }

    // Enable send button
    document.getElementById('sendButton').disabled = false;
}

// Add Message to Chat
function addMessage(text, sender) {
    const chatBody = document.getElementById('chatbotBody');
    const messageDiv = document.createElement('div');
    messageDiv.className = `chatbot-message ${sender}`;

    if (sender === 'bot') {
        messageDiv.innerHTML = `
            <div class="message-avatar">
                <i class="fas fa-robot"></i>
            </div>
            <div class="message-content">${text}</div>
        `;
    } else {
        messageDiv.innerHTML = `
            <div class="message-content">${text}</div>
        `;
    }

    // Insert before typing indicator
    const typingMessage = chatBody.lastElementChild;
    chatBody.insertBefore(messageDiv, typingMessage);

    // Scroll to bottom
    chatBody.scrollTop = chatBody.scrollHeight;
}

// Show Typing Indicator
function showTyping() {
    document.getElementById('typingIndicator').classList.add('active');
    const chatBody = document.getElementById('chatbotBody');
    chatBody.scrollTop = chatBody.scrollHeight;
}

// Hide Typing Indicator
function hideTyping() {
    document.getElementById('typingIndicator').classList.remove('active');
}

// Keep chat history limited to last 10 messages
function limitChatHistory() {
    if (chatHistory.length > 10) {
        chatHistory = chatHistory.slice(-10);
    }
}

// Call limitChatHistory after each message
setInterval(limitChatHistory, 5000);
</script>
    
<!-- ========== ضيف هذا JavaScript قبل </body> ========== -->
<script>
// Search Box Functions
function openSearch(e) {
    if(e) e.preventDefault();
    document.getElementById('searchBox').classList.add('active');
    document.getElementById('searchInput').focus();
}

function closeSearch() {
    document.getElementById('searchBox').classList.remove('active');
}

// Mobile Menu Functions
function toggleMobileMenu() {
    const menu = document.getElementById('mobileMenu');
    const btn = document.querySelector('.btn-menu');
    menu.classList.toggle('active');
    btn.classList.toggle('active');
    document.body.style.overflow = menu.classList.contains('active') ? 'hidden' : '';
}

function closeMobileMenu() {
    document.getElementById('mobileMenu').classList.remove('active');
    const btn = document.querySelector('.btn-menu');
    if(btn) btn.classList.remove('active');
    document.body.style.overflow = '';
}

// Language Switcher
function toggleLanguage() {
    const currentLang = document.getElementById('currentLang');
    if(currentLang) {
        const newLang = currentLang.textContent === 'EN' ? 'AR' : 'EN';
        currentLang.textContent = newLang;
        // هنا ممكن تضيف كود تغيير اللغة الفعلي
        console.log('Language switched to: ' + newLang);
    }
}

// Close on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeSearch();
        closeMobileMenu();
    }
});

// Close search on outside click
const searchBox = document.getElementById('searchBox');
if(searchBox) {
    searchBox.addEventListener('click', function(e) {
        if (e.target === this) {
            closeSearch();
        }
    });
}

// Update Header Scroll
window.addEventListener('scroll', function() {
    const header = document.querySelector('.header-area');
    if (window.scrollY > 50) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
});
</script>