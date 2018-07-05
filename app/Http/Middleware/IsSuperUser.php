<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use App\Models\Employer;

class IsSuperUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if ($user instanceof Employer && $user->is_superuser == 1) {
            return $next($request);
        }

        return response()->json(['You are not super user.']);
    }
}
