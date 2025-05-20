<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SkipUtility
{
    public function handle(Request $request, Closure $next)
    {
        // Skip the licence check when APP_ENV=local
        if (app()->isLocal()) {
            return $next($request);
        }

        // Fallback to original middleware in other environments
        return app(\Laramin\Utility\Utility::class)->handle($request, $next);
    }
}
