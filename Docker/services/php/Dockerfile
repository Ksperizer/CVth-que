FROM php:8.0-fpm

# Install the PHP PDO extension
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Install mysqli 
RUN apt-get update && apt-get install -y libmcrypt-dev \
    && docker-php-ext-install mysqli
