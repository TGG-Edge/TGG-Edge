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
        if(Auth('web2')->check() && Auth('web2')->user()->user_role == 3) {
            $user = Auth('web2')->user();
            if ($user->approval != 'accepted') {
                return abort(403, 'Your approval is not accepted yet. Please contact admin.');
            }
            return $next($request);
        }

        


        return abort(403, 'Unauthorized access.');
    }
}
