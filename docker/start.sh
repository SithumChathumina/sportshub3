#!/bin/bash
set -e

mkdir -p /run/mysqld /var/lib/mysql
chown -R mysql:mysql /run/mysqld /var/lib/mysql

if [ ! -d /var/lib/mysql/mysql ]; then
    mariadb-install-db --user=mysql --datadir=/var/lib/mysql >/dev/null
fi

mysqld_safe --user=mysql --datadir=/var/lib/mysql --bind-address=127.0.0.1 &

for attempt in $(seq 1 30); do
    if mysqladmin ping --silent; then
        break
    fi
    if [ "$attempt" -eq 30 ]; then
        echo "MariaDB did not start in time"
        exit 1
    fi
    sleep 1
done

mysql -u root -e "CREATE DATABASE IF NOT EXISTS sportshub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; CREATE USER IF NOT EXISTS 'sportshub'@'localhost' IDENTIFIED BY 'sportshub'; GRANT ALL PRIVILEGES ON sportshub.* TO 'sportshub'@'localhost'; FLUSH PRIVILEGES;"

if ! mysql -u root sportshub -e "SHOW TABLES LIKE 'users';" | grep -q users; then
    mysql -u root < /var/www/html/database/sportshub.sql
fi

apache2-foreground
