<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdminLogin();

$order_id = $_GET['id'] ?? 0;

$order = $db->query(
    "SELECT o.*, CONCAT(u.first_name, ' ', u.last_name) as customer_name, u.email
    FROM orders o
    LEFT JOIN users u ON o.user_id = u.id
    WHERE o.id = ?",
    [$order_id]
)->fetch();

if (!$order) exit('Order not found');

$items = $db->query(
    "SELECT * FROM order_items WHERE order_id = ?",
    [$order_id]
)->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice #<?php echo $order['order_number']; ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; padding: 40px; color: #333; }
        .invoice { max-width: 800px; margin: 0 auto; background: white; padding: 40px; border: 1px solid #ddd; }
        .header { display: flex; justify-content: space-between; margin-bottom: 40px; padding-bottom: 20px; border-bottom: 3px solid #2563eb; }
        .company h1 { color: #2563eb; font-size: 28px; margin-bottom: 5px; }
        .invoice-info { text-align: right; }
        .invoice-info h2 { color: #2563eb; margin-bottom: 10px; }
        .details { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 40px; }
        .section h3 { font-size: 14px; color: #999; text-transform: uppercase; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th { background: #f5f5f5; padding: 12px; text-align: left; font-size: 13px; text-transform: uppercase; }
        td { padding: 12px; border-bottom: 1px solid #eee; }
        .total { text-align: right; }
        .total-row { display: flex; justify-content: space-between; padding: 8px 0; }
        .final-total { font-size: 20px; font-weight: bold; color: #2563eb; border-top: 2px solid #eee; padding-top: 10px; margin-top: 10px; }
        .footer { text-align: center; margin-top: 40px; padding-top: 20px; border-top: 1px solid #eee; color: #999; font-size: 12px; }
        @media print { body { padding: 0; } }
    </style>
</head>
<body>
    <div class="invoice">
        <div class="header">
            <div class="company">
                <h1>Dorsh Palestine</h1>
                <p>Nablus, Palestine</p>
                <p>+970 599 123 456</p>
                <p>info@dorsh-palestine.com</p>
            </div>
            <div class="invoice-info">
                <h2>INVOICE</h2>
                <p><strong>#<?php echo $order['order_number']; ?></strong></p>
                <p>Date: <?php echo date('M d, Y', strtotime($order['created_at'])); ?></p>
                <p>Status: <strong><?php echo ucfirst($order['status']); ?></strong></p>
            </div>
        </div>
        
        <div class="details">
            <div class="section">
                <h3>Bill To:</h3>
                <p><strong><?php echo h($order['first_name'] . ' ' . $order['last_name']); ?></strong></p>
                <p><?php echo h($order['email']); ?></p>
                <p><?php echo h($order['phone']); ?></p>
            </div>
            <div class="section">
                <h3>Ship To:</h3>
                <p><?php echo h($order['address']); ?></p>
                <p><?php echo h($order['city']); ?> <?php echo h($order['postal_code']); ?></p>
            </div>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>SKU</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                <tr>
                    <td><?php echo h($item['product_name']); ?></td>
                    <td><?php echo h($item['sku']); ?></td>
                    <td>$<?php echo number_format($item['price'], 2); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>$<?php echo number_format($item['total'], 2); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div class="total">
            <div class="total-row">
                <span>Subtotal:</span>
                <strong>$<?php echo number_format($order['subtotal'], 2); ?></strong>
            </div>
            <div class="total-row">
                <span>Shipping:</span>
                <strong>$<?php echo number_format($order['shipping'], 2); ?></strong>
            </div>
            <div class="total-row final-total">
                <span>Total:</span>
                <strong>$<?php echo number_format($order['total'], 2); ?></strong>
            </div>
            <div class="total-row" style="margin-top: 10px;">
                <span>Payment Method:</span>
                <strong><?php echo strtoupper($order['payment_method']); ?></strong>
            </div>
        </div>
        
        <div class="footer">
            <p>Thank you for your business!</p>
            <p>© <?php echo date('Y'); ?> Dorsh Palestine. All rights reserved.</p>
        </div>
    </div>
    
    <script>window.print();</script>
</body>
</html>
