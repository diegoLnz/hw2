<?php

namespace App\Http\Middleware;

use Closure, Session;
use App\Extensions\AccountManager;

class CheckAuthenticated
{
    public function handle($request, Closure $next)
    {
        if (!Session::has('user')) {
            return redirect('login');
        }

        $user = AccountManager::currentUser();
        if(!$user || strtolower($user->username) != strtolower(Session::get('user')))
        {
            Session::flush();
            return redirect('login');
        }

        return $next($request);
    }
}