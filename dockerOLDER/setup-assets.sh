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

# Create assets symlink for public directory
if [ ! -L public/assets ]; then
    ln -s ../../assets public/assets
fi

# Ensure public/index.php exists (Laravel front controller)
if [ ! -f public/index.php ]; then
    cat > public/index.php << 'EOF'
<?php

use Illuminate\Http\Request;

// Set the start time of the application
define('LARAVEL_START', microtime(true));

// Maintenance mode check
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register Composer autoloader
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the incoming request
(require_once __DIR__.'/../bootstrap/app.php')->handleRequest(Request::capture());
EOF
fi

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Optimize
php artisan optimize 