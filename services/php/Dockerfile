FROM php:8.0-fpm

# Install the PHP PDO extension
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Install mysqli 
RUN apt-get update && apt-get install -y libmcrypt-dev \
    && docker-php-ext-install mysqli

# Install Composer from the Composer official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install --no-scripts --no-autoloader

RUN composer dump-autoload --optimize