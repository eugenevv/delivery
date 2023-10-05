FROM php:7.4-fpm-alpine

RUN apk update \
    && apk add git

RUN apk --no-cache add postgresql-dev

RUN docker-php-ext-install pgsql pdo pdo_pgsql

RUN apk update \
    && apk add mc

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

WORKDIR /var/www