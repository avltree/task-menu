FROM php:7.4-alpine

RUN apk update && apk add bash
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN mkdir /menu
WORKDIR /menu

CMD ["php", "-a"]
