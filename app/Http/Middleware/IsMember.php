<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsMember
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If not logged in through web2
        if (!Auth::guard('web2')->check()) {
            return redirect()->route('tgg-india.login');
        }

        $user = Auth::guard('web2')->user();

        // Check if user role is Member (3)
        if ((string) $user->user_role !== '3') {
            return abort(403, 'Unauthorized access.');
        }

        // Check approval status
        if ($user->approval !== 'accepted') {
            return abort(403, 'Your approval is not accepted yet. Please contact admin.');
        }

        return $next($request);
    }
}
