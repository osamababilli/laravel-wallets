<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserCheckActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = auth()->user();


        if (auth()->check() && $user->hasAnyRole('admin', 'super admin')) {

            return $next($request);
        } elseif (auth()->check() &&  $user->status == 'inactive') {

            return abort(403, 'Your account is inactive');
        }

        return $next($request);
    }
}
