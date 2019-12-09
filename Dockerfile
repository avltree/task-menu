FROM php:7.3-alpine

RUN apk update && apk add bash postgresql-dev && \
    docker-php-ext-install pdo_pgsql
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN mkdir /menu
WORKDIR /menu

CMD ["php", "-a"]
