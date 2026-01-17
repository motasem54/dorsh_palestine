<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif; background: #f5f5f5; padding: 20px; }
        .email-container { max-width: 600px; margin: 0 auto; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .email-header { background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); color: white; padding: 40px 30px; text-align: center; }
        .email-header h1 { font-size: 28px; margin-bottom: 10px; }
        .email-header p { opacity: 0.9; font-size: 14px; }
        .email-body { padding: 40px 30px; }
        .email-footer { background: #f8f9fa; padding: 30px; text-align: center; font-size: 13px; color: #666; border-top: 1px solid #eee; }
        .btn { display: inline-block; padding: 14px 30px; background: #2563eb; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; margin: 20px 0; }
        .order-summary { background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .order-item { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #eee; }
        .total-row { display: flex; justify-content: space-between; padding: 15px 0; font-size: 18px; font-weight: 700; border-top: 2px solid #ddd; margin-top: 10px; color: #2563eb; }
        .info-box { background: #e0f2fe; border-left: 4px solid #2563eb; padding: 15px; margin: 20px 0; border-radius: 4px; }
        .social-links { margin-top: 20px; }
        .social-links a { display: inline-block; margin: 0 8px; color: #2563eb; text-decoration: none; }
    </style>
</head>
<body>
    <div class="email-container">
        <?php echo $content; ?>
        
        <div class="email-footer">
            <p><strong>Dorsh Palestine</strong></p>
            <p>Nablus, Palestine</p>
            <p>Phone: +970 599 123 456 | Email: info@dorsh-palestine.com</p>
            <div class="social-links">
                <a href="#">Facebook</a> |
                <a href="#">Instagram</a> |
                <a href="#">Twitter</a>
            </div>
            <p style="margin-top: 20px; font-size: 12px; color: #999;">
                &copy; <?php echo date('Y'); ?> Dorsh Palestine. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
