#!/bin/sh
set -e

# Generate key if missing (Render can also set APP_KEY)
if [ -z "$APP_KEY" ]; then
  php artisan key:generate --force --no-interaction || true
fi

php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true
php artisan storage:link || true

# Migrate + seed (idempotent enough for free tier deploys)
php artisan migrate --force --no-interaction
php artisan db:seed --force --class=Database\\Seeders\\SalamaSeeder --no-interaction || true

# Serve Laravel public directory
exec php -S 0.0.0.0:${PORT:-10000} -t public
