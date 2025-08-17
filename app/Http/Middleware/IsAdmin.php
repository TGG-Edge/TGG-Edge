<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isWebAdmin = Auth::guard('web')->check() && auth('web')->user()->user_role === '1';
        $isWeb2Admin = Auth::guard('web2')->check() && auth('web2')->user()->user_role === '1';

        if ($isWebAdmin || $isWeb2Admin) {
            return $next($request);
        }
        
        return abort(403, 'Unauthorized access.');

    }
}
