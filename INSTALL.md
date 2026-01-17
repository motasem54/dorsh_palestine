# Installation Guide - Dorsh Palestine

## Quick Start (cPanel)

### 1. Upload Files

1. Login to cPanel
2. Go to **File Manager**
3. Navigate to `public_html`
4. Upload all project files (or use Git Clone)

### 2. Create Database

1. Go to **MySQL Databases**
2. Create new database: `dorsh_palestine`
3. Create new user
4. Add user to database (ALL PRIVILEGES)
5. Note the credentials

### 3. Import Database

1. Go to **phpMyAdmin**
2. Select `dorsh_palestine` database
3. Click **Import**
4. Choose `database.sql`
5. Click **Go**

### 4. Configure

1. Edit `includes/config.php`:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'your_cpanel_user_dorsh_palestine');
define('DB_USER', 'your_cpanel_user_dbuser');
define('DB_PASS', 'your_database_password');

define('SITE_URL', 'https://yourdomain.com');
```

### 5. Set Permissions

In File Manager, set permissions:
- All folders: `755`
- All files: `644`
- `includes/config.php`: `600`

### 6. Test

Visit:
- Frontend: `https://yourdomain.com`
- Admin: `https://yourdomain.com/admin`

Default admin login:
- Username: `admin`
- Password: `password`

⚠️ **Change password immediately!**

---

## Common Issues & Solutions

### Issue 1: Database Connection Error

**Error:** `Connection failed: Access denied`

**Solution:**
```php
// Check config.php credentials
// Verify database user has privileges
// Test connection in phpMyAdmin
```

### Issue 2: 500 Internal Server Error

**Solution:**
1. Check `.htaccess` file
2. Verify PHP version (8.0+)
3. Check error logs in cPanel
4. Disable display_errors in production

### Issue 3: Images Not Loading

**Solution:**
```bash
# Create directories
mkdir -p images/products
chmod 755 images/products
```

### Issue 4: Email Not Sending

**Solution:**
```php
// Update SMTP settings in config.php
define('SMTP_HOST', 'mail.yourdomain.com');
define('SMTP_USER', 'noreply@yourdomain.com');
define('SMTP_PASS', 'your_email_password');
```

### Issue 5: Session Errors

**Solution:**
```bash
# Create sessions directory
mkdir sessions
chmod 777 sessions
```

---

## SSL/HTTPS Setup

### Using Let's Encrypt (Free)

1. In cPanel, go to **SSL/TLS Status**
2. Enable AutoSSL for your domain
3. Wait 5-10 minutes
4. Update `SITE_URL` in config.php to `https://`

### Force HTTPS

In `.htaccess`, uncomment:
```apache
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

---

## Performance Optimization

### Enable Caching

Add to `.htaccess`:
```apache
# Browser Caching (already included)
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpeg "access plus 1 year"
</IfModule>
```

### Enable Compression

Add to `.htacache`:
```apache
# Gzip Compression (already included)
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/css text/javascript
</IfModule>
```

---

## Backup Strategy

### Automated Backups (cPanel)

1. Go to **Backup Wizard**
2. Enable automatic backups
3. Set backup frequency (daily recommended)

### Manual Backup

```bash
# Backup database
mysqldump -u user -p dorsh_palestine > backup_$(date +%Y%m%d).sql

# Backup files
tar -czf backup_files_$(date +%Y%m%d).tar.gz /path/to/dorsh_palestine
```

---

## Testing Checklist

- [ ] Homepage loads
- [ ] Shop page displays products
- [ ] Search works
- [ ] Add to cart works
- [ ] Checkout process
- [ ] User registration
- [ ] User login
- [ ] Admin panel login
- [ ] Email notifications
- [ ] Language switcher (AR/EN)
- [ ] Mobile responsive
- [ ] SSL/HTTPS enabled

---

## Support

If you encounter issues:

1. Check error logs: `cPanel > Errors`
2. Enable debug mode temporarily
3. Contact developer: hamzehbasilsubhi@gmail.com
