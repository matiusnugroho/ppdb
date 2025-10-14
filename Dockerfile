# syntax=docker/dockerfile:1
FROM ubuntu:24.04

ENV DEBIAN_FRONTEND=noninteractive \
    PORT=8080

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        software-properties-common \
        ca-certificates \
        curl \
        gnupg \
        lsb-release \
        unzip \
        supervisor \
        nginx \
        mysql-server \
        gettext-base \
    && add-apt-repository ppa:ondrej/php \
    && apt-get update \
    && apt-get install -y --no-install-recommends \
        php8.4-fpm \
        php8.4-cli \
        php8.4-mbstring \
        php8.4-xml \
        php8.4-curl \
        php8.4-mysql \
        php8.4-zip \
        php8.4-bcmath \
        php8.4-gd \
    && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN mkdir -p /etc/nginx/templates /run/php \
    && rm -f /etc/nginx/sites-enabled/default /etc/nginx/sites-available/default

WORKDIR /var/www/html

COPY . /var/www/html

RUN composer install --no-dev --no-interaction --prefer-dist --no-scripts \
    && chown -R www-data:www-data storage bootstrap/cache

COPY docker/nginx.conf /etc/nginx/templates/ppdb.conf.template
COPY docker/supervisord.conf /etc/supervisor/conf.d/ppdb.conf
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh

RUN chmod +x /usr/local/bin/entrypoint.sh \
    && ln -sf /dev/stdout /var/log/nginx/access.log \
    && ln -sf /dev/stderr /var/log/nginx/error.log

EXPOSE 8080

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
