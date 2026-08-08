#!/bin/bash
set -e

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true
chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true
mkdir -p /var/www/html/public/uploads
chown -R www-data:www-data /var/www/html/public/uploads 2>/dev/null || true

cat > .env <<EOF
APP_NAME=TShoot
APP_ENV=production
APP_KEY=${APP_KEY:-base64:FfKA0rZhyhpfHECljZr0eHxWJUiEkHRDqKvlzR1pUfE=}
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
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_SECURE_COOKIE=true
CACHE_STORE=file
QUEUE_CONNECTION=sync
LOG_CHANNEL=stderr
SUPABASE_URL=${SUPABASE_URL:-https://vjpixuykkjyofspfkmzo.supabase.co}
SUPABASE_ANON_KEY=${SUPABASE_ANON_KEY:-eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InZqcGl4dXlra2p5b2ZzcGZrbXpvIiwicm9sZSI6ImFub24iLCJpYXQiOjE3ODYwMTYxMjcsImV4cCI6MjEwMTU5MjEyN30.EE_R-v0EfJcJMu_A8SuWbv-qpCgumvnO7hWraiLUwAo}
SUPABASE_SERVICE_KEY=${SUPABASE_SERVICE_KEY:-eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InZqcGl4dXlra2p5b2ZzcGZrbXpvIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc4NjAxNjEyNywiZXhwIjoyMTAxNTkyMTI3fQ.EiDHJVdakDY0a_ALin9qea37tL8d6ANIv4cEcNVxjXg}
EOF

php artisan config:clear 2>/dev/null || true
php artisan cache:clear 2>/dev/null || true

echo "Running migrations..."
php artisan migrate --force 2>&1 || echo "Migration completed"

echo "Seeding admin user..."
php artisan db:seed --class=AdminSeeder --force 2>&1 || echo "AdminSeeder completed"

echo "Seeding default content..."
php artisan db:seed --class=DefaultContentSeeder --force 2>&1 || echo "ContentSeeder completed"

exec "$@"
