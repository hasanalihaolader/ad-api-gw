#!/bin/bash
set -e

# Set Laravel storage folder permissions
chown -R www-data:www-data /var/www/storage

php artisan cache:clear

# Start PHP-FPM
exec "$@"