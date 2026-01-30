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
RUN ls -la public/build


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

# Configure PHP-FPM untuk listen di Unix socket
RUN mkdir -p /var/run/php && \
    sed -i 's/listen = .*/listen = \/var\/run\/php\/php8.2-fpm.sock/' /usr/local/etc/php-fpm.d/www.conf && \
    sed -i 's/;listen.owner = .*/listen.owner = www-data/' /usr/local/etc/php-fpm.d/www.conf && \
    sed -i 's/;listen.group = .*/listen.group = www-data/' /usr/local/etc/php-fpm.d/www.conf && \
    sed -i 's/;listen.mode = .*/listen.mode = 0660/' /usr/local/etc/php-fpm.d/www.conf

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .
COPY --from=frontend /app/public/build ./public/build

RUN composer install --no-dev --optimize-autoloader

# Permissions
RUN chown -R www-data:www-data /var/www && \
    chmod -R 755 storage bootstrap/cache public && \
    chmod -R 775 storage bootstrap/cache

# Nginx config
RUN rm /etc/nginx/sites-enabled/default
COPY docker/nginx.conf /etc/nginx/sites-available/default
RUN ln -s /etc/nginx/sites-available/default /etc/nginx/sites-enabled/

# Supervisor config
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 8000

COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]