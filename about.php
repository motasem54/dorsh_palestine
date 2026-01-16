<?php
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/functions.php';
require_once 'includes/language.php';

$page_title = t('about');
include 'includes/header.php';
?>

<div class="about-page">
    <div class="container">
        <div class="page-header">
            <h1><?php echo t('about_us'); ?></h1>
            <p><?php echo t('learn_about_our_story'); ?></p>
        </div>
        
        <div class="about-content">
            <div class="about-section">
                <h2><?php echo t('our_story'); ?></h2>
                <p>Dorsh Palestine is a leading e-commerce platform dedicated to showcasing authentic Palestinian products to the world. Founded with a mission to support local artisans and businesses, we connect customers with high-quality, handcrafted items that represent the rich cultural heritage of Palestine.</p>
            </div>
            
            <div class="values-grid">
                <div class="value-card">
                    <i class="fas fa-heart"></i>
                    <h3><?php echo t('passion'); ?></h3>
                    <p><?php echo t('passion_desc'); ?></p>
                </div>
                <div class="value-card">
                    <i class="fas fa-star"></i>
                    <h3><?php echo t('quality'); ?></h3>
                    <p><?php echo t('quality_desc'); ?></p>
                </div>
                <div class="value-card">
                    <i class="fas fa-handshake"></i>
                    <h3><?php echo t('trust'); ?></h3>
                    <p><?php echo t('trust_desc'); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.about-page { padding: 60px 0; }
.page-header { text-align: center; margin-bottom: 60px; }
.page-header h1 { font-size: 48px; font-weight: 700; margin-bottom: 15px; }
.about-section { margin-bottom: 60px; }
.about-section h2 { font-size: 32px; font-weight: 700; margin-bottom: 20px; color: var(--primary); }
.about-section p { font-size: 18px; line-height: 1.8; color: #666; }
.values-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; }
.value-card { text-align: center; padding: 40px 30px; background: white; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); transition: all 0.3s; }
.value-card:hover { transform: translateY(-10px); box-shadow: 0 8px 24px rgba(0,0,0,0.15); }
.value-card i { font-size: 48px; color: var(--primary); margin-bottom: 20px; }
.value-card h3 { font-size: 24px; font-weight: 600; margin-bottom: 15px; }
.value-card p { color: #666; }
@media (max-width: 768px) { .values-grid { grid-template-columns: 1fr; } }
</style>

<?php include 'includes/footer.php'; ?>
