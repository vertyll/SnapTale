#!/bin/sh
set -e

export PATH="/usr/local/bin:/usr/bin:/bin:$PATH"

echo "Starting Laravel application setup..."

# Check required environment variables
if [ -z "$DB_HOST" ] || [ -z "$DB_PORT" ]; then
  echo "Error: DB_HOST or DB_PORT is not set."
  exit 1
fi

# Wait for database
echo "Waiting for database at $DB_HOST:$DB_PORT..."
TIMEOUT=60
ELAPSED=0

while ! /usr/bin/nc -z "$DB_HOST" "$DB_PORT" 2>/dev/null; do
  if [ $ELAPSED -ge $TIMEOUT ]; then
    echo "Error: Database connection timeout after ${TIMEOUT}s"
    exit 1
  fi
  echo "Database is unavailable - sleeping (${ELAPSED}/${TIMEOUT}s)"
  /bin/sleep 2
  ELAPSED=$((ELAPSED + 2))
done

echo "Database is up - running migrations"

cd /var/www/html

# Run migrations
php artisan migrate --force

# Clear and cache config
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage link if it doesn't exist
if [ ! -L public/storage ]; then
  php artisan storage:link
fi

echo "Application setup completed successfully"
echo "Starting services..."

exec "$@"