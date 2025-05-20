#!/bin/bash

# Navigate to the core directory
cd /var/www/html/core

# Ensure we're using the latest npm
npm install -g npm@latest

# Clean install dependencies
rm -rf node_modules package-lock.json
npm install --platform=linux --arch=x64

# Fix audit issues
npm audit fix --force

# Rebuild native modules
npm rebuild

# Try to build assets
echo "Building assets..."
npm run build || {
    echo "Asset build failed, attempting alternative build..."
    # If build fails, try with specific platform
    export VITE_PLATFORM=linux
    export VITE_ARCH=x64
    npm run build
}

# Ensure storage directory is writable
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Create symbolic link for storage
php artisan storage:link

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Optimize
php artisan optimize 