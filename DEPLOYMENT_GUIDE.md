# 🚀 POS Project - 24/7 Production Deployment Guide

## 📋 Overview

This guide will help you deploy your Laravel POS system to run 24/7 in production. We'll cover multiple deployment options from simple to enterprise-grade.

## 🎯 Deployment Options

### Option 1: Systemd Service (Recommended for VPS/Dedicated Server)
### Option 2: Supervisor (Process Manager)
### Option 3: Docker + Docker Compose (Containerized)
### Option 4: Cloud Platform (AWS, DigitalOcean, etc.)

---

## 🔧 Option 1: Systemd Service (Recommended)

### Prerequisites
- Linux server (Ubuntu/Debian/CentOS)
- PHP 8.2+ with required extensions
- MySQL/MariaDB
- Nginx or Apache
- Composer
- Node.js & npm

### Step 1: Prepare Production Environment

```bash
cd /root/POS_PROJECT

# Update .env for production
cp .env .env.production
```

### Step 2: Update .env for Production

Edit `.env` file with production settings:

```env
APP_NAME="POS System"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pos_database
DB_USERNAME=your_db_user
DB_PASSWORD=your_secure_password

# Production optimizations
CACHE_STORE=redis  # or database
SESSION_DRIVER=database
QUEUE_CONNECTION=database
```

### Step 3: Install Dependencies & Build Assets

```bash
# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Install Node dependencies
npm install

# Build production assets
npm run build

# Generate application key (if needed)
php artisan key:generate

# Run migrations
php artisan migrate --force

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Step 4: Set Permissions

```bash
# Set proper permissions
sudo chown -R www-data:www-data /root/POS_PROJECT
sudo chmod -R 755 /root/POS_PROJECT
sudo chmod -R 775 /root/POS_PROJECT/storage
sudo chmod -R 775 /root/POS_PROJECT/bootstrap/cache
```

### Step 5: Create Systemd Service

Create `/etc/systemd/system/pos-system.service`:

```ini
[Unit]
Description=POS System Laravel Application
After=network.target mysql.service

[Service]
Type=simple
User=www-data
Group=www-data
WorkingDirectory=/root/POS_PROJECT
ExecStart=/usr/bin/php artisan serve --host=0.0.0.0 --port=8000
Restart=always
RestartSec=10
StandardOutput=syslog
StandardError=syslog
SyslogIdentifier=pos-system

[Install]
WantedBy=multi-user.target
```

### Step 6: Enable and Start Service

```bash
# Reload systemd
sudo systemctl daemon-reload

# Enable service (start on boot)
sudo systemctl enable pos-system

# Start service
sudo systemctl start pos-system

# Check status
sudo systemctl status pos-system

