<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckAuthenticated;

Route::get('login', 'App\Http\Controllers\LoginController@login');
Route::get('logout', 'App\Http\Controllers\LoginController@logout');
Route::get('register', 'App\Http\Controllers\RegisterController@register');
Route::get('users/checkExistingUser/{username}', 'App\Http\Controllers\UserController@checkExistingUser');
Route::get('nasa/getPicOfTheDay', 'App\Http\Controllers\NasaController@getPicOfTheDay');
Route::get('nasa/search/{searchString}', 'App\Http\Controllers\NasaController@videoListForSearch');
Route::get('users/listforsearch/{search}/{user}', 'App\Http\Controllers\UserController@listForSearchForm');
Route::get('posts/like/{user}/{post}', 'App\Http\Controllers\ThreadController@likeThread');
Route::get('posts/getByUserId/{id}', 'App\Http\Controllers\ThreadController@getPostsByUserId');
Route::get('posts/getFollowedUsersPosts/{id}', 'App\Http\Controllers\ThreadController@getFollowedUsersPosts');
Route::get('posts/getLiked', 'App\Http\Controllers\ThreadController@getLikedPosts');
Route::get('posts/get-detail/{id}', 'App\Http\Controllers\PostDetailController@getDetail');
Route::get('users/follow/{user}/{follow}', 'App\Http\Controllers\UserController@followUser');
Route::post('login', 'App\Http\Controllers\LoginController@logUser');
Route::post('register', 'App\Http\Controllers\RegisterController@registerUser');

Route::middleware([CheckAuthenticated::class])->group(function() {
    #region Get
    Route::get('/', 'App\Http\Controllers\HomeController@home');
    Route::get('home', 'App\Http\Controllers\HomeController@home');
    Route::get('search', 'App\Http\Controllers\SearchController@search');
    Route::get('personal-info', 'App\Http\Controllers\PersonalInfoController@personalInfo');
    Route::get('user/{username}', 'App\Http\Controllers\ExternalUsersController@user');
    Route::get('liked-posts', 'App\Http\Controllers\ThreadController@likedPosts');
    Route::get('post/{id}', 'App\Http\Controllers\PostDetailController@postDetail');
    Route::get('followers', 'App\Http\Controllers\FollowersController@followersList');
    Route::get('followers/get', 'App\Http\Controllers\FollowersController@getFollowersList');
    Route::get('nasa-video-library', 'App\Http\Controllers\NasaController@nasaVideoLibrary');
    #endregion

    #region Post
    Route::post('posts/upload', 'App\Http\Controllers\ThreadController@uploadThread');
    Route::post('comments/upload', 'App\Http\Controllers\CommentController@uploadComment');
    #endregion
});

