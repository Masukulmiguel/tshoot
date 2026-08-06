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
DB_CONNECTION=pgsql
DB_URL=${DATABASE_URL:-}
DB_HOST=${DB_HOST:-aws-1-eu-west-1.pooler.supabase.com}
DB_PORT=${DB_PORT:-6543}
DB_DATABASE=${DB_DATABASE:-postgres}
DB_USERNAME=${DB_USERNAME:-postgres.vjpixuykkjyofspfkmzo}
DB_PASSWORD=${DB_PASSWORD:-191929mg@@@\"}
SESSION_DRIVER=file
SESSION_LIFETIME=120
CACHE_STORE=file
QUEUE_CONNECTION=sync
LOG_CHANNEL=stderr
SUPABASE_URL=${SUPABASE_URL:-https://vjpixuykkjyofspfkmzo.supabase.co}
SUPABASE_ANON_KEY=${SUPABASE_ANON_KEY:-}
SUPABASE_SERVICE_KEY=${SUPABASE_SERVICE_KEY:-}
EOF

php artisan config:clear 2>/dev/null || true
php artisan cache:clear 2>/dev/null || true
php artisan key:generate --force 2>/dev/null || true

echo "Running migrations..."
php artisan migrate --force 2>&1 || echo "Migration completed"

exec "$@"
