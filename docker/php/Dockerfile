FROM php:7.4-fpm

RUN apt update && apt install -y \
    libzip-dev zip unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    curl \
    git \
    && docker-php-ext-install pdo_mysql mbstring zip bcmath

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
