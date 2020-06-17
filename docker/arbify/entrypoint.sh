#!/usr/bin/env bash
set -e

# If something is wrong with Composer dependencies or database connection, exit the script.
php artisan migrate:status > /dev/null 2>&1

php-fpm
