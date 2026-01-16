<?php
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/functions.php';
require_once 'includes/language.php';

$page_title = t('contact');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $subject = sanitize($_POST['subject']);
    $message = sanitize($_POST['message']);
    
    // Save to database (contact_messages table)
    $db->query(
        "INSERT INTO contact_messages (name, email, subject, message, created_at) VALUES (?, ?, ?, ?, NOW())",
        [$name, $email, $subject, $message]
    );
    
    $success = t('message_sent_success');
}

include 'includes/header.php';
?>

<div class="contact-page">
    <div class="container">
        <div class="page-header">
            <h1><?php echo t('contact_us'); ?></h1>
            <p><?php echo t('get_in_touch'); ?></p>
        </div>
        
        <div class="contact-layout">
            <div class="contact-info">
                <h2><?php echo t('get_in_touch'); ?></h2>
                <div class="info-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <div>
                        <h4><?php echo t('address'); ?></h4>
                        <p>Nablus, Palestine</p>
                    </div>
                </div>
                <div class="info-item">
                    <i class="fas fa-phone"></i>
                    <div>
                        <h4><?php echo t('phone'); ?></h4>
                        <p>+970 599 123 456</p>
                    </div>
                </div>
                <div class="info-item">
                    <i class="fas fa-envelope"></i>
                    <div>
                        <h4><?php echo t('email'); ?></h4>
                        <p>info@dorsh-palestine.com</p>
                    </div>
                </div>
            </div>
            
            <div class="contact-form-wrapper">
                <?php if (isset($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <form method="POST" class="contact-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label><?php echo t('name'); ?> *</label>
                            <input type="text" name="name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label><?php echo t('email'); ?> *</label>
                            <input type="email" name="email" required class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label><?php echo t('subject'); ?> *</label>
                        <input type="text" name="subject" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label><?php echo t('message'); ?> *</label>
                        <textarea name="message" required rows="6" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg"><?php echo t('send_message'); ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.contact-page { padding: 60px 0; }
.contact-layout { display: grid; grid-template-columns: 400px 1fr; gap: 60px; margin-top: 40px; }
.contact-info { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px; border-radius: 12px; color: white; }
.contact-info h2 { font-size: 28px; margin-bottom: 30px; }
.info-item { display: flex; gap: 20px; margin-bottom: 30px; }
.info-item i { font-size: 24px; margin-top: 5px; }
.info-item h4 { font-size: 18px; font-weight: 600; margin-bottom: 5px; }
.info-item p { opacity: 0.9; }
.contact-form-wrapper { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
@media (max-width: 768px) { .contact-layout { grid-template-columns: 1fr; } .form-row { grid-template-columns: 1fr; } }
</style>

<?php include 'includes/footer.php'; ?>
