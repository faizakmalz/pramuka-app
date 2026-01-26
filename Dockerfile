# ===============================
# FRONTEND (Vite / Node 20)
# ===============================
FROM node:20-alpine AS frontend

WORKDIR /app

# Copy package files
COPY package*.json ./
RUN npm install

# PENTING: Copy SEMUA file config yang dibutuhkan Vite + Tailwind
COPY resources ./resources
COPY vite.config.js ./
COPY tailwind.config.js ./
COPY postcss.config.js ./
COPY public ./public

# Build assets
RUN npm run build

# Verify build succeeded
RUN ls -la public/build


# ===============================
# BACKEND (Laravel PHP 8.2)
# ===============================
FROM php:8.2-fpm

# Install system dependencies + nginx + supervisor
RUN apt-get update && apt-get install -y \
    git unzip curl zip \
    libpng-dev libonig-dev libxml2-dev \
    libpq-dev default-mysql-client \
    libzip-dev nginx supervisor \
    && docker-php-ext-install \
        pdo_mysql pdo_pgsql \
        mbstring exif pcntl bcmath gd zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy app source
COPY . .

# Copy built assets from frontend stage
COPY --from=frontend /app/public/build ./public/build

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Permission fix
RUN chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 755 storage bootstrap/cache public/build

# Copy Nginx config
RUN rm /etc/nginx/sites-enabled/default
COPY docker/nginx.conf /etc/nginx/sites-available/default
RUN ln -s /etc/nginx/sites-available/default /etc/nginx/sites-enabled/

# Copy Supervisor config
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 8000

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
