#!/bin/bash
set -e

echo "========================================="
echo "🚀 Laravel Deployment Starting..."
echo "========================================="

# Print environment info
echo "Environment: $APP_ENV"
echo "PHP Version: $(php -v | head -n 1)"
echo "Laravel Version: $(php artisan --version)"

# Wait for database
if [ ! -z "$DB_HOST" ]; then
    echo ""
    echo "⏳ Waiting for database at $DB_HOST:$DB_PORT..."
    echo "🔍 Debug Info:"
    echo "   DB_CONNECTION: $DB_CONNECTION"
    echo "   DB_HOST: $DB_HOST"
    echo "   DB_PORT: $DB_PORT"
    echo "   DB_DATABASE: $DB_DATABASE"
    echo "   DB_USERNAME: $DB_USERNAME"
    
    # Test DNS resolution
    echo ""
    echo "🔍 Testing DNS resolution..."
    if command -v nslookup &> /dev/null; then
        nslookup $DB_HOST || echo "⚠️  DNS lookup failed"
    fi
    
    echo ""
    echo "🔍 Testing connectivity..."
    max_attempts=30
    attempt=0
    
    until nc -z -v -w5 $DB_HOST $DB_PORT 2>&1 | tee /tmp/nc_output.txt || [ $attempt -eq $max_attempts ]; do
        attempt=$((attempt+1))
        echo "Attempt $attempt/$max_attempts: Database not ready"
        cat /tmp/nc_output.txt 2>/dev/null
        sleep 2
    done
    
    if [ $attempt -eq $max_attempts ]; then
        echo ""
        echo "❌ ERROR: Could not connect to database after $max_attempts attempts"
        echo ""
        echo "🔧 Troubleshooting:"
        echo "1. Check MySQL service is running in Railway"
        echo "2. Verify Private Network is enabled on BOTH services"
        echo "3. Check service reference name (mysql.railway.internal)"
        echo "4. Verify DB_HOST variable value"
        echo ""
        echo "Current DB_HOST: $DB_HOST"
        echo "Current DB_PORT: $DB_PORT"
        exit 1
    fi
    
    echo "✅ Database port is open!"
fi

# Test database connection
echo ""
echo "🔍 Testing database connection..."
if php artisan db:show 2>/dev/null; then
    echo "✅ Database accessible"
else
    echo "⚠️  Database test failed (might be normal if tables don't exist yet)"
fi

# Run migrations
echo ""
echo "🔄 Running database migrations..."
if php artisan migrate --force --no-interaction; then
    echo "✅ Migrations completed successfully"
else
    echo "⚠️  Migration failed or already up to date"
fi

# Storage link
echo ""
echo "🔗 Creating storage link..."
if php artisan storage:link --force; then
    echo "✅ Storage linked"
else
    echo "⚠️  Storage link failed (might already exist)"
fi

# Clear and cache config
echo ""
echo "🔧 Optimizing application..."
php artisan config:clear
php artisan route:clear
php artisan view:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Optimization completed"

# Print final status
echo ""
echo "========================================="
echo "✅ Application Ready!"
echo "========================================="
echo "Listening on port: 8000"
echo ""

# Execute CMD
exec "$@"