FROM php:7.2.2-apache

RUN a2enmod rewrite

RUN apt-get update

RUN apt-get install wget

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

ADD ./php /var/www/html/

RUN wget -O phpunit https://phar.phpunit.de/phpunit-7.phar

RUN chmod +x phpunit