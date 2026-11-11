#!/bin/bash
set -e

# ==============================================================================
# Render Dynamic Port Configuration
# Render binds external traffic to the port defined in the PORT environment variable
# (defaults to 10000 on Render). We dynamically update Apache's listening port.
# ==============================================================================
APP_PORT="${PORT:-80}"
echo "Configuring Apache to listen on port ${APP_PORT}..."
sed -i "s/Listen [0-9]*/Listen ${APP_PORT}/g" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:[0-9]*>/<VirtualHost \*:${APP_PORT}>/g" /etc/apache2/sites-available/000-default.conf

# ==============================================================================
# Directory Setup and Permissions
# Ensure required Laravel storage framework directories exist with proper permissions.
# ==============================================================================
echo "Setting up storage and cache directories..."
mkdir -p /var/www/html/storage/framework/cache/data \
         /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/views \
         /var/www/html/storage/logs \
         /var/www/html/storage/app/public/images \
         /var/www/html/bootstrap/cache \
         /var/www/html/public/images

touch /var/www/html/storage/logs/laravel.log

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public
chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/images

# ==============================================================================
# Symlink Public Storage
# ==============================================================================
echo "Ensuring storage symlink exists..."
php artisan storage:link --force || true

# ==============================================================================
# Database Migrations (Optional Automatic Execution)
# If RUN_MIGRATIONS is set to "true", run migrations on container boot.
# ==============================================================================
if [ "${RUN_MIGRATIONS:-false}" = "true" ]; then
    echo "Running database migrations (--force)..."
    php artisan migrate --force
    if [ "${RUN_SEEDER:-false}" = "true" ]; then
        echo "Running database seeder (--force)..."
        php artisan db:seed --force
    fi
fi

# ==============================================================================
# Laravel Cache Optimization
# ==============================================================================
echo "Clearing old caches..."
php artisan optimize:clear

echo "Running optimization and caching for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Starting Apache server..."
exec apache2-foreground

