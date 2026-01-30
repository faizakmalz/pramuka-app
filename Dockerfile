# ===============================
# FRONTEND (Vite / Node 20)
# ===============================
FROM node:20-alpine AS frontend

WORKDIR /app

# Copy package files
COPY package*.json ./

# Install ALL dependencies (including production deps like jquery, datatables)
RUN npm ci

# Copy source files
COPY resources ./resources
COPY vite.config.js ./
COPY tailwind.config.js ./
COPY postcss.config.js ./
COPY public ./public

# Build
RUN npm run build

# Verify build
RUN echo "=== Build Output ===" && \
    ls -laR public/build && \
    echo "=== Manifest ===" && \
    cat public/build/manifest.json


# ===============================
# BACKEND (Laravel PHP 8.2)
# ===============================
FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl zip \
    libpng-dev libonig-dev libxml2-dev \
    libpq-dev default-mysql-client \
    libzip-dev nginx supervisor \
    netcat-openbsd dnsutils \
    libicu-dev procps \
    && docker-php-ext-configure intl \
    && docker-php-ext-install \
        pdo_mysql pdo_pgsql \
        mbstring exif pcntl bcmath gd zip \
        intl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# PHP-FPM configuration
RUN echo "[www]" > /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo "user = www-data" >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo "group = www-data" >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo "listen = 127.0.0.1:9000" >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo "pm = dynamic" >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo "pm.max_children = 20" >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo "pm.start_servers = 2" >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo "pm.min_spare_servers = 1" >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo "pm.max_spare_servers = 3" >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo "clear_env = no" >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo "catch_workers_output = yes" >> /usr/local/etc/php-fpm.d/zz-docker.conf

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

COPY --from=frontend /app/public/build ./public/build

# Verify assets + manifest
RUN echo "=== Copied Build Assets ===" && \
    ls -laR public/build && \
    echo "=== Manifest Check ===" && \
    cat public/build/manifest.json || echo "❌ MANIFEST MISSING"

RUN composer install --no-dev --optimize-autoloader

# Permissions
RUN chown -R www-data:www-data /var/www && \
    chmod -R 755 /var/www && \
    chmod -R 775 storage bootstrap/cache

# Create required directories
RUN mkdir -p /var/log/supervisor /var/run

# Nginx config
RUN rm -f /etc/nginx/sites-enabled/default /etc/nginx/sites-available/default
COPY docker/nginx.conf /etc/nginx/sites-available/laravel.conf
RUN ln -s /etc/nginx/sites-available/laravel.conf /etc/nginx/sites-enabled/

# Supervisor config
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Test configs
RUN nginx -t
RUN php-fpm -t

EXPOSE 8000

COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/conf.d/supervisord.conf"]