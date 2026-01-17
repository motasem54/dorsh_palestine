<?php
require_once 'includes/config.php';

http_response_code(500);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Server Error</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f5f5f5; display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 20px; }
        .error-container { text-align: center; max-width: 600px; background: white; padding: 60px 40px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .error-code { font-size: 100px; font-weight: 700; color: #f59e0b; line-height: 1; margin-bottom: 20px; }
        .error-title { font-size: 28px; font-weight: 600; margin-bottom: 15px; color: #333; }
        .error-message { font-size: 16px; color: #666; margin-bottom: 30px; line-height: 1.6; }
        .btn { display: inline-block; padding: 12px 30px; background: #2563eb; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; transition: all 0.3s; }
        .btn:hover { background: #1e40af; transform: translateY(-2px); }
    </style>
</head>
<body>
    <div class="error-container">
        <h1 class="error-code">500</h1>
        <h2 class="error-title">Internal Server Error</h2>
        <p class="error-message">Oops! Something went wrong on our server. We're working to fix the issue. Please try again later.</p>
        <a href="/" class="btn">Go Back Home</a>
    </div>
</body>
</html>
