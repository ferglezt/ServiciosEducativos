<?php

namespace App\Http\Middleware;

use Closure;

class CustomSessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if(!$request->session()->has('email') || !$request->session()->has('rol_id')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
