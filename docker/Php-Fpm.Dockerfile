FROM php:8.1.0-fpm
RUN apt-get update \
    && docker-php-ext-install pdo pdo_mysql

RUN apt-get clean && apt-get update \
    &&  apt-get install -y --no-install-recommends \
        locales \
        apt-utils \
        git \
        libicu-dev \
        g++ \
        libpng-dev \
        libxml2-dev \
        libzip-dev \
        libonig-dev \
        libxslt-dev \
        unzip \
        libpq-dev \
        wget \
        ca-certificates

RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen  \
    &&  locale-gen

RUN curl -sS https://getcomposer.org/installer | php -- \
    &&  mv composer.phar /usr/local/bin/composer

WORKDIR /var/www/laravel-docker
