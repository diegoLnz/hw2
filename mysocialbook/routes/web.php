<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::get('/', function () {
    return view('home');
});

Route::get('home', function () {
    if(!Session::has('user'))
        return redirect('login');

    $user = User::where('username', '=', Session::get('user'))->first();
    return view('home')->with('user', $user);
});

Route::get('search', function () {
    return view('search');
});