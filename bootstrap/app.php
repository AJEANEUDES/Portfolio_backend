<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Middleware global (toutes les requêtes)
        $middleware->append(\App\Http\Middleware\SecurityHeaders::class);

        // Alias pour utilisation dans les routes
        $middleware->alias([
            'force.json' => \App\Http\Middleware\ForceJsonResponse::class,
        ]);

        // Rate limiting strict sur les tentatives de login admin
            // $middleware->throttleApi();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();