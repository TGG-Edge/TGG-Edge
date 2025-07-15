<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\Request;

class AuthenticateSession
{
    public function __construct(protected Auth $auth) {}

    public function handle(Request $request, Closure $next)
    {
        // If already authenticated, no need to sync
        if ($this->auth->guard()->check()) {
            return $next($request);
        }

        // Attempt to login from session
        $userId = $request->session()->get('login_web_' . $this->auth->getDefaultDriver());

        if ($userId) {
            $this->auth->guard()->loginUsingId($userId);
        }

        return $next($request);
    }
}
