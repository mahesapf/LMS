#  Deployment & DevOps Guide

## Deployment Checklist

### Pre-Deployment
- [ ] All tests pass
- [ ] Code review completed
- [ ] Security scan passed
- [ ] Database migrations tested
- [ ] Environment variables configured
- [ ] Backups created

### Production Setup

#### 1. Server Requirements

```
- OS: Ubuntu 20.04+ or CentOS 8+
- PHP: 8.2+ with extensions
- MySQL: 8.0+
- Nginx or Apache
- Redis (optional, for caching)
- Composer & Node.js
```

#### 2. PHP Extensions Required

```bash
php-fpm
php-mysql
php-curl
php-gd
php-zip
php-mbstring
php-xml
php-json
php-bcmath
```

#### 3. Install PHP Extensions

```bash
# Ubuntu
sudo apt-get install php8.2-fpm php8.2-mysql php8.2-curl php8.2-gd php8.2-zip php8.2-mbstring php8.2-xml

# CentOS
sudo yum install php82-php-fpm php82-php-mysql php82-php-curl php82-php-gd php82-php-zip php82-php-mbstring
```

---

## Nginx Configuration

### Create Virtual Host

```nginx
# /etc/nginx/sites-available/lms.conf
server {
    listen 80;
    server_name lms.yourdomain.com;
    
    # Redirect HTTP to HTTPS
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name lms.yourdomain.com;
    
    # SSL Certificate
    ssl_certificate /etc/letsencrypt/live/lms.yourdomain.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/lms.yourdomain.com/privkey.pem;
    
    # Security Headers
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    
    # Root Directory
    root /var/www/lms/public;
    index index.php;
    
    # Gzip Compression
    gzip on;
    gzip_types text/plain text/css text/xml text/javascript 
               application/x-javascript application/xml+rss;
    gzip_min_length 1000;
    
    # Laravel Configuration
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    # PHP Handler
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    # Deny Access
    location ~ /\.env {
        deny all;
    }
    
    location ~ /\.git {
        deny all;
    }
    
    # Static Files Caching
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2|ttf|eot)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
```

### Enable Site

```bash
sudo ln -s /etc/nginx/sites-available/lms.conf /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

---

## SSL Certificate (Let's Encrypt)

```bash
# Install Certbot
sudo apt-get install certbot python3-certbot-nginx

# Get Certificate
sudo certbot certonly --nginx -d lms.yourdomain.com

# Auto Renewal
sudo systemctl enable certbot.timer
sudo systemctl start certbot.timer
```

---

## Deployment with Git

### Initial Setup

```bash
# Create app directory
sudo mkdir -p /var/www/lms
cd /var/www/lms

# Clone repository
sudo git clone https://github.com/mahesapf/LMS.git .

# Set permissions
sudo chown -R www-data:www-data /var/www/lms
sudo chmod -R 755 /var/www/lms
sudo chmod -R 775 /var/www/lms/storage
sudo chmod -R 775 /var/www/lms/bootstrap/cache
```

### Deployment Script

```bash
#!/bin/bash
# deploy.sh

cd /var/www/lms

echo "Pulling latest code..."
git pull origin main

echo "Installing dependencies..."
composer install --no-dev --optimize-autoloader

echo "Running migrations..."
php artisan migrate --force

echo "Building assets..."
npm install
npm run build

echo "Clearing cache..."
php artisan cache:clear
php artisan config:clear
php artisan view:clear

echo "Restarting services..."
sudo systemctl restart php8.2-fpm
sudo systemctl restart nginx

echo "Deployment complete!"
```

### Usage

```bash
chmod +x deploy.sh
./deploy.sh
```

---

## Environment Configuration

### Production .env

```bash
APP_NAME=SIPM
APP_ENV=production
APP_DEBUG=false
APP_URL=https://lms.yourdomain.com

