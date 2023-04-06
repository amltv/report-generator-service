FROM php:8.2-cli-alpine3.17

RUN apk update && \
    apk add \
            libpq-dev

RUN docker-php-source extract && \
    docker-php-ext-install pdo pdo_pgsql && \
    docker-php-ext-enable pdo pdo_pgsql && \
    docker-php-source delete
