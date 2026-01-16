<?php
/**
 * Utility Functions
 * Dorsh Palestine E-Commerce
 */

require_once 'config.php';
require_once 'database.php';

// ============================================
// Security Functions
// ============================================

function sanitize($data) {
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            $data[$key] = sanitize($value);
        }
    } else {
        $data = htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
    }
    return $data;
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

function generateToken($length = 32) {
    return bin2hex(random_bytes($length));
}

function csrfToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = generateToken();
    }
    return $_SESSION['csrf_token'];
}

function verifyCsrfToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// ============================================
// User Functions
// ============================================

function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin';
}

function isStaff() {
    return isset($_SESSION['user_type']) && in_array($_SESSION['user_type'], ['admin', 'staff']);
}

function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    return fetchOne("SELECT * FROM users WHERE id = ?", [$_SESSION['user_id']]);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ' . SITE_URL . '/login.php');
        exit;
    }
}

function requireAdmin() {
    if (!isAdmin()) {
        header('Location: ' . SITE_URL);
        exit;
    }
}

// ============================================
// Language Functions
// ============================================

function lang($key, $lang = null) {
    static $translations = [];
    
    $lang = $lang ?: CURRENT_LANG;
    
    if (!isset($translations[$lang])) {
        $lang_file = INCLUDES_PATH . "/../lang/{$lang}.php";
        if (file_exists($lang_file)) {
            $translations[$lang] = include $lang_file;
        } else {
            $translations[$lang] = [];
        }
    }
    
    return $translations[$lang][$key] ?? $key;
}

function getLangField($field_name) {
    return $field_name . '_' . CURRENT_LANG;
}

function switchLanguage($lang) {
    if (in_array($lang, ['ar', 'en'])) {
        $_SESSION['lang'] = $lang;
    }
}

// ============================================
// URL and Routing Functions
// ============================================

function url($path = '') {
    return SITE_URL . '/' . ltrim($path, '/');
}

function adminUrl($path = '') {
    return ADMIN_URL . '/' . ltrim($path, '/');
}

function redirect($url) {
    header('Location: ' . $url);
    exit;
}

function currentUrl() {
    return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

// ============================================
// Message/Alert Functions
// ============================================

function setMessage($message, $type = 'success') {
    $_SESSION['message'] = [
        'text' => $message,
        'type' => $type
    ];
}

function getMessage() {
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        unset($_SESSION['message']);
        return $message;
    }
    return null;
}

function showMessage() {
    $message = getMessage();
    if ($message) {
        $type = $message['type'];
        $text = $message['text'];
        echo "<div class='alert alert-{$type}' role='alert'>{$text}</div>";
    }
}

// ============================================
// Format Functions
// ============================================

function formatPrice($price) {
    $formatted = number_format($price, 2);
    if (CURRENCY_POSITION === 'left') {
        return CURRENCY_SYMBOL . $formatted;
    }
    return $formatted . ' ' . CURRENCY;
}

function formatDate($date, $format = 'Y-m-d H:i:s') {
    return date($format, strtotime($date));
}

function timeAgo($datetime) {
    $timestamp = strtotime($datetime);
    $diff = time() - $timestamp;
    
    if ($diff < 60) {
        return lang('just_now');
    } elseif ($diff < 3600) {
        $minutes = floor($diff / 60);
        return $minutes . ' ' . lang('minutes_ago');
    } elseif ($diff < 86400) {
        $hours = floor($diff / 3600);
        return $hours . ' ' . lang('hours_ago');
    } elseif ($diff < 604800) {
        $days = floor($diff / 86400);
        return $days . ' ' . lang('days_ago');
    } else {
        return formatDate($datetime, 'd M Y');
    }
}

function generateSlug($text) {
    $text = preg_replace('/[^\w\s-]/u', '', $text);
    $text = preg_replace('/[\s_]+/', '-', $text);
    $text = preg_replace('/[-]+/', '-', $text);
    return strtolower(trim($text, '-'));
}

// ============================================
// File Upload Functions
// ============================================

function uploadImage($file, $directory = 'products') {
    $upload_dir = UPLOAD_PATH . '/' . $directory;
    
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    
    if (!in_array($file_extension, $allowed_extensions)) {
        return ['success' => false, 'message' => 'Invalid file type'];
    }
    
    if ($file['size'] > 5 * 1024 * 1024) { // 5MB
        return ['success' => false, 'message' => 'File too large'];
    }
    
    $new_filename = uniqid() . '_' . time() . '.' . $file_extension;
    $upload_path = $upload_dir . '/' . $new_filename;
    
    if (move_uploaded_file($file['tmp_name'], $upload_path)) {
        return [
            'success' => true,
            'filename' => $new_filename,
            'path' => $upload_path,
            'url' => UPLOAD_URL . '/' . $directory . '/' . $new_filename
        ];
    }
    
    return ['success' => false, 'message' => 'Upload failed'];
}

function deleteFile($filepath) {
    if (file_exists($filepath)) {
        return unlink($filepath);
    }
    return false;
}

// ============================================
// Cart Functions
// ============================================

function getCartCount() {
    if (isLoggedIn()) {
        return countRows('cart', 'user_id = ?', [$_SESSION['user_id']]);
    } else {
        $session_id = session_id();
        return countRows('cart', 'session_id = ?', [$session_id]);
    }
}

function getWishlistCount() {
    if (isLoggedIn()) {
        return countRows('wishlist', 'user_id = ?', [$_SESSION['user_id']]);
    }
    return 0;
}

// ============================================
// Product Functions
// ============================================

function getProduct($id) {
    return fetchOne("SELECT * FROM products WHERE id = ? AND is_active = 1", [$id]);
}

function getProductBySlug($slug) {
    return fetchOne("SELECT * FROM products WHERE slug = ? AND is_active = 1", [$slug]);
}

function getProducts($limit = 12, $offset = 0, $where = '', $params = []) {
    $sql = "SELECT * FROM products WHERE is_active = 1";
    if ($where) {
        $sql .= " AND {$where}";
    }
    $sql .= " ORDER BY created_at DESC LIMIT {$limit} OFFSET {$offset}";
    return fetchAll($sql, $params);
}

// ============================================
// Activity Logging
// ============================================

function logActivity($action, $table_name = null, $record_id = null) {
    $user_id = $_SESSION['user_id'] ?? null;
    $ip_address = $_SERVER['REMOTE_ADDR'] ?? null;
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? null;
    
    $sql = "INSERT INTO activity_logs (user_id, action, table_name, record_id, ip_address, user_agent) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
    query($sql, [$user_id, $action, $table_name, $record_id, $ip_address, $user_agent]);
}

// ============================================
// Settings Functions
// ============================================

function getSetting($key, $default = null) {
    $setting = fetchOne("SELECT setting_value FROM site_settings WHERE setting_key = ?", [$key]);
    return $setting ? $setting['setting_value'] : $default;
}

function updateSetting($key, $value) {
    $sql = "INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?) 
            ON DUPLICATE KEY UPDATE setting_value = ?";
    return query($sql, [$key, $value, $value]);
}

// ============================================
// Order Functions
// ============================================

function generateOrderNumber() {
    return 'DOR' . date('Ymd') . rand(1000, 9999);
}
?>