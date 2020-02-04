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



Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});


Route::group([
    'middleware' => 'jwt',
], function () {
    Route::group([
        'prefix' => 'admin',
        'middleware' => 'admin',
    ], function () {
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
        Route::delete('delete-file/{file_id}', 'AdminController@delete_file');

        // NOTIFY CLIENT - ADMIN
        Route::get('notify-client/{task_id}', 'AdminController@notify_client');
    });

    Route::group([
        'prefix' => 'client',
        'middleware' => 'client',
    ], function () {
        /**CLIENT API ROUTES FOR CLIENT */
        Route::get('all-tasks', 'ClientController@index');
        // PASSWORD CHANGE FOR CLIENT
        Route::post('pass-change', 'ClientController@store_pass');
        Route::get('view-task-client/{slug}', 'ClientController@view');
        Route::post('store-feedback/{task_id}', 'ClientController@store_feedback');
        Route::delete('delete-file/{feedback_id}', 'ClientController@delete_feedback');
    });

    Route::group([
        'prefix' => 'user',
        'middleware' => 'user',
    ], function () {

        /**USER API ROUTES FOR USER */
        Route::get('all-tasks', 'UserController@index');
        Route::get('view-task-user/{slug}', 'UserController@view');
    });
});