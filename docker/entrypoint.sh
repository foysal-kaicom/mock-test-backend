#!/bin/sh

echo "Installing dependencies..."
composer install

echo "Running migrations..."
php artisan migrate --force

# echo "Seeding database..."
# php artisan db:seed --force

echo "Initializing permissions..."
php artisan permission:init

echo "Starting PHP-FPM..."
exec php-fpm
