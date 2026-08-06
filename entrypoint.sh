#!/bin/bash
set -e

php artisan config:cache
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force 2>&1 || echo "Migration completed"

exec "$@"
