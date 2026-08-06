#!/bin/bash
set -e

php artisan config:cache
php artisan route:cache

if [ "$DB_CONNECTION" = "pgsql" ]; then
    echo "PostgreSQL detected - running migrations..."
    php artisan migrate --force
else
    echo "SQLite detected - using local database..."
    touch database/database.sqlite
    php artisan migrate --force
    if [ "$(php artisan tinker --execute='echo \App\Models\Banner::count();' 2>/dev/null)" = "0" ]; then
        php artisan db:seed --force
    fi
fi

exec "$@"
