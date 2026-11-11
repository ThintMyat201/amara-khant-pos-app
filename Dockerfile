# ==============================================================================
# Multi-Stage Dockerfile for Laravel 12 on Render (Apache + Node/Vite Assets)
# ==============================================================================

# ------------------------------------------------------------------------------
# Stage 1: Build Frontend Assets (Vite, Tailwind, JS)
# ------------------------------------------------------------------------------
FROM node:20-alpine AS node_builder

WORKDIR /app

# Copy dependency manifests
COPY package.json package-lock.json ./

# Install npm dependencies
RUN npm ci

# Copy project files needed for asset compilation
COPY resources ./resources
COPY vite.config.js postcss.config.js tailwind.config.js ./
COPY public ./public

# Build production assets (outputs to public/build)
RUN npm run build

# ------------------------------------------------------------------------------
# Stage 2: Production PHP 8.2 with Apache
# ------------------------------------------------------------------------------
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Avoid prompts during package installation
ENV DEBIAN_FRONTEND=noninteractive

# Install system dependencies & build tools
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    default-mysql-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Enable Apache Rewrite & Headers modules
RUN a2enmod rewrite headers

# Install Composer from official image
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Copy custom Apache VirtualHost configuration
COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Copy Composer files first to leverage Docker layer caching
COPY composer.json composer.lock ./

# Install PHP production dependencies without autoloader dump & scripts
RUN composer install --no-dev --no-interaction --no-scripts --prefer-dist

# Copy application source code
COPY . .

# Copy compiled frontend assets from the node_builder stage
COPY --from=node_builder /app/public/build /var/www/html/public/build

# Finish Composer autoloader optimization
RUN composer dump-autoload --optimize --no-dev

# Setup directory structure & permissions
RUN mkdir -p \
        storage/framework/cache/data \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
        bootstrap/cache \
        public/images \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/images \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/images

# Copy entrypoint script and ensure executable
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Expose ports for standard HTTP and Render default (10000)
EXPOSE 80 10000

# Set entrypoint
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]

