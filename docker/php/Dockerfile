FROM php:8.4-fpm-alpine3.24

COPY --from=composer:2.10.3 /usr/bin/composer /usr/bin/composer

RUN apk add --no-cache --virtual .build-deps \
        linux-headers \
        util-linux-dev \
        icu-dev \
        ${PHPIZE_DEPS} \
    && docker-php-ext-install intl pdo_mysql \
    && apk del .build-deps \
    && apk add --no-cache icu

WORKDIR /var/www/html
