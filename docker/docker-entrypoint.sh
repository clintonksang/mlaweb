#!/bin/bash
cd /var/www/html/core

if [ ! -f .env ]; then
    cp .env.example .env
    php artisan key:generate
fi

# Run database migrations and seeding
php artisan migrate:fresh --seed --force

# Run asset setup
/usr/local/bin/setup-assets.sh

# Start Apache
exec apache2-foreground 