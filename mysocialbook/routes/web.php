<?php

use Illuminate\Support\Facades\Route;

#region Get

Route::get('login', 'LoginController@login');

Route::get('/', 'HomeController@home');

Route::get('home', 'HomeController@home');

Route::get('search', 'SearchController@search');

#endregion

#region Post

#endregion