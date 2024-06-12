<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckAuthenticated;
use App\Http\Controllers;

Route::get('login', 'App\Http\Controllers\LoginController@login');
Route::get('logout', 'App\Http\Controllers\LoginController@logout');
Route::get('register', 'App\Http\Controllers\RegisterController@register');
Route::get('users/checkExistingUser/{username}', 'App\Http\Controllers\UserController@checkExistingUser');
Route::get('nasa/getPicOfTheDay', 'App\Http\Controllers\NasaController@getPicOfTheDay');
Route::get('users/listforsearch/{search}/{user}', 'App\Http\Controllers\UserController@listForSearchForm');
Route::get('posts/like/{user}/{post}', 'App\Http\Controller\ThreadController@likeThread');
Route::get('posts/getByUserId/{id}', 'App\Http\Controller\ThreadController@getPostsByUserId');
Route::get('posts/getFollowedUsersPosts/{id}', [Controllers\ThreadController::class, 'getFollowedUsersPosts']);
Route::get('users/follow/{user}/{follow}', 'App\Http\Controllers\UserController@followUser');
Route::post('login', 'App\Http\Controllers\LoginController@logUser');
Route::post('register', 'App\Http\Controllers\RegisterController@registerUser');

Route::middleware([CheckAuthenticated::class])->group(function() {
    #region Get
    Route::get('/', 'App\Http\Controllers\HomeController@home');
    Route::get('home', 'App\Http\Controllers\HomeController@home');
    Route::get('search', 'App\Http\Controllers\SearchController@search');
    Route::get('personal-info', 'App\Http\Controllers\PersonalInfoController@personalInfo');
    #endregion

    #region Post
    Route::post('posts/upload', 'App\Http\Controller\ThreadController@uploadThread');
    Route::post('comments/upload', 'App\Http\Controllers\CommentController@uploadComment');
    #endregion
});

