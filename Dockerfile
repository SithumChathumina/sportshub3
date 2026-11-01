FROM php:8.3-apache-bookworm

RUN apt-get update \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y mariadb-server mariadb-client \
    && docker-php-ext-install pdo_mysql mysqli \
    && a2enmod rewrite \
    && sed -i 's/Listen 80/Listen 3000/' /etc/apache2/ports.conf \
    && sed -i 's/<VirtualHost \*:80>/<VirtualHost *:3000>/' /etc/apache2/sites-available/000-default.conf \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html
COPY . /var/www/html
COPY docker/start.sh /usr/local/bin/start-sportshub
RUN chmod +x /usr/local/bin/start-sportshub

ENV DB_HOST=127.0.0.1 \
    DB_PORT=3306 \
    DB_NAME=sportshub \
    DB_USER=sportshub \
    DB_PASS=sportshub

EXPOSE 3000
CMD ["/usr/local/bin/start-sportshub"]
