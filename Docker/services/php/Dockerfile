FROM php:8.0-apache

# Install the PHP PDO extension
RUN docker-php-ext-install pdo pdo_mysql

# Install mysqli 
RUN apt-get update && apt-get install -y libmcrypt-dev \
    && docker-php-ext-install mysqli


# Expose the port the app runs on
EXPOSE 80

# Command to run the application
CMD ["php", "-S", ]