<?php
/**
 * Helper Functions
 */

function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getCurrentUser() {
    return $_SESSION['user'] ?? null;
}

function translate($item, $field) {
    global $current_lang;
    $key = $field . '_' . ($current_lang === 'ar' ? 'ar' : 'en');
    return $item[$key] ?? $item[$field . '_en'] ?? '';
}

function getStatusColor($status) {
    switch($status) {
        case 'pending':
            return 'warning';
        case 'processing':
            return 'info';
        case 'shipped':
            return 'primary';
        case 'delivered':
        case 'completed':
            return 'success';
        case 'cancelled':
            return 'danger';
        default:
            return 'secondary';
    }
}

if (!function_exists('logAdminActivity')) {
    function logAdminActivity($admin_id, $action, $description) {
        global $db;
        try {
            $db->query(
                "INSERT INTO admin_activity_logs (admin_id, action, description, ip_address, user_agent, created_at) VALUES (?, ?, ?, ?, ?, NOW())",
                [$admin_id, $action, $description, $_SERVER['REMOTE_ADDR'] ?? '', $_SERVER['HTTP_USER_AGENT'] ?? '']
            );
        } catch (Exception $e) {
            // Silent fail
        }
    }
}
