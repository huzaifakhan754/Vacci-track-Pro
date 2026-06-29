<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureParentRole
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->hasRole('parent')) {
            abort(403);
        }

        return $next($request);
    }
}
