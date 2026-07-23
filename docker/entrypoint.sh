#!/bin/sh
set -e
cd /app

mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache
chmod -R 775 storage bootstrap/cache || true

echo "Running migrations..."
php artisan migrate --force

echo "Seeding database..."
php artisan db:seed --force || true

echo "Linking storage..."
php artisan storage:link || true

echo "Clearing / rebuilding caches..."
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true
php artisan cache:clear || true
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Background queue worker — order confirmation mail must not run in the HTTP request.
# php artisan serve never flushes before terminating callbacks, so sync SMTP blocks checkout.
echo "Starting queue worker..."
php artisan queue:work database --sleep=1 --tries=2 --timeout=30 --memory=128 >> /proc/1/fd/1 2>&1 &

PORT="${PORT:-8000}"
echo "Starting server on 0.0.0.0:${PORT}..."
exec php artisan serve --host=0.0.0.0 --port="${PORT}"
