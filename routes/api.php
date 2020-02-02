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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
/**USER API ROUTES - ADMIN */
Route::get('users', 'AdminController@index');
Route::post('store-user', 'AdminController@store_user');
Route::get('show-user/{id}', 'AdminController@edit_user');
Route::put('update-user/{id}', 'AdminController@update_user');
Route::delete('delete-user/{id}', 'AdminController@delete_user');

/**CLIENT API ROUTES - ADMIN*/
Route::get('clients', 'AdminController@client_list');
Route::post('store-client', 'AdminController@store_client');
Route::get('show-client/{id}', 'AdminController@edit_client');
Route::put('update-client/{id}', 'AdminController@update_client');
Route::delete('delete-client/{id}', 'AdminController@delete_client');

/**TASK API ROUTES -ADMIN*/
Route::get('tasks', 'AdminController@all_task');
Route::post('store-task', 'AdminController@store_task');
Route::get('view-task/{slug}', 'AdminController@view_task');
Route::put('update-task/{id}', 'AdminController@update_task');
Route::delete('delete-task/{id}', 'AdminController@delete_task');

// DELETE SINGLE FILE - ADMIN
Route::delete('delete-file/{id}', 'AdminController@delete_file');

// NOTIFY CLIENT - ADMIN
Route::get('notify-client/{id}', 'AdminController@notify_client');






