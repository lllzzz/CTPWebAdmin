<?php

namespace App\Http\Middleware;

use Closure;
// use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($request->session()->has('login') && $request->session()->get('login')) {
            return $next($request);
        }
        return redirect('/');
    }
}
