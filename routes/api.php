<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'api','prefix' => 'auth'], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('user-profile', 'AuthController@userProfile');

});


Route::group(['middleware' => 'api','prefix' => 'user'], function ($router) {

    Route::post('/update', 'UserController@update');

});

Route::group(['middleware' => 'api','prefix' => 'image'], function ($router) {

    Route::post('/upload', 'ImageController@upload');

});
