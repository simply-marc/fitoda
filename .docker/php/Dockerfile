FROM php:8.3.4RC1-zts-bullseye

WORKDIR /app

RUN apt update -y

RUN apt install unzip

RUN docker-php-ext-install pdo pdo_mysql mysqli

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
