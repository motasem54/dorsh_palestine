<?php
/**
 * Configuration File
 */

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'dorsh_palestine');
define('DB_USER', 'root');
define('DB_PASS', '');

// Site Configuration
define('SITE_URL', 'http://localhost:8000');
define('SITE_NAME', 'Dorsh Palestine');

// OpenAI Configuration
define('OPENAI_API_KEY', 'your-openai-api-key-here');
define('OPENAI_MODEL', 'gpt-4');

// Email Configuration
define('EMAIL_FROM', 'info@dorsh-palestine.com');
define('EMAIL_FROM_NAME', 'Dorsh Palestine');

// SMTP Configuration (optional - for production)
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'your-email@gmail.com');
define('SMTP_PASS', 'your-app-password');
define('SMTP_SECURE', 'tls'); // 'tls' or 'ssl'

// Session Configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Set to 1 in production with HTTPS

session_start();

// Timezone
date_default_timezone_set('Asia/Hebron');

// Error Reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);
