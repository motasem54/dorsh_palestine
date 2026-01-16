<?php
/**
 * Language Management System
 * Handles bilingual support (Arabic & English)
 */

class Language {
    private static $current_lang = 'en';
    private static $translations = [];
    private static $supported_languages = ['en', 'ar'];
    
    /**
     * Initialize language system
     */
    public static function init() {
        // Check if language is set in session
        if (isset($_SESSION['language']) && in_array($_SESSION['language'], self::$supported_languages)) {
            self::$current_lang = $_SESSION['language'];
        } 
        // Check cookie
        elseif (isset($_COOKIE['language']) && in_array($_COOKIE['language'], self::$supported_languages)) {
            self::$current_lang = $_COOKIE['language'];
            $_SESSION['language'] = self::$current_lang;
        }
        // Detect browser language
        else {
            $browser_lang = self::detectBrowserLanguage();
            self::$current_lang = $browser_lang;
            $_SESSION['language'] = self::$current_lang;
        }
        
        // Load translations
        self::loadTranslations();
    }
    
    /**
     * Load translation file
     */
    private static function loadTranslations() {
        $file = __DIR__ . '/../lang/' . self::$current_lang . '.php';
        if (file_exists($file)) {
            self::$translations = require $file;
        }
    }
    
    /**
     * Get translation
     * @param string $key
     * @param array $replace
     * @return string
     */
    public static function get($key, $replace = []) {
        $translation = self::$translations[$key] ?? $key;
        
        // Replace placeholders
        foreach ($replace as $placeholder => $value) {
            $translation = str_replace(':' . $placeholder, $value, $translation);
        }
        
        return $translation;
    }
    
    /**
     * Alias for get()
     */
    public static function trans($key, $replace = []) {
        return self::get($key, $replace);
    }
    
    /**
     * Set current language
     * @param string $lang
     */
    public static function setLanguage($lang) {
        if (in_array($lang, self::$supported_languages)) {
            self::$current_lang = $lang;
            $_SESSION['language'] = $lang;
            setcookie('language', $lang, time() + (86400 * 365), '/'); // 1 year
            self::loadTranslations();
        }
    }
    
    /**
     * Get current language
     * @return string
     */
    public static function getCurrentLanguage() {
        return self::$current_lang;
    }
    
    /**
     * Check if current language is RTL
     * @return bool
     */
    public static function isRTL() {
        return self::$current_lang === 'ar';
    }
    
    /**
     * Get text direction
     * @return string
     */
    public static function getDirection() {
        return self::isRTL() ? 'rtl' : 'ltr';
    }
    
    /**
     * Detect browser language
     * @return string
     */
    private static function detectBrowserLanguage() {
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $browser_lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            if (in_array($browser_lang, self::$supported_languages)) {
                return $browser_lang;
            }
        }
        return 'en'; // Default
    }
    
    /**
     * Get all supported languages
     * @return array
     */
    public static function getSupportedLanguages() {
        return [
            'en' => 'English',
            'ar' => 'العربية'
        ];
    }
    
    /**
     * Get opposite language (for language switcher)
     * @return string
     */
    public static function getOppositeLanguage() {
        return self::$current_lang === 'en' ? 'ar' : 'en';
    }
}

/**
 * Helper function for translations
 * @param string $key
 * @param array $replace
 * @return string
 */
function __($key, $replace = []) {
    return Language::get($key, $replace);
}

/**
 * Helper function for translations with echo
 * @param string $key
 * @param array $replace
 */
function _e($key, $replace = []) {
    echo Language::get($key, $replace);
}
