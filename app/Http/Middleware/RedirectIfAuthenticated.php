<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = config('auth.guards');

        $redirects = [
            'web' => 'dashboard',
            'therapist' => 'therapist.dashboard'
        ];

        foreach ($guards as $name => $value)
            if (Auth::guard($name)->check())
                return to_route($redirects[$name]);

        return $next($request);
    }
}
