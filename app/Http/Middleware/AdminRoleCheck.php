<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminRoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->is_admin) {
            return $next($request);
        } else {
            return response()->json('Unauthorize', 403);
        }
    }
}
