<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdminLogin();

$page_title = 'Settings';
$current_page = 'settings';

// Get current settings
$settings = [];
$result = $db->query("SELECT * FROM settings")->fetchAll();
foreach ($result as $row) {
    $settings[$row['key']] = $row['value'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $key => $value) {
        if ($key === 'submit') continue;
        
        $existing = $db->query("SELECT id FROM settings WHERE `key` = ?", [$key])->fetch();
        
        if ($existing) {
            $db->query("UPDATE settings SET value = ? WHERE `key` = ?", [$value, $key]);
        } else {
            $db->query("INSERT INTO settings (`key`, value) VALUES (?, ?)", [$key, $value]);
        }
    }
    
    logAdminActivity($_SESSION['admin_id'], 'settings_update', 'Updated site settings');
    $_SESSION['success'] = 'Settings saved successfully!';
    header('Location: index.php');
    exit;
}

include __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
    <h1 class="page-title"><i class="fas fa-cog"></i> Settings</h1>
</div>

<form method="POST" class="settings-form">
    <div class="dashboard-row">
        <!-- General Settings -->
        <div class="dashboard-col-6">
            <div class="dashboard-card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-store"></i> General Settings</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Site Name</label>
                        <input type="text" name="site_name" class="form-control" value="<?php echo h($settings['site_name'] ?? 'Dorsh Palestine'); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Site Email</label>
                        <input type="email" name="site_email" class="form-control" value="<?php echo h($settings['site_email'] ?? 'info@dorsh-palestine.com'); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="site_phone" class="form-control" value="<?php echo h($settings['site_phone'] ?? '+970 599 123 456'); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Address</label>
                        <input type="text" name="site_address" class="form-control" value="<?php echo h($settings['site_address'] ?? 'Nablus, Palestine'); ?>">
                    </div>
                </div>
            </div>
        </div>
        
        <!-- OpenAI Settings -->
        <div class="dashboard-col-6">
            <div class="dashboard-card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-robot"></i> OpenAI Settings</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">OpenAI API Key</label>
                        <input type="text" name="openai_api_key" class="form-control" value="<?php echo h($settings['openai_api_key'] ?? OPENAI_API_KEY); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Chatbot Status</label>
                        <select name="chatbot_enabled" class="form-control">
                            <option value="1" <?php echo ($settings['chatbot_enabled'] ?? '1') == '1' ? 'selected' : ''; ?>>Enabled</option>
                            <option value="0" <?php echo ($settings['chatbot_enabled'] ?? '1') == '0' ? 'selected' : ''; ?>>Disabled</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Shipping Settings -->
            <div class="dashboard-card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-truck"></i> Shipping Settings</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Shipping Cost ($)</label>
                        <input type="number" name="shipping_cost" class="form-control" step="0.01" value="<?php echo h($settings['shipping_cost'] ?? '0'); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Free Shipping Threshold ($)</label>
                        <input type="number" name="free_shipping_threshold" class="form-control" step="0.01" value="<?php echo h($settings['free_shipping_threshold'] ?? '50'); ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="dashboard-card">
        <div class="card-body">
            <button type="submit" name="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-save"></i> Save Settings
            </button>
        </div>
    </div>
</form>

<style>
.settings-form .form-group { margin-bottom: 20px; }
.settings-form .form-label { display: block; margin-bottom: 8px; font-weight: 600; }
</style>

<?php include __DIR__ . '/../includes/footer.php'; ?>
