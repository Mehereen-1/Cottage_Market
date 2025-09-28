<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If user not logged in
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // If user’s role is not in allowed roles
        if (!in_array($request->user()->role, $roles)) {
            abort(403, 'Unauthorized.');
        }

        // Otherwise, pass the request
        return $next($request);
    }
}
