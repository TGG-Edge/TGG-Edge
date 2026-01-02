<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DynamicRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = Auth::guard('web2')->user();

        if (!$user) {
            return redirect()->route('tgg-india.login')
                    ->with('error', 'Please login to access India section.'); 
        }

        // Allow access only if user role is in allowed roles
        if (! in_array($user->user_role, $roles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
