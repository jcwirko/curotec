#!/bin/ash

# Migrate DB
php artisan migrate

# Migrate Testing DB
php artisan migrate --env testing
