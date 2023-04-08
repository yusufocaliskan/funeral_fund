FROM php:7.4-fpm-alpine
COPY ../php/php.ini /usr/local/etc/php/
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql
