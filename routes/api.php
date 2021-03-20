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
Route::get('users', '\App\Http\Controllers\UserController@index');
// Get one user
Route::get('users/{id}', '\App\Http\Controllers\UserController@show');
// Save user
Route::post('users', '\App\Http\Controllers\UserController@store');
// Update user
//Route::put('users/{id}', '\App\Http\Controllers\UserController@update');
Route::post('users/{id}', '\App\Http\Controllers\UserController@update');

// Delete user
Route::post('users/delete/{id}', '\App\Http\Controllers\UserController@softDelete');

//Route::delete('users/{id}', '\App\Http\Controllers\UserController@destroy');