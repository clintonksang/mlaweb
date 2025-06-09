#!/bin/bash
cd /var/www/html/core

if [ ! -f .env ]; then
    cp .env.example .env
    php artisan key:generate
fi

# Update APP_URL in .env to match the container environment
if grep -q "APP_URL=http://localhost" .env; then
    sed -i 's|APP_URL=http://localhost|APP_URL=http://localhost:8000|g' .env
fi

# Run database migrations and seeding
php artisan migrate:fresh --seed --force

# Run asset setup
/usr/local/bin/setup-assets.sh

# Start Apache
exec apache2-foreground 