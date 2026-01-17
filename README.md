# Dorsh Palestine E-Commerce Platform

## Project Overview

A complete bilingual (Arabic/English) e-commerce platform for Palestinian products with AI-powered chatbot integration.

## Features

- ✅ Bilingual Interface (Arabic/English with RTL support)
- ✅ Admin Dashboard (Golden Gates Style)
- ✅ Product Management (Categories, Stock, Variants)
- ✅ Shopping Cart & Checkout
- ✅ User Accounts & Order Tracking
- ✅ OpenAI Chatbot (Product Search & Recommendations)
- ✅ Product Reviews System
- ✅ Discount Coupons
- ✅ Email Notifications
- ✅ SEO Optimized (robots.txt, sitemap.xml)
- ✅ Mobile Responsive Design

## Technology Stack

- **Backend:** PHP 8.0+
- **Database:** MySQL/MariaDB
- **Frontend:** HTML5, CSS3, JavaScript
- **AI:** OpenAI GPT-4 Integration
- **Icons:** Font Awesome 6

## Installation Guide

### Requirements

- PHP 8.0 or higher
- MySQL 5.7+ or MariaDB 10.3+
- Apache/Nginx web server
- SSL Certificate (recommended for production)

### Step 1: Download Files

```bash
git clone https://github.com/motasem54/dorsh_palestine.git
cd dorsh_palestine
```

### Step 2: Database Setup

1. Create database:
```sql
CREATE DATABASE dorsh_palestine CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. Import database:
```bash
mysql -u your_username -p dorsh_palestine < database.sql
```

### Step 3: Configuration

1. Edit `includes/config.php`:

```php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'dorsh_palestine');
define('DB_USER', 'your_database_user');
define('DB_PASS', 'your_database_password');

// Site Configuration
define('SITE_URL', 'https://yourdomain.com');

// OpenAI Configuration
define('OPENAI_API_KEY', 'your-openai-api-key');

// Email Configuration
define('EMAIL_FROM', 'info@yourdomain.com');
define('SMTP_HOST', 'smtp.yourdomain.com');
define('SMTP_USER', 'your-email@yourdomain.com');
define('SMTP_PASS', 'your-email-password');
```

2. Update `.htaccess` for your domain

### Step 4: File Permissions

```bash
# Set proper permissions
chmod 755 -R .
chmod 644 includes/config.php
```

### Step 5: Create Admin Account

Run this SQL to create first admin:

```sql
INSERT INTO admins (username, email, password, role, status, created_at) 
VALUES (
    'admin',
    'admin@dorsh-palestine.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', -- password: password
    'super_admin',
    'active',
    NOW()
);
```

**Default Login:**
- Username: `admin`
- Password: `password` (⚠️ Change immediately!)

### Step 6: Test Installation

1. Visit: `https://yourdomain.com`
2. Admin Panel: `https://yourdomain.com/admin`

## Post-Installation

### Security Checklist

- [ ] Change default admin password
- [ ] Update `includes/config.php` with production credentials
- [ ] Enable HTTPS/SSL
- [ ] Set `display_errors = 0` in production
- [ ] Configure automated backups
- [ ] Set up email notifications
- [ ] Test all features

### Recommended Settings

```php
// Production mode in config.php
error_reporting(0);
ini_set('display_errors', 0);
```

## File Structure

```
dorsh_palestine/
├── admin/              # Admin Panel
├── account/            # User Dashboard
├── api/                # REST APIs
├── assets/             # CSS, JS, Images
├── email-templates/    # Email Templates
├── includes/           # Core Functions
├── lang/               # Translations
├── index.php           # Homepage
├── shop.php            # Shop Page
├── product.php         # Product Details
├── cart.php            # Shopping Cart
├── checkout.php        # Checkout
└── README.md           # This file
```

## Support

For issues or questions:
- Email: hamzehbasilsubhi@gmail.com
- Developer: Hamza Bassel

## License

Proprietary - All rights reserved to Scalos AI Agency

## Credits

Developed by Hamza Bassel for Scalos AI Agency
Client: Dorsch Palestine
