<?php

namespace App\Http\Middleware;

use Closure, Session;

class CheckAuthenticated
{
    public function handle($request, Closure $next)
    {
        if (!Session::has('user')) {
            return redirect('login');
        }

        return $next($request);
    }
}