ARG PHP_VERSION=7.4-fpm-alpine
ARG COMPOSER_VERSION=latest

FROM composer:${COMPOSER_VERSION} AS base_composer
FROM php:${PHP_VERSION}

WORKDIR /app

COPY --from=base_composer /usr/bin/composer /usr/bin/composer

ADD composer.json composer.lock symfony.lock .env ./
RUN composer install --no-ansi --no-interaction --classmap-authoritative --no-scripts

COPY bin bin/
COPY config config/
COPY public public/
COPY src src/

ENV SHELL_VERBOSITY 1
ENV APP_ENV dev
ENV APP_DEBUG 1
