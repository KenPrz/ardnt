FROM php:8.3-apache

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

ARG PHP_MODE

RUN mv "$PHP_INI_DIR/php.ini-$PHP_MODE" "$PHP_INI_DIR/php.ini" && \
    sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf && \
    apt-get update -y && \
    apt-get install -y unzip && \
    docker-php-ext-install bcmath pdo_mysql && \
    a2enmod rewrite


RUN composer install \
    php artisan key:generate \
    php artisan config:clear \
    php artisan cache:clear \
    # docker-compose exec web bash
    # php artisan migrate:fresh --seed
# Install Node.js and npm
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash - && \
    apt-get install -y nodejs
# Set working directory
WORKDIR /var/www/html
# Expose the port for php artisan serve
EXPOSE 8000