#!/bin/bash
set -e

# Prevent double execution
if [ -f /tmp/.deployment-complete ]; then
    echo "⚠️  Deployment already completed, skipping..."
    exec "$@"
fi

echo "========================================="
echo "🚀 Laravel Deployment Starting..."
echo "========================================="
echo "Environment: $APP_ENV"
echo "PHP Version: $(php -v | head -n 1)"
echo "Laravel Version: $(php artisan --version)"

# Wait for database
if [ ! -z "$DB_HOST" ]; then
    echo ""
    echo "⏳ Waiting for database at $DB_HOST:$DB_PORT..."
    
    max_attempts=30
    attempt=0
    
    until nc -z -w5 $DB_HOST $DB_PORT 2>&1 || [ $attempt -eq $max_attempts ]; do
        attempt=$((attempt+1))
        echo "Attempt $attempt/$max_attempts: Waiting for database..."
        sleep 2
    done
    
    if [ $attempt -eq $max_attempts ]; then
        echo "❌ Database connection timeout"
        exit 1
    fi
    
    echo "✅ Database port is open!"
    
    # Wait a bit more for MySQL to be fully ready
    sleep 5
fi

# Test database connection with retry
echo ""
echo "🔍 Testing database connection..."
max_db_attempts=10
db_attempt=0

until php artisan db:show 2>/dev/null || [ $db_attempt -eq $max_db_attempts ]; do
    db_attempt=$((db_attempt+1))
    echo "Database test attempt $db_attempt/$max_db_attempts..."
    sleep 3
done

if [ $db_attempt -eq $max_db_attempts ]; then
    echo "⚠️  Could not verify database connection, proceeding anyway..."
else
    echo "✅ Database connection verified"
fi

# Run migrations
echo ""
echo "🔄 Running database migrations..."
php artisan migrate --force --no-interaction || echo "⚠️  Migration warning (might be normal)"

# Storage link
echo ""
echo "🔗 Creating storage link..."
php artisan storage:link --force || echo "⚠️  Storage link exists"

# Optimize
echo ""
echo "🔧 Optimizing application..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
# Test PHP-FPM
echo ""
echo "🔍 Testing PHP-FPM..."
if command -v php-fpm 2>&1 | grep -q "php-fpm"; then
    echo "✅ PHP-FPM binary found"
else
    echo "❌ PHP-FPM binary NOT found"
fi

# Create test PHP file
echo "<?php phpinfo(); ?>" > /var/www/public/test.php
echo "✅ Created test.php"

echo ""
echo "========================================="
echo "✅ Deployment Complete!"
echo "========================================="

touch /tmp/.deployment-complete
exec "$@"