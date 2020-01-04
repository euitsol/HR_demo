<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminPermissionsMiddleware
{

    public function handle($request, Closure $next)
    {
        $u = Auth::user();
        if ($u->hasRole('admin')){
            return $next($request);
        } else {
            abort(403);
        }
    }
}
