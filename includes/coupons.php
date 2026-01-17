<?php
/**
 * Discount Coupons Functions
 */

function validateCoupon($code, $user_id = null, $cart_total = 0) {
    global $db;
    
    $coupon = $db->query(
        "SELECT * FROM coupons WHERE code = ? AND status = 'active'",
        [strtoupper($code)]
    )->fetch();
    
    if (!$coupon) {
        return ['valid' => false, 'message' => 'Invalid coupon code'];
    }
    
    // Check expiry date
    if ($coupon['expires_at'] && strtotime($coupon['expires_at']) < time()) {
        return ['valid' => false, 'message' => 'Coupon has expired'];
    }
    
    // Check usage limit
    if ($coupon['usage_limit'] && $coupon['times_used'] >= $coupon['usage_limit']) {
        return ['valid' => false, 'message' => 'Coupon usage limit reached'];
    }
    
    // Check minimum order amount
    if ($coupon['min_order_amount'] && $cart_total < $coupon['min_order_amount']) {
        return ['valid' => false, 'message' => 'Minimum order amount not met. Required: $' . $coupon['min_order_amount']];
    }
    
    // Check user-specific coupon
    if ($coupon['user_id'] && $coupon['user_id'] != $user_id) {
        return ['valid' => false, 'message' => 'This coupon is not valid for your account'];
    }
    
    // Check if user already used this coupon
    if ($user_id) {
        $used = $db->query(
            "SELECT COUNT(*) as count FROM orders WHERE user_id = ? AND coupon_code = ?",
            [$user_id, $code]
        )->fetch();
        
        if ($used['count'] > 0 && !$coupon['is_reusable']) {
            return ['valid' => false, 'message' => 'You have already used this coupon'];
        }
    }
    
    return ['valid' => true, 'coupon' => $coupon];
}

function calculateDiscount($coupon, $cart_total) {
    if ($coupon['type'] === 'percentage') {
        $discount = ($cart_total * $coupon['value']) / 100;
        
        // Apply max discount if set
        if ($coupon['max_discount'] && $discount > $coupon['max_discount']) {
            $discount = $coupon['max_discount'];
        }
    } else {
        // Fixed amount
        $discount = $coupon['value'];
        
        // Discount cannot exceed cart total
        if ($discount > $cart_total) {
            $discount = $cart_total;
        }
    }
    
    return round($discount, 2);
}

function applyCoupon($code, $user_id = null, $cart_total = 0) {
    $validation = validateCoupon($code, $user_id, $cart_total);
    
    if (!$validation['valid']) {
        return $validation;
    }
    
    $coupon = $validation['coupon'];
    $discount = calculateDiscount($coupon, $cart_total);
    
    return [
        'valid' => true,
        'coupon' => $coupon,
        'discount' => $discount,
        'new_total' => $cart_total - $discount
    ];
}

function incrementCouponUsage($code) {
    global $db;
    $db->query(
        "UPDATE coupons SET times_used = times_used + 1 WHERE code = ?",
        [strtoupper($code)]
    );
}
