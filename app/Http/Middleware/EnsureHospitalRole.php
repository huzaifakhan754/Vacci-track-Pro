<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureHospitalRole
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->hasRole('hospital')) {
            abort(403);
        }

        return $next($request);
    }
}
