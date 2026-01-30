#!/bin/bash
set -e

echo "🚀 Starting Laravel application..."

# Wait for database if needed
if [ ! -z "$MYSQLHOST" ]; then
    echo "⏳ Waiting for MySQL..."
    until nc -z -v -w30 $MYSQLHOST $MYSQLPORT 2>/dev/null
    do
        echo "Waiting for database connection..."
        sleep 2
    done
    echo "✅ Database is ready!"
fi

# Run migrations
echo "🔄 Running migrations..."
php artisan migrate --force --no-interaction || echo "⚠️  Migration failed or already up to date"

# Clear and cache config
echo "🔧 Optimizing Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Application ready!"

# Execute CMD
exec "$@"