#!/bin/sh
cd /var/www/html

mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache
chmod -R 775 storage bootstrap/cache 2>/dev/null || true

# Laravel requires APP_KEY like base64:xxxx
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "null" ]; then
  export APP_KEY="base64:$(openssl rand -base64 32 | tr -d '\n')"
  echo "Generated APP_KEY"
elif ! echo "$APP_KEY" | grep -q '^base64:'; then
  # Render generateValue may not use base64: prefix — normalize
  export APP_KEY="base64:$(printf '%s' "$APP_KEY" | head -c 32 | openssl base64 -A 2>/dev/null || openssl rand -base64 32 | tr -d '\n')"
  echo "Normalized APP_KEY to base64 format"
fi

export DB_SSLMODE="${DB_SSLMODE:-require}"
export PGSSLMODE="${PGSSLMODE:-require}"
export SESSION_DRIVER="${SESSION_DRIVER:-file}"
export CACHE_STORE="${CACHE_STORE:-file}"
export QUEUE_CONNECTION="${QUEUE_CONNECTION:-sync}"
export LOG_CHANNEL="${LOG_CHANNEL:-stderr}"

php artisan package:discover --ansi 2>/dev/null || true
php artisan storage:link 2>/dev/null || true
php artisan config:clear 2>/dev/null || true
php artisan view:clear 2>/dev/null || true
php artisan route:clear 2>/dev/null || true

echo "Checking database..."
if php -r "
  try {
    \$h = getenv('DB_HOST') ?: '';
    if (\$h === '') { exit(1); }
    \$p = getenv('DB_PORT') ?: '5432';
    \$d = getenv('DB_DATABASE') ?: '';
    \$u = getenv('DB_USERNAME') ?: '';
    \$w = getenv('DB_PASSWORD') ?: '';
    new PDO('pgsql:host='.\$h.';port='.\$p.';dbname='.\$d.';sslmode=require', \$u, \$w, [PDO::ATTR_TIMEOUT => 5]);
    exit(0);
  } catch (Throwable \$e) { exit(1); }
" 2>/dev/null; then
  echo "DB up — migrating..."
  php artisan migrate --force --no-interaction 2>&1 || echo "migrate failed (non-fatal)"
  php artisan db:seed --force --class=Database\\Seeders\\SalamaSeeder --no-interaction 2>&1 || echo "seed failed (non-fatal)"
else
  echo "DB not reachable — skipped migrate/seed"
fi

PORT="${PORT:-10000}"
echo "Starting Laravel on 0.0.0.0:${PORT}"
exec php artisan serve --host=0.0.0.0 --port="${PORT}"
