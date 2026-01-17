<?php
ob_start();
?>
<div class="email-header">
    <h1>New Contact Message</h1>
    <p>Someone submitted the contact form</p>
</div>
<div class="email-body">
    <h3>Contact Details</h3>
    <div class="order-summary">
        <div class="order-item">
            <strong>Name:</strong>
            <span><?php echo htmlspecialchars($contact['name']); ?></span>
        </div>
        <div class="order-item">
            <strong>Email:</strong>
            <span><?php echo htmlspecialchars($contact['email']); ?></span>
        </div>
        <div class="order-item">
            <strong>Subject:</strong>
            <span><?php echo htmlspecialchars($contact['subject']); ?></span>
        </div>
    </div>
    
    <h3 style="margin: 30px 0 15px;">Message</h3>
    <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; white-space: pre-wrap;"><?php echo htmlspecialchars($contact['message']); ?></div>
    
    <p style="margin-top: 30px; font-size: 14px; color: #666;">
        Reply to: <a href="mailto:<?php echo htmlspecialchars($contact['email']); ?>" style="color: #2563eb;"><?php echo htmlspecialchars($contact['email']); ?></a>
    </p>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
