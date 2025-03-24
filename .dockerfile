FROM php:8.2-fpm

WORKDIR /var/www/html

COPY . .

RUN apt-get update && apt-get install -y nginx

CMD service nginx start && php-fpm
