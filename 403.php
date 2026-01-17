<?php
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/functions.php';
require_once 'includes/language.php';

http_response_code(403);
$page_title = '403 - Access Denied';

include 'includes/header.php';
?>

<div class="error-page">
    <div class="container">
        <div class="error-content">
            <h1 class="error-code">403</h1>
            <h2 class="error-title"><?php echo t('access_denied'); ?></h2>
            <p class="error-message"><?php echo t('access_denied_message'); ?></p>
            <div class="error-actions">
                <a href="/" class="btn btn-primary">
                    <i class="fas fa-home"></i> <?php echo t('go_home'); ?>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.error-page { min-height: 60vh; display: flex; align-items: center; justify-content: center; padding: 60px 0; }
.error-content { text-align: center; max-width: 600px; margin: 0 auto; }
.error-code { font-size: 120px; font-weight: 700; color: #ef4444; line-height: 1; margin-bottom: 20px; }
.error-title { font-size: 32px; font-weight: 600; margin-bottom: 15px; }
.error-message { font-size: 18px; color: #666; margin-bottom: 40px; }
.error-actions { display: flex; gap: 15px; justify-content: center; }
</style>

<?php include 'includes/footer.php'; ?>
