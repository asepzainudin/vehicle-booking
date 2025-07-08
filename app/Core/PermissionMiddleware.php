<?php

namespace App\Core;

use Closure;

class PermissionMiddleware
{
    public function handle($request, Closure $next, $role, $guard = null)
    {
        return $next($request);
    }
}
