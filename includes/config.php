<?php
// Dorsh Palestine Configuration File
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'dorsh_palestine');

// Site Configuration
define('SITE_URL', 'http://localhost/dorsh_palestine');
define('ADMIN_URL', SITE_URL . '/admin');
define('SITE_NAME_EN', 'Dorsh Palestine');
define('SITE_NAME_AR', 'دورش فلسطين');

// Paths
define('ROOT_PATH', dirname(__DIR__));
define('INCLUDES_PATH', ROOT_PATH . '/includes');
define('UPLOAD_PATH', ROOT_PATH . '/uploads');
define('IMAGES_PATH', ROOT_PATH . '/images');

// Upload URLs
define('UPLOAD_URL', SITE_URL . '/uploads');
define('IMAGES_URL', SITE_URL . '/images');

// Session Configuration
define('SESSION_LIFETIME', 86400); // 24 hours

// Pagination
define('ITEMS_PER_PAGE', 20);
define('PRODUCTS_PER_PAGE', 12);

// OpenAI Configuration
define('OPENAI_API_KEY', ''); // To be set in admin settings
define('OPENAI_MODEL', 'gpt-4-turbo-preview');
define('OPENAI_TEMPERATURE', 0.7);

// WhatsApp Configuration
define('WHATSAPP_ENABLED', true);
define('WHATSAPP_NUMBER', '+970XXXXXXXXX'); // To be set in admin settings

// Email Configuration
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'info@dorsh.ps');
define('SMTP_PASS', '');
define('SMTP_FROM_EMAIL', 'info@dorsh.ps');
define('SMTP_FROM_NAME', 'Dorsh Palestine');

// Security
define('ENCRYPTION_KEY', 'your-secret-encryption-key-change-this');
define('PASSWORD_MIN_LENGTH', 8);

// Currency
define('CURRENCY', 'USD');
define('CURRENCY_SYMBOL', '$');
define('CURRENCY_POSITION', 'left'); // left or right

// Timezone
date_default_timezone_set('Asia/Hebron');

// Error Reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Language Detection
if (!isset($_SESSION['lang'])) {
    // Detect browser language or use default
    $browser_lang = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : 'en';
    $_SESSION['lang'] = in_array($browser_lang, ['ar', 'en']) ? $browser_lang : 'en';
}

// Set current language
define('CURRENT_LANG', $_SESSION['lang']);
define('IS_RTL', CURRENT_LANG === 'ar');
?>