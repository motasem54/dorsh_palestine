<?php
/**
 * Language System
 * Handles bilingual support (Arabic & English)
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Default language
define('DEFAULT_LANG', 'ar');

// Available languages
$available_languages = ['ar', 'en'];

// Get current language from session, cookie, or browser
function getCurrentLanguage() {
    global $available_languages;
    
    // Check if language is set in URL
    if (isset($_GET['lang']) && in_array($_GET['lang'], $available_languages)) {
        $_SESSION['lang'] = $_GET['lang'];
        setcookie('lang', $_GET['lang'], time() + (86400 * 365), '/');
        return $_GET['lang'];
    }
    
    // Check session
    if (isset($_SESSION['lang']) && in_array($_SESSION['lang'], $available_languages)) {
        return $_SESSION['lang'];
    }
    
    // Check cookie
    if (isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], $available_languages)) {
        $_SESSION['lang'] = $_COOKIE['lang'];
        return $_COOKIE['lang'];
    }
    
    // Check browser language
    if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
        $browser_lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        if (in_array($browser_lang, $available_languages)) {
            $_SESSION['lang'] = $browser_lang;
            return $browser_lang;
        }
    }
    
    // Return default
    $_SESSION['lang'] = DEFAULT_LANG;
    return DEFAULT_LANG;
}

// Set current language
$current_lang = getCurrentLanguage();

// Load language file
$lang = require_once __DIR__ . '/../lang/' . $current_lang . '.php';

// Translation function
function t($key, $default = '') {
    global $lang;
    return isset($lang[$key]) ? $lang[$key] : ($default ?: $key);
}

// Get text direction based on language
function getTextDirection() {
    global $current_lang;
    return $current_lang === 'ar' ? 'rtl' : 'ltr';
}

// Get opposite language
function getOtherLanguage() {
    global $current_lang;
    return $current_lang === 'ar' ? 'en' : 'ar';
}

// Generate language switch URL
function getLanguageSwitchUrl() {
    $other_lang = getOtherLanguage();
    $current_url = $_SERVER['REQUEST_URI'];
    
    // Remove existing lang parameter
    $current_url = preg_replace('/[?&]lang=[^&]*/', '', $current_url);
    
    // Add new lang parameter
    $separator = strpos($current_url, '?') !== false ? '&' : '?';
    return $current_url . $separator . 'lang=' . $other_lang;
}

// Get language name
function getLanguageName($lang_code) {
    $names = [
        'ar' => 'العربية',
        'en' => 'English'
    ];
    return $names[$lang_code] ?? $lang_code;
}

// Format date according to language
function formatDate($date, $format = 'long') {
    global $current_lang;
    
    $timestamp = is_numeric($date) ? $date : strtotime($date);
    
    if ($current_lang === 'ar') {
        if ($format === 'long') {
            return date('d/m/Y - h:i A', $timestamp);
        } else {
            return date('d/m/Y', $timestamp);
        }
    } else {
        if ($format === 'long') {
            return date('F d, Y - h:i A', $timestamp);
        } else {
            return date('M d, Y', $timestamp);
        }
    }
}

// Format price according to language
function formatPrice($price, $currency = 'USD') {
    global $current_lang;
    
    $formatted_price = number_format($price, 2);
    
    if ($current_lang === 'ar') {
        return $formatted_price . ' ' . getCurrencySymbol($currency);
    } else {
        return getCurrencySymbol($currency) . $formatted_price;
    }
}

// Get currency symbol
function getCurrencySymbol($currency = 'USD') {
    $symbols = [
        'USD' => '$',
        'EUR' => '€',
        'ILS' => '₪',
        'JOD' => 'د.أ',
        'EGP' => 'ج.م'
    ];
    return $symbols[$currency] ?? $currency;
}

// Format number according to language
function formatNumber($number, $decimals = 0) {
    global $current_lang;
    
    if ($current_lang === 'ar') {
        // Arabic uses Arabic-Indic numerals in some contexts
        return number_format($number, $decimals, '.', ',');
    } else {
        return number_format($number, $decimals, '.', ',');
    }
}
