# Use an official PHP-FPM image with PHP 8.2
FROM php:8.2-fpm

# Install any PHP extensions you need
RUN docker-php-ext-install pdo pdo_mysql

# Set the working directory
WORKDIR /var/www/html

# Copy your application files to the container
COPY . /var/www/html

# Set permissions for the www-data user (if needed)
RUN chown -R www-data:www-data /var/www/html

# Expose port 9000 for PHP-FPM
EXPOSE 9000
