<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get current language
$current_lang = $_SESSION['lang'] ?? 'en';
?>
<!DOCTYPE html>
<html lang="<?php echo $current_lang; ?>" dir="<?php echo isRTL() ? 'rtl' : 'ltr'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ($page_title ?? 'Home') . ' - Dorsch Palestine - Premium Kitchen Accessories'; ?></title>
    <meta name="description" content="Leading supplier of premium kitchen appliances focusing on sustainability and healthy cooking.">

    <!-- Favicon -->
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">

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
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

    <!-- Preloader -->
    <div class="preloader-wrap">
        <div class="preloader">
            <span class="dot"></span>
        </div>
    </div>

    <!-- Top Bar -->
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
                            <span id="currentLang"><?php echo strtoupper($current_lang); ?></span>
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
            <div class="row align-items-center">
                <div class="col-3 col-lg-2">
                    <div class="header-logo">
                        <a href="/index.php" class="header-logo-text">
                            <img src="/images/logo.png" alt="Dorsch Palestine">
                        </a>
                    </div>
                </div>
                <div class="col-9 col-lg-10">
                    <div class="d-flex align-items-center justify-content-end gap-4">
                        <nav class="header-navigation">
                            <ul class="main-menu">
                                <li><a href="/index.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>"><?php echo t('home', 'HOME'); ?></a></li>
                                <li><a href="/products.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'products.php' ? 'active' : ''; ?>"><?php echo t('products', 'PRODUCTS'); ?></a></li>
                                <li><a href="/index.php#collections"><?php echo t('collections', 'COLLECTIONS'); ?></a></li>
                                <li><a href="/about.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>"><?php echo t('about', 'ABOUT'); ?></a></li>
                                <li><a href="/contact.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>"><?php echo t('contact', 'CONTACT'); ?></a></li>
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
                                <a href="/wishlist.php">
                                    <i class="far fa-heart"></i>
                                    <span class="action-count wishlist-count"><?php echo getWishlistCount(); ?></span>
                                </a>
                            </div>

                            <!-- Compare -->
                            <div class="header-action-item">
                                <a href="/compare.php">
                                    <i class="fas fa-exchange-alt"></i>
                                    <span class="action-count compare-count"><?php echo getCompareCount(); ?></span>
                                </a>
                            </div>

                            <!-- Cart -->
                            <div class="header-action-item">
                                <a href="/cart.php">
                                    <i class="fas fa-shopping-cart"></i>
                                    <span class="action-count cart-count"><?php echo getCartCount(); ?></span>
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

    <!-- Search Box Overlay -->
    <div class="search-box-wrapper" id="searchBox">
        <button class="search-close" onclick="closeSearch()">
            <i class="fas fa-times"></i>
        </button>
        <div class="search-box-inner">
            <form action="/products.php" method="GET">
                <input type="text" name="search" placeholder="<?php echo t('search_products', 'Search for products...'); ?>" autocomplete="off" id="searchInput">
                <button type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay" id="mobileMenu">
        <div class="mobile-menu-header">
            <div class="header-logo">
                <img src="/images/logo.png" alt="Dorsch Palestine" style="height: 45px;">
            </div>
            <button class="mobile-menu-close" onclick="closeMobileMenu()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="mobile-menu-content">
            <nav class="mobile-menu-nav">
                <ul>
                    <li><a href="/index.php"><?php echo t('home', 'HOME'); ?> <i class="fas fa-chevron-right"></i></a></li>
                    <li><a href="/products.php"><?php echo t('products', 'PRODUCTS'); ?> <i class="fas fa-chevron-right"></i></a></li>
                    <li><a href="/index.php#collections"><?php echo t('collections', 'COLLECTIONS'); ?> <i class="fas fa-chevron-right"></i></a></li>
                    <li><a href="/about.php"><?php echo t('about', 'ABOUT'); ?> <i class="fas fa-chevron-right"></i></a></li>
                    <li><a href="/contact.php"><?php echo t('contact', 'CONTACT'); ?> <i class="fas fa-chevron-right"></i></a></li>
                </ul>
            </nav>

            <div class="mobile-menu-actions">
                <a href="/wishlist.php" class="mobile-action-item">
                    <div class="mobile-action-left">
                        <div class="mobile-action-icon">
                            <i class="far fa-heart" style="color: #4A90E2;"></i>
                        </div>
                        <span class="mobile-action-text"><?php echo t('wishlist', 'My Wishlist'); ?></span>
                    </div>
                    <div class="mobile-action-badge wishlist-count"><?php echo getWishlistCount(); ?></div>
                </a>

                <a href="/compare.php" class="mobile-action-item">
                    <div class="mobile-action-left">
                        <div class="mobile-action-icon">
                            <i class="fas fa-exchange-alt" style="color: #4A90E2;"></i>
                        </div>
                        <span class="mobile-action-text"><?php echo t('compare', 'Compare'); ?></span>
                    </div>
                    <div class="mobile-action-badge compare-count"><?php echo getCompareCount(); ?></div>
                </a>

                <a href="/cart.php" class="mobile-action-item">
                    <div class="mobile-action-left">
                        <div class="mobile-action-icon">
                            <i class="fas fa-shopping-cart" style="color: #4A90E2;"></i>
                        </div>
                        <span class="mobile-action-text"><?php echo t('cart', 'Shopping Cart'); ?></span>
                    </div>
                    <div class="mobile-action-badge cart-count"><?php echo getCartCount(); ?></div>
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

    <!-- Floating Action Buttons -->
    <div class="floating-buttons">
        <!-- WhatsApp Button -->
        <a href="https://wa.me/972568000068" target="_blank" class="float-btn whatsapp-btn" title="WhatsApp">
            <i class="fab fa-whatsapp"></i>
            <span class="tooltip-text"><?php echo t('chat_whatsapp', 'Chat on WhatsApp'); ?></span>
        </a>

        <!-- AI Chatbot Button -->
        <button class="float-btn ai-bot-btn" onclick="toggleChatbot()" title="AI Assistant">
            <i class="fas fa-robot"></i>
            <span class="tooltip-text"><?php echo t('ai_assistant', 'AI Assistant'); ?></span>
        </button>
    </div>

    <!-- AI Chatbot Widget -->
    <button class="chatbot-button" onclick="toggleChatbot()">
        <i class="fas fa-comments"></i>
        <i class="fas fa-times"></i>
    </button>

    <div class="chatbot-window" id="chatbotWindow">
        <div class="chatbot-header">
            <div class="chatbot-avatar">
                <i class="fas fa-robot"></i>
            </div>
            <div class="chatbot-info">
                <h4><?php echo t('dorsch_assistant', 'Dorsch Assistant'); ?></h4>
                <p><?php echo t('ask_about_products', 'Ask me about our products!'); ?></p>
            </div>
        </div>

        <div class="chatbot-body" id="chatbotBody">
            <div class="chatbot-message bot">
                <div class="message-avatar">
                    <i class="fas fa-robot"></i>
                </div>
                <div>
                    <div class="message-content">
                        <?php echo t('chatbot_welcome', 'Hello! 👋 I\'m Dorsch Assistant. How can I help you today?'); ?>
                    </div>
                    <div class="quick-suggestions">
                        <button class="suggestion-btn" onclick="sendQuickMessage('Tell me about Premium Cookware')"><?php echo t('premium_cookware', 'Premium Cookware'); ?></button>
                        <button class="suggestion-btn" onclick="sendQuickMessage('What is LFGB certified?')"><?php echo t('lfgb_certified', 'LFGB Certified'); ?></button>
                        <button class="suggestion-btn" onclick="sendQuickMessage('Show me pressure cookers')"><?php echo t('pressure_cookers', 'Pressure Cookers'); ?></button>
                        <button class="suggestion-btn" onclick="sendQuickMessage('Warranty information')"><?php echo t('warranty_info', 'Warranty Info'); ?></button>
                    </div>
                </div>
            </div>

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

        <div class="chatbot-footer">
            <input type="text" class="chatbot-input" id="chatbotInput" placeholder="<?php echo t('type_message', 'Type your message...'); ?>" onkeypress="handleKeyPress(event)">
            <button class="chatbot-send" onclick="sendMessage()" id="sendButton">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>

    <main>