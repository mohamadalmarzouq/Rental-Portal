#!/bin/bash
set -euo pipefail

cd /var/www/html

PORT="${PORT:-80}"
# Only rewrite port 80. Replacing every Listen line also rewrites 443 and Apache exits.
sed -i "s/^Listen 80$/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \\*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

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

# Apache/mod_php often ignores container env and reads .env instead.
php -r '
$keys = [
    "APP_NAME","APP_ENV","APP_KEY","APP_DEBUG","APP_URL",
    "DB_CONNECTION","DB_HOST","DB_PORT","DB_DATABASE","DB_USERNAME","DB_PASSWORD",
    "CACHE_DRIVER","SESSION_DRIVER","SESSION_LIFETIME","QUEUE_CONNECTION",
    "MAIL_DRIVER","LOG_CHANNEL",
];
$path = ".env";
$env = file_exists($path) ? file_get_contents($path) : "";
foreach ($keys as $k) {
    $v = getenv($k);
    if ($v === false || $v === "") {
        continue;
    }
    $line = $k . "=" . (preg_match("/[\s#\"\\\\]/", $v) ? "\"" . str_replace(["\\\\", "\""], ["\\\\\\\\", "\\\""], $v) . "\"" : $v);
    if (preg_match("/^{$k}=.*/m", $env)) {
        $env = preg_replace("/^{$k}=.*/m", $line, $env);
    } else {
        $env = rtrim($env) . "\n" . $line . "\n";
    }
}
file_put_contents($path, $env);
'

if [ -n "${DB_HOST:-}" ]; then
    echo "Waiting for MySQL at ${DB_HOST}:${DB_PORT:-3306}..."
    for i in $(seq 1 90); do
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
        if [ "$i" -eq 90 ]; then
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
