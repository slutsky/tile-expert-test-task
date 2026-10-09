FROM php:8.4-fpm-alpine3.24

ARG USER_ID=1000

ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS=0

COPY --from=composer:2.10.3 /usr/bin/composer /usr/bin/composer
COPY --from=gordalina/cachetool:9.2.1 /usr/local/bin/cachetool /usr/bin/cachetool

RUN apk add --no-cache --virtual .build-deps \
        linux-headers util-linux-dev icu-dev libxml2-dev \
        ${PHPIZE_DEPS} \
    && pecl install xdebug-3.5.3 \
    && docker-php-ext-install intl pdo_mysql pcntl soap \
    && docker-php-ext-enable xdebug \
    && pecl clear-cache \
    && apk del .build-deps \
    && apk add --no-cache icu libxml2 \
    && mkdir -p /var/www/html/config/ \
    && echo '<?php' > /var/www/html/config/preload.php \
    && {\
        echo 'zend_extension=opcache';\
        echo 'opcache.enable=1';\
        echo 'opcache.enable_cli=1';\
        echo 'opcache.preload=/var/www/html/config/preload.php';\
        echo 'opcache.preload_user=www-user';\
        echo 'opcache.memory_consumption=256';\
        echo 'opcache.max_accelerated_files=20000';\
        echo 'opcache.validate_timestamps=${PHP_OPCACHE_VALIDATE_TIMESTAMPS:-0}';\
    } > ${PHP_INI_DIR}/conf.d/docker-php-ext-opcache.ini\
    && apk add --no-cache shadow \
    && usermod -u ${USER_ID} www-data \
    && apk del shadow

USER www-data:www-data

WORKDIR /var/www/html
