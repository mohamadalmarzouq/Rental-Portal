#!/bin/bash
set -euo pipefail

cd /var/www/html

PORT="${PORT:-80}"
sed -i "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \\*:.*>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

if [ -n "${RENDER_EXTERNAL_URL:-}" ]; then
    export APP_URL="$RENDER_EXTERNAL_URL"
fi

mkdir -p storage/app \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    public/files \
    public/images

if [ ! -f .env ]; then
    cp .env.example .env
fi

if [ -z "${APP_KEY:-}" ] || [ "${APP_KEY}" = "" ]; then
    if [ -f storage/app/APP_KEY ]; then
        export APP_KEY="$(cat storage/app/APP_KEY)"
    else
        generated="$(php artisan key:generate --show)"
        echo "$generated" > storage/app/APP_KEY
        export APP_KEY="$generated"
    fi
fi

if [ -n "${DB_HOST:-}" ]; then
    echo "Waiting for MySQL at ${DB_HOST}:${DB_PORT:-3306}..."
    for i in $(seq 1 60); do
        if php -r "
            try {
                new PDO(
                    'mysql:host=' . getenv('DB_HOST') . ';port=' . (getenv('DB_PORT') ?: '3306') . ';dbname=' . getenv('DB_DATABASE'),
                    getenv('DB_USERNAME'),
                    getenv('DB_PASSWORD')
                );
                exit(0);
            } catch (Exception \$e) {
                exit(1);
            }
        "; then
            echo "MySQL is ready."
            break
        fi
        if [ "$i" -eq 60 ]; then
            echo "MySQL did not become ready in time."
            exit 1
        fi
        sleep 2
    done

    /usr/local/bin/import-db.sh
fi

if [ ! -d vendor/laravel ]; then
    composer install --no-interaction --prefer-dist --no-dev --no-ansi
fi

php artisan storage:link >/dev/null 2>&1 || true

chown -R www-data:www-data storage bootstrap/cache public/files public/images
chmod -R ug+rwx storage bootstrap/cache

exec "$@"
