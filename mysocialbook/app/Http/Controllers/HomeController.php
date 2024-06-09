<?php

namespace App\Http\Controllers;

use Session;
use App\Models\User;

class HomeController extends Controller
{
    public function home()
    {
        if(!Session::has('user'))
            return redirect('login');

        $user = User::where('username', Session::get('user'))->first();
        return view('home')->with('user', $user); 
    }
}