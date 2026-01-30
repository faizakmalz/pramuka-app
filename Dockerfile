# ===============================
# FRONTEND (Vite / Node 20)
# ===============================
FROM node:20-alpine AS frontend

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY resources ./resources
COPY vite.config.js ./
COPY tailwind.config.js ./
COPY postcss.config.js ./
COPY public ./public

RUN npm run build


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

# PHP-FPM configuration
RUN echo "listen = 127.0.0.1:9000" > /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo "pm = dynamic" >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo "pm.max_children = 50" >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo "pm.start_servers = 5" >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo "pm.min_spare_servers = 5" >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo "pm.max_spare_servers = 35" >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo "clear_env = no" >> /usr/local/etc/php-fpm.d/zz-docker.conf

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .
COPY --from=frontend /app/public/build ./public/build

RUN composer install --no-dev --optimize-autoloader

# Permissions
RUN chown -R www-data:www-data /var/www && \
    chmod -R 755 /var/www && \
    chmod -R 775 storage bootstrap/cache

# Nginx config
RUN rm -f /etc/nginx/sites-enabled/default
COPY docker/nginx.conf /etc/nginx/sites-available/laravel
RUN ln -s /etc/nginx/sites-available/laravel /etc/nginx/sites-enabled/

# Supervisor config
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Verify configs
RUN nginx -t && php-fpm -t

EXPOSE 8000

COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]