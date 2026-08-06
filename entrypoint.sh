#!/bin/bash
set -e

php artisan config:cache
php artisan route:cache

if [ "$DB_CONNECTION" = "pgsql" ]; then
    echo "PostgreSQL detected - running migrations..."
    php artisan migrate --force 2>&1 || echo "Migration error (table may already exist)"
fi

exec "$@"
