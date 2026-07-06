# 🚀 Quick Start: Deploy POS System 24/7

## 📋 What You Have

A **Laravel-based Point of Sale (POS) System** with:
- Admin dashboard for managing products, users, and reports
- Sales interface for transactions
- User authentication and role-based access
- MySQL database
- Email functionality (Gmail SMTP)

## 🎯 How to Deploy for 24/7 Operation

### **Recommended Approach: Systemd Service**

This is the best option for running on a Linux server (VPS, dedicated server, or cloud instance).

---

## ⚡ Quick Deployment (5 Steps)

### **Step 1: Prepare Production Environment**

```bash
cd /root/POS_PROJECT

# Backup current .env
cp .env .env.backup

# Edit .env for production
nano .env
```

**Update these values in `.env`:**
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com  # or http://your-server-ip

# Make sure database credentials are correct
DB_DATABASE=pos_database
DB_USERNAME=root
DB_PASSWORD=your_password
```

### **Step 2: Install Dependencies & Build**

```bash
# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Install Node dependencies
npm install

# Build production assets
npm run build

# Run database migrations
php artisan migrate --force

# Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### **Step 3: Set Permissions**

```bash
sudo chown -R www-data:www-data /root/POS_PROJECT
sudo chmod -R 755 /root/POS_PROJECT
sudo chmod -R 775 /root/POS_PROJECT/storage
sudo chmod -R 775 /root/POS_PROJECT/bootstrap/cache
```

### **Step 4: Create Systemd Service**

Create the service file:
```bash
sudo nano /etc/systemd/system/pos-system.service
```

Paste this content:
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

### **Step 5: Enable and Start**

```bash
# Reload systemd
sudo systemctl daemon-reload

# Enable service (starts on boot)
sudo systemctl enable pos-system

# Start service
sudo systemctl start pos-system

# Check status
sudo systemctl status pos-system
```

**🎉 Done! Your application is now running 24/7!**

---

## 🔧 OR Use the Automated Script

I've created an automated deployment script for you:

```bash
cd /root/POS_PROJECT
sudo ./deploy.sh
```

This script will:
- Install dependencies
- Build assets
- Set permissions
- Create and start the systemd service
- Verify everything is working

---

## 🌐 Access Your Application

After deployment, your application will be available at:

- **Direct access**: `http://your-server-ip:8000`
- **With domain**: `http://yourdomain.com:8000`

### **Login Credentials:**
- **Admin**: `admin123@gmail.com` / `admin123!@#`
- **Regular User**: `paolo@gmail.com` / (your password)

---

## 🔒 Optional: Add Nginx Reverse Proxy + SSL

For production, you should use Nginx as a reverse proxy and enable HTTPS.

### Install Nginx
```bash
sudo apt update
sudo apt install nginx
```

### Create Nginx Config

```bash
sudo nano /etc/nginx/sites-available/pos-system
```

Paste:
```nginx
server {
    listen 80;
    server_name yourdomain.com www.yourdomain.com;
    
    root /root/POS_PROJECT/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

Enable:
```bash
sudo ln -s /etc/nginx/sites-available/pos-system /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### Add SSL (Let's Encrypt)
```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d yourdomain.com
```

---

## 📊 Useful Commands

### Service Management
```bash
# Start
sudo systemctl start pos-system

# Stop
sudo systemctl stop pos-system

# Restart
sudo systemctl restart pos-system

# Status
sudo systemctl status pos-system

# View logs
sudo journalctl -u pos-system -f

# Disable auto-start
sudo systemctl disable pos-system
```

### Application Commands
```bash
cd /root/POS_PROJECT

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Run migrations
php artisan migrate

# View logs
tail -f storage/logs/laravel.log
```

---

## 🔍 Troubleshooting

### Service won't start?
```bash
# Check logs
sudo journalctl -u pos-system -n 50

# Check if port is in use
sudo lsof -i :8000

# Check permissions
ls -la /root/POS_PROJECT/storage
```

### Database connection error?
```bash
# Test MySQL connection
mysql -u root -p

# Check if database exists
mysql -u root -p -e "SHOW DATABASES;"

# Create database if needed
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS pos_database;"
```

### Permission errors?
```bash
sudo chown -R www-data:www-data /root/POS_PROJECT
sudo chmod -R 775 /root/POS_PROJECT/storage
sudo chmod -R 775 /root/POS_PROJECT/bootstrap/cache
```

---

## 📝 Next Steps

1. ✅ **Deploy** using the steps above
2. 🔒 **Configure firewall** (UFW)
3. 📦 **Setup backups** (database + files)
4. 📊 **Add monitoring** (optional)
5. 🔄 **Schedule updates** (security patches)

---

## 📚 Full Documentation

For detailed deployment options (Docker, Supervisor, Cloud platforms), see:
- `DEPLOYMENT_GUIDE.md` - Complete deployment guide

---

## ✅ Deployment Checklist

- [ ] `.env` configured for production
- [ ] Dependencies installed (`composer install`, `npm install`)
- [ ] Assets built (`npm run build`)
- [ ] Database migrated (`php artisan migrate`)
- [ ] Permissions set correctly
- [ ] Systemd service created and enabled
- [ ] Service is running (`systemctl status`)
- [ ] Application accessible via browser
- [ ] (Optional) Nginx configured
- [ ] (Optional) SSL certificate installed

---

**🎊 Your POS System is ready for 24/7 operation!** 🎊
