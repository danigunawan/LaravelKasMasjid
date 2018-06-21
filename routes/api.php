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

Route::group(['middleware' => 'auth:api'], function(){
	Route::get('user', 'API\UserController@getAll');
	Route::post('user', 'API\UserController@post');
	Route::delete('user', 'API\UserController@delete');
	Route::get('transaction', 'API\TransactionController@getAll');
	Route::get('transaction/{id}', 'API\TransactionController@getById');
	Route::put('transaction/{id}', 'API\TransactionController@putById');
	Route::post('transaction', 'API\TransactionController@post');
	Route::delete('transaction/{id}', 'API\TransactionController@delete');
	Route::get('category', 'API\CategoryController@getAll');
	Route::post('category', 'API\CategoryController@post');
	Route::put('category/{id}', 'API\CategoryController@putById');
});