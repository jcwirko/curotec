#!/bin/ash

# If the vendor folder or the vendor/autoload.php file does not exist, run composer install
if [ ! -d "vendor" ] || [ ! -f "vendor/autoload.php" ]; then
    composer install
fi

# Look into the .env file and see if the APP_KEY is present
if [ -z "$APP_KEY" ]; then
    php artisan key:generate
fi

# Remove framework caches (if any was created)
php artisan optimize:clear
