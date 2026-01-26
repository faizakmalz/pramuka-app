# ===============================
# FRONTEND (Vite / Node 20)
# ===============================
FROM node:20-alpine AS frontend

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY resources ./resources
COPY vite.config.* ./
RUN npm run build


# ===============================
# BACKEND (Laravel PHP 8.2)
# ===============================
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip zip curl \
    libpng-dev libonig-dev libxml2-dev \
    libpq-dev default-mysql-client \
    && docker-php-ext-install \
        pdo_mysql pdo_pgsql \
        mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy app source
COPY . .

# Copy built assets
COPY --from=frontend /app/public/build ./public/build

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Permission fix
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
