#!/bin/bash
set -e

# Prevent double execution
if [ -f /tmp/.deployment-complete ]; then
    echo "⚠️  Deployment already completed, starting services..."
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
    sleep 3
fi

# Test database connection
echo ""
echo "🔍 Testing database connection..."
if php artisan db:show 2>/dev/null; then
    echo "✅ Database connection verified"
else
    echo "⚠️  Database test failed, proceeding anyway..."
fi

# Run migrations
echo ""
echo "🔄 Running database migrations..."
php artisan migrate --force --no-interaction || echo "⚠️  Migration warning"

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

echo ""
echo "========================================="
echo "✅ Deployment Complete!"
echo "========================================="

# Mark as complete BEFORE starting services
touch /tmp/.deployment-complete

# Execute services
exec "$@"