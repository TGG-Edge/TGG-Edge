<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsResearcher
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        // If not logged in
        if (!Auth::guard('web')->check()) {
            return redirect()->route('tgg-fct.login');
        }

        $user = auth('web')->user();

        // Must be role = 5
        if ((string) $user->user_role !== '2') {
            return abort(403, 'Unauthorized access.');
        }

        // Must be approved
        if ($user->approval !== 'accepted') {
            return abort(403, 'Your approval is not accepted yet. Please contact admin.');
        }

        return $next($request);

    }
}
