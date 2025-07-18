<?php

use App\Http\Middleware\AuthenticateSession as MiddlewareAuthenticateSession;
use App\Http\Middleware\IsAdmin;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Router;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\AuthenticateSession;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
       using: function (Router $router) {
            $router->group(['prefix' => 'api', 'middleware' => 'web'], function () {
                require base_path('routes/api.php');
            });

            $router->group(['middleware' => 'web'], function () {
                require base_path('routes/web.php');
            });
        },
        commands: base_path('routes/console.php'),
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
         $middleware->alias([
        'is_admin' => IsAdmin::class,
        'auth' => Authenticate::class, 
        'web' => StartSession::class,
         ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
