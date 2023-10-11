FROM php:7.4-apache

RUN apt-get update -y
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install mysqli
RUN chown -R www-data:www-data /var/www/
