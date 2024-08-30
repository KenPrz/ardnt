#!/bin/bash

# Install Composer dependencies
docker run --rm \
-u "$(id -u):$(id -g)" \
-v "$(pwd):/var/www/html" \
-w /var/www/html \
laravelsail/php83-composer:latest \
composer install --ignore-platform-reqs

./vendor/bin/sail up -d

./vendor/bin/sail artisan key:generate

./vendor/bin/sail npm install

./vendor/bin/sail npm run dev