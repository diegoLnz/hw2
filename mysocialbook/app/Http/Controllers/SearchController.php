<?php

namespace App\Http\Controllers;

use App\Extensions\AccountManager;
use Session;

class SearchController extends Controller
{
    public function search()
    {
        return Session::has('user')
            ? view('search')->with('user', AccountManager::currentUser())
            : redirect('login');
    }
}