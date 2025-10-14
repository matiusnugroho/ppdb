#!/usr/bin/env bash
set -euo pipefail

PORT_VALUE=${PORT:-8080}
export PORT=${PORT_VALUE}

# Render expects the service to listen on $PORT. Build the nginx config on each boot.
envsubst '$PORT' < /etc/nginx/templates/ppdb.conf.template > /etc/nginx/conf.d/default.conf

# Ensure runtime directories exist with correct ownership.
mkdir -p /run/php
chown www-data:www-data /run/php

mkdir -p /var/run/mysqld
chown mysql:mysql /var/run/mysqld

if [ ! -d "/var/lib/mysql/mysql" ]; then
    echo "Initializing MySQL data directory"
    mysqld --initialize-insecure --user=mysql
fi

exec /usr/bin/supervisord -n -c /etc/supervisor/supervisord.conf
