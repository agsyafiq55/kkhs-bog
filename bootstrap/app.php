<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Create base application instance first
$app = new Application(
    basePath: dirname(__DIR__)
);

// Load .env.production if APP_ENV=production
if (getenv('APP_ENV') === 'production') {
    $app->loadEnvironmentFrom('.env.production');
}

// Then configure
return $app->configure()
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
