<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAssignee
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        $isWebAssignee = Auth::guard('web')->check() && (auth('web')->user()->user_role === '5' || auth('web')->user()->user_role === 5 );
       

        if ($isWebAssignee) {
            return $next($request);
        }
        
        return abort(403, 'Unauthorized access.');

    }
}
