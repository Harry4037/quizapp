<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;

class CheckRole {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $role) {

        if (!$request->user()->hasRole($role)) {
            abort(404, "Unaurthorized User.");
        }
        return $next($request);
    }

}
