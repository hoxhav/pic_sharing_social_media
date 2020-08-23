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

    Route::get('/list', 'ImageController@index');
    Route::get('/listMyImages', 'ImageController@listMyImages');
    Route::post('/upload', 'ImageController@upload');
    Route::post('/search', 'ImageController@search');
    Route::post('/download', 'ImageController@download');


});

Route::group(['middleware' => 'api','prefix' => 'bookmark'], function ($router) {

    Route::get('/list', 'BookmarkController@userBookmarks');
    Route::get('/listAll', 'BookmarkController@index');
    Route::post('/create', 'BookmarkController@create');

});

Route::group(['middleware' => 'api','prefix' => 'category'], function ($router) {

    Route::get('/list', 'CategoryController@index');
    Route::post('/listImagesByCategory', 'CategoryController@filterByCategory');

});

Route::group(['middleware' => 'api','prefix' => 'tag'], function ($router) {

    Route::get('/list', 'TagController@index');
    Route::post('/listImageTags', 'TagController@listImageTags');
    Route::post('/create', 'TagController@create');

});
