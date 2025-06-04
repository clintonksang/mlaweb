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