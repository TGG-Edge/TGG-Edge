<?php

use App\Http\Middleware\AuthenticateSession as MiddlewareAuthenticateSession;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsAssignee;
use App\Http\Middleware\IsMember;
use App\Http\Middleware\IsTrainer;
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
            require base_path('routes/user.php');
            require base_path('routes/web.php');
            require base_path('routes/tgg-india.php');
            require base_path('routes/tgg-fct.php');
        },
        commands: base_path('routes/console.php'),
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
         $middleware->alias([
        'admin' => IsAdmin::class,
        'auth' => Authenticate::class, 
        'web' => StartSession::class,
        'trainer' => IsTrainer::class,
        'member' => IsMember::class,
        'assignee' => IsAssignee::class,
         ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
