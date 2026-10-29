#!/bin/sh
# Do NOT use set -e — we must start the web server even if migrate fails

cd /var/www/html

mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache
chmod -R 775 storage bootstrap/cache 2>/dev/null || true

if [ -z "$APP_KEY" ]; then
  export APP_KEY="base64:$(openssl rand -base64 32 2>/dev/null || echo 'SalamaConnectKeyChangeMe32bytes!!')"
fi

export DB_SSLMODE="${DB_SSLMODE:-require}"
export PGSSLMODE="${PGSSLMODE:-require}"

# Prefer file drivers so / does not 500 before DB is ready
export SESSION_DRIVER="${SESSION_DRIVER:-file}"
export CACHE_STORE="${CACHE_STORE:-file}"
export QUEUE_CONNECTION="${QUEUE_CONNECTION:-sync}"

php artisan package:discover --ansi 2>/dev/null || true
php artisan storage:link 2>/dev/null || true

# Quick DB check (max ~20s) then migrate — never block server start for long
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
  } catch (Throwable \$e) { fwrite(STDERR, \$e->getMessage()); exit(1); }
" 2>/dev/null; then
  echo "DB up — migrating..."
  php artisan migrate --force --no-interaction 2>&1 || echo "migrate failed (non-fatal)"
  php artisan db:seed --force --class=Database\\Seeders\\SalamaSeeder --no-interaction 2>&1 || true
else
  echo "DB not reachable yet — starting without migrate"
fi

php artisan config:clear 2>/dev/null || true

PORT="${PORT:-10000}"
echo "Starting PHP server on 0.0.0.0:${PORT}"
exec php -S "0.0.0.0:${PORT}" -t public public/index.php