LOG_CHANNEL=stack
LOG_LEVEL=warning

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=lms_penjaminan_mutu
DB_USERNAME=lms_user
DB_PASSWORD=strong_password_here

CACHE_DRIVER=redis
SESSION_DRIVER=cookie
QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS=noreply@lms.yourdomain.com

FILESYSTEM_DISK=public

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

---

## Database Backup

### Automated Backup Script

```bash
#!/bin/bash
# backup.sh

BACKUP_DIR="/backups/lms"
DATE=$(date +"%Y%m%d_%H%M%S")
DB_NAME="lms_penjaminan_mutu"
DB_USER="lms_user"

mkdir -p $BACKUP_DIR

# Backup Database
mysqldump -u $DB_USER -p$DB_PASSWORD $DB_NAME | gzip > $BACKUP_DIR/db_$DATE.sql.gz

# Backup Storage
tar -czf $BACKUP_DIR/storage_$DATE.tar.gz /var/www/lms/storage

# Remove old backups (keep last 30 days)
find $BACKUP_DIR -type f -mtime +30 -delete

echo "Backup completed: $DATE"
```

### Restore Backup

```bash
# Restore Database
gunzip < /backups/lms/db_20260129_120000.sql.gz | mysql -u $DB_USER -p$DB_PASSWORD $DB_NAME

# Restore Storage
tar -xzf /backups/lms/storage_20260129_120000.tar.gz -C /
```

---

## Monitoring

### PM2 Process Manager

```bash
# Install PM2
npm install -g pm2

# Start artisan queue
pm2 start "php artisan queue:work" --name="lms-queue"

# Monitor
pm2 monit

# Startup on reboot
pm2 startup
pm2 save
```

### System Monitoring

```bash
# Monitor disk space
df -h

# Monitor memory
free -h

# Monitor CPU
top

# Check service status
sudo systemctl status nginx
sudo systemctl status php8.2-fpm
sudo systemctl status mysql
```

---

## Docker Deployment

### Dockerfile

```dockerfile
FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    mysql-client \
    git \
    curl \
    zip \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo_mysql mbstring

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node dependencies
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && apt-get install -y nodejs
RUN npm install && npm run build

# Configure Nginx
COPY nginx.conf /etc/nginx/sites-enabled/default

# Set permissions
RUN chown -R www-data:www-data /var/www/storage
RUN chmod -R 755 /var/www/storage

# Expose ports
EXPOSE 80 443

# Start services
CMD service php8.2-fpm start && nginx -g "daemon off;"
```

### docker-compose.yml

```yaml
version: '3.8'

services:
  app:
    build: .
    ports:
      - "8000:80"
    volumes:
      - .:/var/www
      - storage:/var/www/storage
    environment:
      - APP_ENV=production
      - APP_DEBUG=false
    depends_on:
      - db
      - redis

  db:
    image: mysql:8.0
    volumes:
      - db:/var/lib/mysql
    environment:
      - MYSQL_DATABASE=lms_penjaminan_mutu
      - MYSQL_ROOT_PASSWORD=root_password
      - MYSQL_USER=lms_user
      - MYSQL_PASSWORD=user_password
    ports:
      - "3306:3306"

  redis:
    image: redis:7
    ports:
      - "6379:6379"

volumes:
  db:
  storage:
```

### Deploy with Docker

```bash
docker-compose build
docker-compose up -d
docker-compose exec app php artisan migrate
```

---

## Performance Optimization

### 1. Enable Query Caching

```php
// config/database.php
'redis' => [
    'host' => env('REDIS_HOST', '127.0.0.1'),
    'password' => env('REDIS_PASSWORD', null),
    'port' => env('REDIS_PORT', 6379),
    'database' => env('REDIS_CACHE_DB', 1),
],
```

### 2. Optimize Autoloader

```bash
composer dump-autoload --optimize --no-dev
```

### 3. Cache Configuration

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 4. Enable OPcache

