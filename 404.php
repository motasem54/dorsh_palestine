<?php
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/functions.php';
require_once 'includes/language.php';

http_response_code(404);
$page_title = '404 - Page Not Found';

include 'includes/header.php';
?>

<div class="error-page">
    <div class="container">
        <div class="error-content">
            <h1 class="error-code">404</h1>
            <h2 class="error-title"><?php echo t('page_not_found'); ?></h2>
            <p class="error-message"><?php echo t('page_not_found_message'); ?></p>
            <div class="error-actions">
                <a href="/" class="btn btn-primary">
                    <i class="fas fa-home"></i> <?php echo t('go_home'); ?>
                </a>
                <a href="/shop.php" class="btn btn-outline">
                    <i class="fas fa-shopping-bag"></i> <?php echo t('shop_now'); ?>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.error-page { min-height: 60vh; display: flex; align-items: center; justify-content: center; padding: 60px 0; }
.error-content { text-align: center; max-width: 600px; margin: 0 auto; }
.error-code { font-size: 120px; font-weight: 700; color: #2563eb; line-height: 1; margin-bottom: 20px; }
.error-title { font-size: 32px; font-weight: 600; margin-bottom: 15px; }
.error-message { font-size: 18px; color: #666; margin-bottom: 40px; }
.error-actions { display: flex; gap: 15px; justify-content: center; }
@media (max-width: 768px) {
    .error-code { font-size: 80px; }
    .error-title { font-size: 24px; }
    .error-actions { flex-direction: column; }
}
</style>

<?php include 'includes/footer.php'; ?>
