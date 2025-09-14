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
       $isWebLoggedIn  = Auth::guard('web')->check();
        $isWeb2LoggedIn = Auth::guard('web2')->check();

        // If user is not logged in at all
        if ( !$isWeb2LoggedIn) {
            return redirect()->route('tgg-india.login');
        }

        if (!$isWebLoggedIn ) {
            return redirect()->route('tgg-fct.login');
        }

        // If logged in through web guard
        if ($isWebLoggedIn && (auth('web')->user()->user_role === '1' || auth('web')->user()->user_role === 1)) {
            return $next($request);
        }

        // If logged in through web2 guard
        if ($isWeb2LoggedIn && (auth('web2')->user()->user_role === '1' || auth('web2')->user()->user_role === 1)) {
            return $next($request);
        }

        // Logged in but not admin
        return abort(403, 'Unauthorized access.');
    }
}
