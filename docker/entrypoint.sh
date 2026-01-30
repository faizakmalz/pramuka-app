#!/bin/bash
set -e

echo "========================================="
echo "🚀 Laravel Deployment Starting..."
echo "========================================="
echo "Environment: $APP_ENV"
echo "PHP Version: $(php -v | head -n 1)"
echo "Laravel Version: $(php artisan --version)"

echo "========================================="
echo "🚀 Laravel Deployment Starting..."
echo "========================================="

# Validate Vite manifest
echo ""
echo "🔍 Checking Vite manifest..."
if [ ! -f "/var/www/public/build/manifest.json" ]; then
    echo "❌ ERROR: manifest.json not found!"
    echo "Build directory contents:"
    ls -la /var/www/public/build/ || echo "Build directory missing!"
    exit 1
fi
echo "✅ Manifest found!"

# Wait for database
if [ ! -z "$DB_HOST" ]; then
    echo ""
    echo "⏳ Waiting for database at $DB_HOST:$DB_PORT..."
    
    max_attempts=30
    attempt=0
    
    until nc -z -w5 $DB_HOST $DB_PORT || [ $attempt -eq $max_attempts ]; do
        attempt=$((attempt+1))
        echo "Attempt $attempt/$max_attempts..."
        sleep 2
    done
    
    if [ $attempt -eq $max_attempts ]; then
        echo "❌ Database timeout"
        exit 1
    fi
    
    echo "✅ Database port is open!"
    sleep 2
fi

# Database connection test
echo ""
echo "🔍 Testing database connection..."
php artisan db:show || echo "⚠️  DB test skipped"

# Migrations
echo ""
echo "🔄 Running migrations..."
php artisan migrate --force || echo "⚠️  Migration skipped"

# Storage link
echo ""
echo "🔗 Storage link..."
php artisan storage:link --force || true

# Clear all caches
echo ""
echo "🧹 Clearing caches..."
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true
php artisan cache:clear || true

echo ""
echo "========================================="
echo "✅ Starting Services..."
echo "========================================="
echo ""

# Start supervisord in foreground
exec "$@"