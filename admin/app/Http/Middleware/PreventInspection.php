<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PreventInspection
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (app()->environment('production')) {
            $response->headers->set('X-Robots-Tag', 'noindex, nofollow');
        }

        return $response;
    }
}
