<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Traits\CoreTrait;
use App\Http\Traits\HttpStatusCodesTrait;

class Gated
{
    use CoreTrait, HttpStatusCodesTrait;

    public function handle($request, Closure $next)
    {
        if (!empty(auth()->user()) && !empty(helperArraySearch(auth()->user()->getAllPermissions()->toArray(), 'name', $request->route()->getName()))) {
            return $next($request);
        }

        $statusCode = self::$statusCodeUnauthorized;
        return response()->json($this->buildJsonResponse(helperCustomMessages('sysMsgUnauthorized'), $statusCode), $statusCode);
    }
}
