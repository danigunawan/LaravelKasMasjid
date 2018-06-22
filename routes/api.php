<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login', 'API\UserController@login');
Route::group(['middleware' => 'auth:api'], function() {
    Route::get('user', 'API\UserController@getAll');
    Route::put('user/{id}', 'API\UserController@putById');
    Route::post('user', 'API\UserController@post');
    Route::delete('user/{id}', 'API\UserController@delete');
    Route::get('transactions', 'API\TransactionsController@getAll');
    Route::put('transactions/{id}', 'API\TransactionsController@putById');
    Route::post('transactions', 'API\TransactionsController@post');
    Route::delete('transactions/{id}', 'API\TransactionsController@delete');
    Route::get('categories', 'API\CategoriesController@getAll');
    Route::put('categories/{id}', 'API\CategoriesController@putById');
    Route::post('categories', 'API\CategoriesController@post');
});
