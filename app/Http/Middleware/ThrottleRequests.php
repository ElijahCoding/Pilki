<?php


namespace App\Http\Middleware;


use Closure;
use Illuminate\Routing\Middleware\ThrottleRequests as BaseThrottleRequests;

class ThrottleRequests extends BaseThrottleRequests
{
    public function handle($request, Closure $next, $maxAttempts = 60, $decayMinutes = 1)
    {
        if (env('APP_ENV') === 'testing') {
            return $next($request);
        }

        return parent::handle($request, $next, $maxAttempts, $decayMinutes);
    }
}