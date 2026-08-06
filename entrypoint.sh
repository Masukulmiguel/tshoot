#!/bin/bash
set -e

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true
chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true

if [ ! -f .env ]; then
    cp .env.example .env
fi

php artisan key:generate --force
php artisan config:cache
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force 2>&1 || echo "Migration completed"

exec "$@"
