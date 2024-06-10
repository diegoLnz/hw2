<?php

use Illuminate\Support\Facades\Route;

#region Get

Route::get('login', 'App\Http\Controllers\LoginController@login');

Route::get('logout', 'App\Http\Controllers\LoginController@logout');

Route::get('/', 'App\Http\Controllers\HomeController@home');

Route::get('home', 'App\Http\Controllers\HomeController@home');

Route::get('search', 'App\Http\Controllers\SearchController@search');

Route::get('personal-info', 'App\Http\Controllers\PersonalInfoController@personalInfo');

Route::get('register', 'App\Http\Controllers\RegisterController@register');

Route::get('users/checkExistingUser', 'App\Http\Controllers\UserController@checkExistingUser');

Route::get('users/follow', 'App\Http\Controllers\UserController@followUser');

Route::get('users/listforsearch', 'App\Http\Controllers\UserController@listForSearchForm');

Route::get('nasa/getPicOfTheDay', 'App\Http\Controllers\NasaController@getPicOfTheDay');

Route::get('posts/like', 'App\Http\Controller\ThreadController@likeThread');

Route::get('posts/getByUserId', 'App\Http\Controller\ThreadController@getPostsByUserId');

#endregion

#region Post

Route::post('login', 'App\Http\Controllers\LoginController@logUser');

Route::post('register', 'App\Http\Controllers\RegisterController@registerUser');

Route::post('posts/upload', 'App\Http\Controller\ThreadController@uploadThread');

#endregion