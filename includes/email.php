<?php
/**
 * Email Functions using PHPMailer
 */

class EmailService {
    private $from_email;
    private $from_name;
    private $smtp_host;
    private $smtp_port;
    private $smtp_user;
    private $smtp_pass;
    
    public function __construct() {
        $this->from_email = EMAIL_FROM;
        $this->from_name = EMAIL_FROM_NAME;
        $this->smtp_host = SMTP_HOST;
        $this->smtp_port = SMTP_PORT;
        $this->smtp_user = SMTP_USER;
        $this->smtp_pass = SMTP_PASS;
    }
    
    /**
     * Send email using mail() function (fallback)
     */
    private function sendSimple($to, $subject, $html_body) {
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: {$this->from_name} <{$this->from_email}>" . "\r\n";
        
        return mail($to, $subject, $html_body, $headers);
    }
    
    /**
     * Send email
     */
    public function send($to, $subject, $body, $is_html = true) {
        // For now, use simple mail() - can be upgraded to PHPMailer/SMTP later
        return $this->sendSimple($to, $subject, $body);
    }
    
    /**
     * Send order confirmation email
     */
    public function sendOrderConfirmation($order) {
        global $db;
        
        $subject = "Order Confirmation - #{$order['order_number']}";
        
        // Get order items
        $items = $db->query(
            "SELECT * FROM order_items WHERE order_id = ?",
            [$order['id']]
        )->fetchAll();
        
        $body = $this->renderTemplate('order_confirmation', [
            'order' => $order,
            'items' => $items
        ]);
        
        return $this->send($order['email'], $subject, $body);
    }
    
    /**
     * Send order status update email
     */
    public function sendOrderStatusUpdate($order, $old_status, $new_status) {
        $subject = "Order Status Update - #{$order['order_number']}";
        
        $body = $this->renderTemplate('order_status_update', [
            'order' => $order,
            'old_status' => $old_status,
            'new_status' => $new_status
        ]);
        
        return $this->send($order['email'], $subject, $body);
    }
    
    /**
     * Send welcome email to new user
     */
    public function sendWelcomeEmail($user) {
        $subject = "Welcome to Dorsh Palestine!";
        
        $body = $this->renderTemplate('welcome', [
            'user' => $user
        ]);
        
        return $this->send($user['email'], $subject, $body);
    }
    
    /**
     * Send password reset email
     */
    public function sendPasswordReset($user, $reset_token) {
        $subject = "Reset Your Password - Dorsh Palestine";
        
        $reset_link = SITE_URL . "/reset-password.php?token={$reset_token}";
        
        $body = $this->renderTemplate('password_reset', [
            'user' => $user,
            'reset_link' => $reset_link
        ]);
        
        return $this->send($user['email'], $subject, $body);
    }
    
    /**
     * Send contact form notification to admin
     */
    public function sendContactNotification($contact) {
        $subject = "New Contact Message - {$contact['subject']}";
        
        $body = $this->renderTemplate('contact_notification', [
            'contact' => $contact
        ]);
        
        return $this->send($this->from_email, $subject, $body);
    }
    
    /**
     * Render email template
     */
    private function renderTemplate($template, $data = []) {
        extract($data);
        ob_start();
        include __DIR__ . "/../email-templates/{$template}.php";
        return ob_get_clean();
    }
}

// Global helper function
function sendEmail($to, $subject, $body) {
    $email = new EmailService();
    return $email->send($to, $subject, $body);
}
