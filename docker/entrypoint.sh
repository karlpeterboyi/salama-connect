#!/bin/sh
set -e

cd /var/www/html

# Ensure storage dirs exist
mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache
chmod -R 775 storage bootstrap/cache 2>/dev/null || true

# APP_KEY: use Render-generated value, or create one
if [ -z "$APP_KEY" ]; then
  export APP_KEY="base64:$(openssl rand -base64 32)"
  echo "Generated temporary APP_KEY"
fi

# Render Postgres requires SSL
export DB_SSLMODE="${DB_SSLMODE:-require}"
export PGSSLMODE="${PGSSLMODE:-require}"

# Wait for database (up to ~60s)
echo "Waiting for database..."
i=0
while [ $i -lt 30 ]; do
  if php -r "
    try {
      \$h = getenv('DB_HOST') ?: '127.0.0.1';
      \$p = getenv('DB_PORT') ?: '5432';
      \$d = getenv('DB_DATABASE') ?: 'salama';
      \$u = getenv('DB_USERNAME') ?: 'salama';
      \$w = getenv('DB_PASSWORD') ?: '';
      new PDO(
        \"pgsql:host=\$h;port=\$p;dbname=\$d;sslmode=require\",
        \$u, \$w,
        [PDO::ATTR_TIMEOUT => 3]
      );
      exit(0);
    } catch (Throwable \$e) {
      exit(1);
    }
  "; then
    echo "Database is ready."
    break
  fi
  i=$((i + 1))
  echo "  attempt $i/30..."
  sleep 2
done

# Discover packages (safe after env is set)
php artisan package:discover --ansi 2>/dev/null || true

php artisan config:clear 2>/dev/null || true
php artisan storage:link 2>/dev/null || true

echo "Running migrations..."
if ! php artisan migrate --force --no-interaction; then
  echo "WARNING: migrate failed — starting app anyway so logs are visible"
fi

echo "Seeding (if needed)..."
php artisan db:seed --force --class=Database\\Seeders\\SalamaSeeder --no-interaction 2>/dev/null || true

php artisan config:cache 2>/dev/null || true
php artisan route:cache 2>/dev/null || true
php artisan view:cache 2>/dev/null || true

PORT="${PORT:-10000}"
echo "Starting server on 0.0.0.0:${PORT}"
exec php -S "0.0.0.0:${PORT}" -t public
