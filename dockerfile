FROM php:7.2.2-apache

RUN a2enmod rewrite

RUN apt-get update

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

ADD ./php /var/www/html/