```bash
# /etc/php/8.2/mods-available/opcache.ini
[opcache]
opcache.enable=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=20000
opcache.revalidate_freq=2
opcache.validate_timestamps=1
```

### 5. Database Optimization

```sql
-- Create indexes
ALTER TABLE users ADD INDEX idx_role (role);
ALTER TABLE users ADD INDEX idx_email (email);
ALTER TABLE classes ADD INDEX idx_activity_id (activity_id);
ALTER TABLE grades ADD INDEX idx_class_id_peserta (class_id, peserta_id);

-- Optimize tables
OPTIMIZE TABLE users;
OPTIMIZE TABLE classes;
OPTIMIZE TABLE grades;
```

---

## Monitoring & Logging

### Laravel Logging

```php
// config/logging.php
'channels' => [
    'single' => [
        'driver' => 'single',
        'path' => storage_path('logs/laravel.log'),
        'level' => 'debug',
    ],
    'daily' => [
        'driver' => 'daily',
        'path' => storage_path('logs/laravel.log'),
        'level' => 'debug',
        'days' => 14,
    ],
],
```

### Application Logging

```php
// In controller
Log::info('User logged in', ['user_id' => $user->id]);
Log::warning('High memory usage', ['memory' => memory_get_usage()]);
Log::error('Database error', ['error' => $exception->getMessage()]);
```

### Access Logs

```bash
# Nginx access log
tail -f /var/log/nginx/access.log

# PHP-FPM error log
tail -f /var/log/php8.2-fpm.log
```

---

## Health Check

### Create Health Check Route

```php
// routes/web.php
Route::get('/health', function () {
    return response()->json([
        'status' => 'healthy',
        'timestamp' => now(),
        'database' => DB::connection()->getDatabaseName(),
    ]);
});
```

### Monitor Health

```bash
# Check service
curl https://lms.yourdomain.com/health

# Automated monitoring
*/5 * * * * curl -f https://lms.yourdomain.com/health || mail -s "SIPM Health Check Failed" admin@yourdomain.com
```

---

## Security Hardening

### 1. Firewall Configuration

```bash
sudo ufw default deny incoming
sudo ufw default allow outgoing
sudo ufw allow 22/tcp  # SSH
sudo ufw allow 80/tcp  # HTTP
sudo ufw allow 443/tcp # HTTPS
sudo ufw enable
```

### 2. SSH Key Setup

```bash
# Generate key pair
ssh-keygen -t rsa -b 4096

# Add to authorized_keys
cat ~/.ssh/id_rsa.pub >> ~/.ssh/authorized_keys

# Disable password authentication
sudo nano /etc/ssh/sshd_config
# Set: PasswordAuthentication no
sudo systemctl restart ssh
```

### 3. Fail2ban Setup

```bash
# Install
sudo apt-get install fail2ban

# Configure
sudo nano /etc/fail2ban/jail.local

# Add:
[DEFAULT]
bantime = 3600
maxretry = 5

[sshd]
enabled = true

sudo systemctl restart fail2ban
```

---

## Rollback Procedure

```bash
cd /var/www/lms

# Show commit history
git log --oneline

# Rollback to previous version
git revert HEAD
# or
git reset --hard <commit-hash>

# Rebuild application
composer install --no-dev
npm run build

# Run migrations (if needed)
php artisan migrate

# Restart services
sudo systemctl restart php8.2-fpm nginx
```

---

## Troubleshooting

| Issue | Solution |
|-------|----------|
| 500 Error | Check `storage/logs/laravel.log` |
| Database Error | Verify DB credentials in .env, check MySQL running |
| Permission Denied | `chmod -R 755 storage/`, `chown -R www-data storage/` |
| Assets not loading | Run `npm run build`, clear nginx cache |
| Too many files open | Increase ulimit: `ulimit -n 65535` |
| SSL certificate error | Check certificate validity, renew if needed |

---

**Last Updated**: 29 Januari 2026
