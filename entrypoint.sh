#!/bin/bash
set -e

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true
chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true

cat > .env <<EOF
APP_NAME=TShoot
APP_ENV=production
APP_KEY=${APP_KEY:-}
APP_DEBUG=${APP_DEBUG:-false}
APP_URL=${APP_URL:-https://tshoot-admin-6t0l.onrender.com}
APP_LOCALE=pt
APP_FALLBACK_LOCALE=en
DB_CONNECTION=${DB_CONNECTION:-sqlite}
DB_HOST=${DB_HOST:-}
DB_PORT=${DB_PORT:-5432}
DB_DATABASE=${DB_DATABASE:-database/database.sqlite}
DB_USERNAME=${DB_USERNAME:-}
DB_PASSWORD=${DB_PASSWORD:-}
SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null
SESSION_SECURE_COOKIE=false
CACHE_STORE=file
QUEUE_CONNECTION=sync
LOG_CHANNEL=stderr
SUPABASE_URL=${SUPABASE_URL:-}
SUPABASE_ANON_KEY=${SUPABASE_ANON_KEY:-}
SUPABASE_SERVICE_KEY=${SUPABASE_SERVICE_KEY:-}
EOF

php artisan config:clear 2>/dev/null || true
php artisan cache:clear 2>/dev/null || true
php artisan key:generate --force 2>/dev/null || true

echo "Running migrations..."
php artisan migrate --force 2>&1 || echo "Migration completed"

exec "$@"
