# Deployment Checklist - Dorsh Palestine

## Pre-Deployment

### Code Review
- [ ] All features tested locally
- [ ] Database migrations ready
- [ ] No sensitive data in code
- [ ] Git repository updated

### Configuration
- [ ] `config.php` updated with production values
- [ ] OpenAI API key configured
- [ ] SMTP/Email settings configured
- [ ] SSL certificate obtained
- [ ] Domain DNS configured

### Security
- [ ] `.env` files not in repository
- [ ] Default passwords changed
- [ ] File permissions set correctly
- [ ] SQL injection protection verified
- [ ] XSS protection enabled
- [ ] CSRF tokens implemented

---

## Deployment Steps

### 1. Server Setup
- [ ] PHP 8.0+ installed
- [ ] MySQL/MariaDB installed
- [ ] Apache/Nginx configured
- [ ] SSL certificate installed
- [ ] Firewall configured

### 2. File Upload
- [ ] All files uploaded via FTP/Git
- [ ] `.htaccess` file uploaded
- [ ] `robots.txt` uploaded
- [ ] File permissions set (755/644)

### 3. Database
- [ ] Database created
- [ ] User created with privileges
- [ ] `database.sql` imported
- [ ] Admin account created
- [ ] Test data (optional) added

### 4. Configuration Files
- [ ] `includes/config.php` updated
- [ ] `SITE_URL` set to production domain
- [ ] Database credentials verified
- [ ] Email settings tested
- [ ] Error reporting disabled

### 5. Testing
- [ ] Homepage accessible
- [ ] Admin panel login works
- [ ] User registration works
- [ ] Product pages load
- [ ] Cart functionality works
- [ ] Checkout process complete
- [ ] Email notifications sent
- [ ] Payment gateway tested
- [ ] Arabic/English switching works
- [ ] Mobile responsive verified

---

## Post-Deployment

### Monitoring
- [ ] Error logs checked
- [ ] Performance monitoring enabled
- [ ] Analytics installed (optional)
- [ ] Uptime monitoring configured

### Security
- [ ] Admin password changed
- [ ] Database backups scheduled
- [ ] File backups scheduled
- [ ] Security headers verified
- [ ] SSL/HTTPS enforced

### SEO
- [ ] Sitemap submitted to Google
- [ ] robots.txt accessible
- [ ] Meta tags verified
- [ ] Social media tags added

### Performance
- [ ] Page load time < 3s
- [ ] Images optimized
- [ ] Caching enabled
- [ ] Compression enabled
- [ ] CDN configured (optional)

---

## Common Issues

### Database Connection Failed
```php
// Verify credentials in config.php
define('DB_HOST', 'localhost');
define('DB_NAME', 'actual_db_name');
define('DB_USER', 'actual_username');
define('DB_PASS', 'actual_password');
```

### 500 Internal Server Error
```bash
# Check Apache error log
tail -f /var/log/apache2/error.log

# Verify .htaccess syntax
apachectl configtest
```

### Email Not Sending
```php
// Test SMTP connection
telnet smtp.yourdomain.com 587

// Check spam folder
// Verify SPF/DKIM records
```

### Session Issues
```php
// Create sessions directory
mkdir sessions
chmod 777 sessions

// Update php.ini
session.save_path = "/path/to/sessions"
```

---

## Rollback Plan

### If Deployment Fails

1. **Database Rollback:**
```sql
-- Drop new database
DROP DATABASE dorsh_palestine;

-- Restore from backup
mysql -u user -p dorsh_palestine < backup.sql
```

2. **Files Rollback:**
```bash
# Restore from backup
tar -xzf backup_files.tar.gz
```

3. **DNS Rollback:**
- Point domain back to old server
- Wait for DNS propagation (24-48h)

---

## Maintenance

### Daily
- [ ] Check error logs
- [ ] Monitor uptime
- [ ] Review new orders

### Weekly
- [ ] Database backup
- [ ] File backup
- [ ] Security updates

### Monthly
- [ ] Performance review
- [ ] Security audit
- [ ] Feature updates

---

## Emergency Contacts

- **Developer:** Hamza Bassel - hamzehbasilsubhi@gmail.com
- **Hosting Support:** [Your hosting provider]
- **Domain Registrar:** [Your domain registrar]

---

## Success Criteria

✅ Site accessible at production URL
✅ All features working
✅ No critical errors in logs
✅ Email notifications working
✅ SSL/HTTPS enabled
✅ Mobile responsive
✅ Admin panel accessible
✅ Backups configured

**Deployment Date:** _____________
**Deployed By:** _____________
**Verified By:** _____________
