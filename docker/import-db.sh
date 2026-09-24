#!/bin/bash
set -euo pipefail

if [ -z "${DB_HOST:-}" ] || [ -z "${DB_DATABASE:-}" ] || [ -z "${DB_USERNAME:-}" ]; then
    echo "Skipping database import: DB_HOST/DB_DATABASE/DB_USERNAME not set."
    exit 0
fi

export MYSQL_PWD="${DB_PASSWORD:-}"

mysql_cmd=(mysql --host="$DB_HOST" --port="${DB_PORT:-3306}" --user="$DB_USERNAME" --database="$DB_DATABASE" --protocol=tcp)

if "${mysql_cmd[@]}" -e "SELECT 1 FROM users LIMIT 1" >/dev/null 2>&1; then
    echo "Database already has data. Skipping dump import."
else
    echo "Importing Cubix dump and schema patch..."
    "${mysql_cmd[@]}" < /var/www/html/SQLBackups/07-05-2020.sql
    "${mysql_cmd[@]}" < /var/www/html/docker/mysql-init/02-schema-patch.sql
    echo "Database import finished."
fi

echo "Ensuring known test logins..."
"${mysql_cmd[@]}" < /var/www/html/docker/mysql-init/03-ensure-test-users.sql
unset MYSQL_PWD
