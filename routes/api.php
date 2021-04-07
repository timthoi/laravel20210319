<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


// CRUD
// Get all users
//Route::get('users', '\App\Http\Controllers\UserController@index');
//// Get one user
//Route::get('users/{id}', '\App\Http\Controllers\UserController@show');
//// Save user
//Route::post('users', '\App\Http\Controllers\UserController@store');
//// Update user
////Route::put('users/{id}', '\App\Http\Controllers\UserController@update');
//Route::post('users/{id}', '\App\Http\Controllers\UserController@update');
//
//// Delete user
//Route::post('users/delete/{id}', '\App\Http\Controllers\UserController@softDelete');

// Get all users
Route::post('login', '\App\Http\Controllers\AuthController@login')->name('login');
//Route::apiResource('users','\App\Http\Controllers\UserController');


Route::group(['middleware' => 'auth:api'], function () {
//    Route::get('users', '\App\Http\Controllers\UserController@index');
    //    Route::get('loginUsers', '\App\Http\Controllers\UserController@getLisLoginUsers');
    Route::get('infoUser', '\App\Http\Controllers\UserController@getInfoUser');
    Route::get('titles', '\App\Http\Controllers\TitleController@getTitles');
});


// Upload Image
Route::post('uploadFile', '\App\Http\Controllers\UploadFileController@store');

//Route::delete('users/{id}', '\App\Http\Controllers\UserController@destroy');

//Route::get('users', '\App\Http\Controllers\UserController@index')->middleware('auth:api')->name('users');