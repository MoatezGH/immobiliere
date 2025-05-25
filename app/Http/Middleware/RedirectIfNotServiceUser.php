<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotServiceUser
{
    public function handle($request, Closure $next, $guard = 'service_user')
{
    // dd('dddd');
    if (!Auth::guard($guard)->check()) {
        return redirect('/login');
    }

    return $next($request);
}
}
