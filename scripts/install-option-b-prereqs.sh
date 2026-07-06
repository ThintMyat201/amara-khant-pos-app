#!/bin/bash
# Option B: Install PHP 8.2 + MySQL so POS can run on this server.
# Run once: sudo ./install-option-b-prereqs.sh

set -e
echo "Installing PHP 8.2 and MySQL for POS (Option B)..."

sudo apt update
sudo apt install -y php8.2-cli php8.2-fpm php8.2-mysql php8.2-mbstring php8.2-xml php8.2-bcmath php8.2-curl php8.2-zip php8.2-gd

if ! command -v composer &>/dev/null; then
  echo "Installing Composer..."
  curl -sS https://getcomposer.org/installer | php
  sudo mv composer.phar /usr/local/bin/composer
fi

if ! dpkg -l mysql-server &>/dev/null && ! dpkg -l mariadb-server &>/dev/null; then
  echo "Installing MySQL server..."
  sudo apt install -y mysql-server
  sudo systemctl start mysql
  sudo systemctl enable mysql
  echo "Create database and user: sudo mysql -e \"CREATE DATABASE IF NOT EXISTS pos_database;\""
else
  echo "MySQL/MariaDB already present. Ensure database pos_database exists."
fi

php -v
echo "Done. Next: set .env (DB_*, APP_URL=http://YOUR_IP:8000), then run sudo ./deploy.sh"
