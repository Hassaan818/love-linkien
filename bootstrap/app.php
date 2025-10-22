<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        using: function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('api')
                ->group(base_path('routes/api.php'));
            Route::middleware('console')
                ->group(base_path('routes/console.php'));

            Route::prefix('api/v1')->middleware(['api'])->group(function () {

                require base_path('routes/apis/V1/auth.php');
                foreach (glob(base_path('routes/apis/V1/*.php')) as $file) {
                    if (!str_contains($file, 'auth.php')) {
                        require $file;
                    }
                }
            });
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
