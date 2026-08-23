FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    libonig-dev \
    libssl-dev \
    zip unzip curl \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install \
        gd \
        mbstring \
        pdo_mysql \
        mysqli \
        zip \
        soap \
        intl \
        opcache \
        fileinfo \
        exif

RUN a2enmod rewrite

COPY apache.conf /etc/apache2/sites-available/000-default.conf
COPY php.ini     /usr/local/etc/php/conf.d/bitrix.ini

RUN chown -R www-data:www-data /var/www/html

WORKDIR /var/www/html
