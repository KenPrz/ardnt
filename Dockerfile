FROM php:8.3-apache

# Copy Composer into the container
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set PHP mode and configure Apache
ARG PHP_MODE=production

# Set working directory
WORKDIR /var/www/html

# Copy Laravel project files
COPY . .

RUN mv "$PHP_INI_DIR/php.ini-$PHP_MODE" "$PHP_INI_DIR/php.ini" && \
    sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf && \
    apt-get update -y && \
    apt-get install -y unzip && \
    docker-php-ext-install bcmath pdo_mysql && \
    a2enmod rewrite

# Install dependencies and run Laravel artisan commands
RUN composer install && \
    php artisan key:generate && \
    php artisan config:clear && \
    php artisan cache:clear && \
    php artisan storage:link

# Expose the port for php artisan serve
EXPOSE 8000