# Server Readiness & Option B Setup (Server IP)

## Server capacity check – **yes, the server can handle it**

| Resource   | Total  | In use / available     | Verdict |
|-----------|--------|------------------------|--------|
| **RAM**   | 7.8 GB | ~1.9 GB used, ~5.8 GB available | OK – Laravel + MySQL will fit |
| **CPU**   | 4 cores| Load ~0.7              | OK     |
| **Disk**  | 72 GB  | ~8 GB used, ~64 GB free | OK     |

## What’s already running (no conflict with POS)

- **Nginx** – web server (ports 80, 443)
- **Budget Tracker API** – Node on port **3001** (proxied via Nginx)
- **MyDashboard API** – Node on port **5000**
- **Shwe Bon San** – Node on port **3000** (shwebonsan.com)
- **PostgreSQL** – DB for Budget Tracker
- **Redis**
- **PM2** – process manager for Node apps

POS will use:

- **Port 8000** – Laravel (`php artisan serve`) – no port clash.
- **MySQL** – separate from PostgreSQL (POS uses MySQL).

---

## What’s missing on the server (must install for Option B)

1. **PHP 8.2+** (Laravel needs it) – not installed.
2. **MySQL or MariaDB** (POS uses MySQL) – not installed.

After installing PHP and MySQL, the existing `deploy.sh` (or the steps below) will work.

---

## Option B – Steps to run POS on server IP

### Step 1: Install PHP 8.2 and extensions

```bash
sudo apt update
sudo apt install -y php8.2-cli php8.2-fpm php8.2-mysql php8.2-mbstring php8.2-xml php8.2-bcmath php8.2-curl php8.2-zip php8.2-gd
# Optional: set default PHP
sudo update-alternatives --set php /usr/bin/php8.2 2>/dev/null || true
```

### Step 2: Install MySQL and create DB

```bash
sudo apt install -y mysql-server
sudo systemctl start mysql
sudo systemctl enable mysql

# Secure and create database (set a strong password when prompted)
sudo mysql -e "CREATE DATABASE IF NOT EXISTS pos_database;"
sudo mysql -e "CREATE USER IF NOT EXISTS 'pos_user'@'localhost' IDENTIFIED BY 'YOUR_PASSWORD';"
sudo mysql -e "GRANT ALL ON pos_database.* TO 'pos_user'@'localhost';"
sudo mysql -e "FLUSH PRIVILEGES;"
```

Update POS `.env` with the same DB name and user/password.

### Step 3: Install Composer (if not installed)

```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

### Step 4: Open port 8000 (if firewall is used)

```bash
sudo ufw allow 8000/tcp
sudo ufw status
```

### Step 5: Prepare and run POS (Option B)

Use the project directory that matches your server (with or without trailing space):

```bash
cd /root/POS_PROJECT   # or: cd "/root/POS_PROJECT " if your folder has a space
```

- Set **APP_URL** in `.env` to your server IP and port, e.g.  
  `APP_URL=http://YOUR_SERVER_IP:8000`
- Set **DB_DATABASE**, **DB_USERNAME**, **DB_PASSWORD** to match the MySQL user above.

Then run the deploy script (as root):

```bash
sudo ./deploy.sh
```

If you prefer not to use the script, run manually:

```bash
composer install --no-dev --optimize-autoloader
npm install && npm run build
php artisan migrate --force
php artisan config:cache && php artisan route:cache && php artisan view:cache
# Then create and start the systemd service (see DEPLOYMENT_GUIDE.md or deploy.sh)
```

### Step 6: Access POS

- **URL:** `http://YOUR_SERVER_IP:8000`  
  Example: `http://156.67.30.58:8000`
- **Admin:** `admin123@gmail.com` / `admin123!@#`

---

## Summary

- **Server can handle Option B:** enough RAM, CPU, and disk; no port conflict with existing services.
- **You must install:** PHP 8.2+ and MySQL (or MariaDB), then configure `.env` and run deploy.
- **You do not use a Vercel domain for Option B;** you use the server IP (and optionally a domain later).

After PHP and MySQL are installed, use the steps above (or `deploy.sh`) to run POS 24/7 on the server IP.
