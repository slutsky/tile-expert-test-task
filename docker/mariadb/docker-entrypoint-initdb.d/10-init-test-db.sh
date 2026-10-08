#!/bin/sh
set -e

if [ -n "${MARIADB_ROOT_PASSWORD}" ] || [ -n "${MARIADB_DATABASE}" ] || [ -n "${MARIADB_USER}" ]; then
    mariadb --abort-source-on-error --user=root --password="${MARIADB_ROOT_PASSWORD}" <<-EOSQL
        CREATE DATABASE \`${MARIADB_DATABASE}_test\`;
        GRANT ALL PRIVILEGES ON \`${MARIADB_DATABASE}_test\`.* TO '${MARIADB_USER}'@'%';
        FLUSH PRIVILEGES;
EOSQL
fi
