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
    libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install \
        pdo_mysql pdo_pgsql \
        mbstring exif pcntl bcmath gd zip \
        intl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy app source
COPY . .

# Copy built assets from frontend
COPY --from=frontend /app/public/build ./public/build

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Permission fix
RUN chown -R www-data:www-data storage bootstrap/cache public && \
    chmod -R 755 storage bootstrap/cache public

# Copy Nginx config
RUN rm /etc/nginx/sites-enabled/default
COPY docker/nginx.conf /etc/nginx/sites-available/default
RUN ln -s /etc/nginx/sites-available/default /etc/nginx/sites-enabled/

# Copy Supervisor config
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 8000

# Entrypoint untuk setup runtime
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]