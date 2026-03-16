<?php

use App\Http\Middleware\AuthenticateSession as MiddlewareAuthenticateSession;
use App\Http\Middleware\DynamicRole;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsAssignee;
use App\Http\Middleware\IsCoCreator;
use App\Http\Middleware\IsFacilitator;
use App\Http\Middleware\IsFreelancer;
use App\Http\Middleware\IsMember;
use App\Http\Middleware\IsResearcher;
use App\Http\Middleware\IsSpouse;
use App\Http\Middleware\IsVolunteer;
use App\Http\Middleware\IsTrainer;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\AuthenticateSession;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
       using: function (Router $router) {
            require base_path('routes/user.php');
            require base_path('routes/web.php');
            require base_path('routes/tgg-india.php');
            require base_path('routes/tgg-india/admin.php');
            require base_path('routes/tgg-india/trainer.php');
            require base_path('routes/tgg-india/members.php');
            require base_path('routes/tgg-india/co-creator.php');
            require base_path('routes/tgg-india/facilitator.php');
            require base_path('routes/tgg-india/spouse.php');
            require base_path('routes/tgg-india/freelancer.php');
            require base_path('routes/tgg-fct.php');
            Route::prefix('api')->group(
            function () {
                    require base_path('routes/api.php');
            });
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
        'associate' => IsMember::class,
        'assignee' => IsAssignee::class,
        'researcher' => IsResearcher::class,
        'volunteer' => IsVolunteer::class,
        'co-creator' => IsCoCreator::class,
        'facilitator' => IsFacilitator::class,
        'spouse' => IsSpouse::class,
        'freelancer' => IsFreelancer::class,
        'dynamic_role' => DynamicRole::class,
         ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
