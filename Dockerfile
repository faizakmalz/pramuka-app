# ===============================
# 1️⃣ Frontend build (Node 20)
# ===============================
FROM node:20-alpine AS frontend
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY resources ./resources
COPY vite.config.* ./
RUN npm run build

# ===============================
# 2️⃣ Backend (PHP 8.2)
# ===============================
FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git unzip libpq-dev \
    libpng-dev libonig-dev libxml2-dev \
    libzip-dev zip curl \
    && docker-php-ext-install \
        pdo_pgsql mbstring exif pcntl bcmath gd zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .
COPY --from=frontend /app/public/build ./public/build

RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-da