# View logs
sudo journalctl -u pos-system -f
```

### Step 7: Configure Nginx Reverse Proxy

Create `/etc/nginx/sites-available/pos-system`:

```nginx
server {
    listen 80;
    server_name yourdomain.com www.yourdomain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name yourdomain.com www.yourdomain.com;
    root /root/POS_PROJECT/public;

    ssl_certificate /etc/letsencrypt/live/yourdomain.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/yourdomain.com/privkey.pem;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Enable site:
```bash
sudo ln -s /etc/nginx/sites-available/pos-system /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### Step 8: Setup SSL with Let's Encrypt

```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com
```

---

## 🔄 Option 2: Supervisor (Process Manager)

### Install Supervisor

```bash
sudo apt install supervisor
```

### Create Supervisor Config

Create `/etc/supervisor/conf.d/pos-system.conf`:

```ini
[program:pos-system]
process_name=%(program_name)s
command=/usr/bin/php /root/POS_PROJECT/artisan serve --host=0.0.0.0 --port=8000
autostart=true
autorestart=true
user=www-data
redirect_stderr=true
stdout_logfile=/root/POS_PROJECT/storage/logs/supervisor.log
stopwaitsecs=3600
```

### Start Supervisor

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start pos-system
sudo supervisorctl status
```

---

## 🐳 Option 3: Docker Deployment

### Create Dockerfile

Create `Dockerfile` in project root:

```dockerfile
FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# Set permissions
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html
RUN chmod -R 775 storage bootstrap/cache

# Expose port
EXPOSE 80

CMD php artisan serve --host=0.0.0.0 --port=8000
```

### Create docker-compose.yml

```yaml
version: '3.8'

services:
  app:
    build: .
    ports:
      - "8000:8000"
    volumes:
      - ./:/var/www/html
      - ./storage:/var/www/html/storage
    environment:
      - APP_ENV=production
    depends_on:
      - db

  db:
    image: mysql:8.0
    environment:
      MYSQL_DATABASE: pos_database
      MYSQL_ROOT_PASSWORD: rootpassword
      MYSQL_USER: pos_user
      MYSQL_PASSWORD: pos_password
    volumes:
      - db_data:/var/lib/mysql
    ports:
      - "3306:3306"

  nginx:
    image: nginx:alpine
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - ./:/var/www/html
      - ./nginx.conf:/etc/nginx/nginx.conf
    depends_on:
      - app

volumes:
  db_data:
```

### Run with Docker

```bash
docker-compose up -d
docker-compose logs -f
```

---

## ☁️ Option 4: Cloud Platform Deployment

### DigitalOcean App Platform

1. Connect your Git repository
2. Configure build settings:
   - Build Command: `composer install --no-dev && npm install && npm run build`
   - Run Command: `php artisan serve --host=0.0.0.0 --port=8080`
3. Add MySQL database
4. Set environment variables
5. Deploy!

### AWS Elastic Beanstalk

1. Install EB CLI: `pip install awsebcli`
2. Initialize: `eb init`
3. Create environment: `eb create pos-production`
4. Deploy: `eb deploy`

---

## 🔐 Security Checklist

- [ ] Set `APP_DEBUG=false` in production
- [ ] Use strong database passwords
- [ ] Enable HTTPS/SSL
- [ ] Set up firewall (UFW)
- [ ] Regular backups
- [ ] Update dependencies regularly
- [ ] Use environment variables for secrets
- [ ] Enable rate limiting
- [ ] Set up monitoring (Sentry, etc.)

---

## 📊 Monitoring & Maintenance

### Setup Log Rotation

Create `/etc/logrotate.d/pos-system`:

```
/root/POS_PROJECT/storage/logs/*.log {
    daily
    rotate 14
    compress
    delaycompress
    notifempty
    create 0640 www-data www-data
    sharedscripts
}
```

### Health Check Script

Create `/root/POS_PROJECT/health-check.sh`:

```bash
#!/bin/bash
response=$(curl -s -o /dev/null -w "%{http_code}" http://localhost:8000)
if [ $response -eq 200 ]; then
    echo "OK"
    exit 0
else
    echo "FAIL"
    exit 1
fi
```

### Backup Script

Create `/root/POS_PROJECT/backup.sh`:

```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/root/backups"
mkdir -p $BACKUP_DIR

# Backup database
mysqldump -u root -p pos_database > $BACKUP_DIR/db_$DATE.sql

# Backup files
tar -czf $BACKUP_DIR/files_$DATE.tar.gz /root/POS_PROJECT

# Keep only last 7 days
find $BACKUP_DIR -type f -mtime +7 -delete
```

Add to crontab:
```bash
crontab -e
# Add: 0 2 * * * /root/POS_PROJECT/backup.sh
```

---

## 🚨 Troubleshooting

### Service won't start
```bash
sudo systemctl status pos-system
sudo journalctl -u pos-system -n 50
```

### Permission errors
```bash
sudo chown -R www-data:www-data /root/POS_PROJECT
sudo chmod -R 775 storage bootstrap/cache
```

### Database connection issues
```bash
mysql -u root -p
# Check database exists and user has permissions
```

### Clear all caches
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

## 📝 Quick Start Commands

```bash
# Start service
sudo systemctl start pos-system

# Stop service
sudo systemctl stop pos-system

# Restart service
sudo systemctl restart pos-system

# View logs
sudo journalctl -u pos-system -f

# Check status
sudo systemctl status pos-system
```

---

## 🎯 Recommended Setup for 24/7 Operation

1. **Use Systemd** for process management
2. **Nginx** as reverse proxy
3. **Let's Encrypt** for SSL
4. **MySQL** with regular backups
5. **Monitoring** with health checks
6. **Log rotation** for disk management
7. **Firewall** (UFW) configured
8. **Auto-updates** for security patches

---

## ✅ Deployment Checklist

- [ ] Production .env configured
- [ ] Dependencies installed
- [ ] Assets built
- [ ] Database migrated
- [ ] Permissions set
- [ ] Service created and enabled
- [ ] Nginx configured
- [ ] SSL certificate installed
- [ ] Firewall configured
- [ ] Backups scheduled
- [ ] Monitoring setup
- [ ] Health checks working

---

**🎊 Your POS System is now ready for 24/7 production deployment!** 🎊
