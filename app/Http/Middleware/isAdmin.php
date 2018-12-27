<?php

namespace App\Http\Middleware;

use Closure;

class isAdmin
{
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}
