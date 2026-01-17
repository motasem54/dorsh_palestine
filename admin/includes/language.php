<?php
/**
 * Admin Language System
 */

// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get current language
$admin_lang = $_SESSION['admin_lang'] ?? 'en';

// Switch language if requested
if (isset($_GET['admin_lang'])) {
    $requested_lang = $_GET['admin_lang'];
    if (in_array($requested_lang, ['en', 'ar'])) {
        $_SESSION['admin_lang'] = $requested_lang;
        $admin_lang = $requested_lang;
        
        // Redirect to remove lang parameter
        $redirect_url = strtok($_SERVER['REQUEST_URI'], '?');
        $query_params = $_GET;
        unset($query_params['admin_lang']);
        if (!empty($query_params)) {
            $redirect_url .= '?' . http_build_query($query_params);
        }
        header('Location: ' . $redirect_url);
        exit;
    }
}

// Load translations
$admin_translations = include __DIR__ . "/../lang/{$admin_lang}.php";

/**
 * Translate admin text
 */
function at($key, $default = null) {
    global $admin_translations;
    return $admin_translations[$key] ?? $default ?? $key;
}

/**
 * Get current admin language
 */
function getAdminLang() {
    global $admin_lang;
    return $admin_lang;
}

/**
 * Check if RTL
 */
function isAdminRTL() {
    return getAdminLang() === 'ar';
}
