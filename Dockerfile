ARG PHP_VERSION=8.0.0RC5

FROM php:${PHP_VERSION}-fpm-alpine
LABEL maintainer="renard.yoann@gmail.com"

SHELL ["/bin/ash", "-o", "pipefail", "-c"]

## Install Composer globally
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN \
    curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    /usr/local/bin/composer self-update --preview

WORKDIR /app
