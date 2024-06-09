<?php

namespace App\Http\Controllers;

use Session;

class SearchController extends Controller
{
    public function search()
    {
        return Session::has('user')
            ? view('search')
            : redirect('login');
    }
}