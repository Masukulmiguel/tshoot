<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class RateLimitLogins
{
    public function handle(Request $request, Closure $next)
    {
        $ip = $request->ip();
        $key = 'login_attempts_' . $ip;
        $maxAttempts = 5;
        $decayMinutes = 15;

        $attempts = Cache::get($key, 0);

        if ($attempts >= $maxAttempts) {
            $retryAfter = Cache::get($key . '_retry_after', $decayMinutes);
            return redirect()->route('login')
                ->withErrors(['email' => "Demasiadas tentativas. Tente novamente em {$retryAfter} minutos."])
                ->withInput($request->only('email'));
        }

        $response = $next($request);

        if ($request->isMethod('post') && $request->routeIs('login')) {
            if ($response->isRedirect()) {
                $session = $request->session();
                if ($session->has('login_errors') || $session->has('error') || !$session->has('url.intended')) {
                    Cache::put($key, $attempts + 1, now()->addMinutes($decayMinutes));
                    Cache::put($key . '_retry_after', $decayMinutes - intval(($attempts + 1) * $decayMinutes / $maxAttempts), now()->addMinutes($decayMinutes));
                } else {
                    Cache::forget($key);
                }
            }
        }

        return $response;
    }
}
