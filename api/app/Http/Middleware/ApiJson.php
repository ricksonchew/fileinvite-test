<?php

namespace App\Http\Middleware;

use Closure;

class ApiJson
{
    public function handle($request, Closure $next)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }

        return $next($request);
    }
}
