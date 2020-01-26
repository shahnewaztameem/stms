<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/home');
});

Auth::routes(['register' => false]);

Route::group(['middleware' => ['auth']], function () {


    Route::get('/home', function () {
        $user_type = auth()->user()->user_type;
        /**
         * UserType '0' for 'Admin'
         * UserType '1' for 'Client'
         * UserType '2' for 'User'
         */
        switch ($user_type) {
            case 0:
                return redirect()->route('admin.home');
                break;
            case 1:
                return redirect()->route('client.home');
                break;
            case 2:
                return redirect()->route('user.home');
                break;
        }
    })->name('home');


    // ADMIN ROUTES 
    Route::group(['prefix' => 'admin'], function () {
        Route::group(['middleware' => ['admin']], function () {
            Route::get('/home', 'AdminController@index')->name('admin.home');

            //ADMIN-USER-CONTROLS
            Route::get('home/user-create', 'AdminController@create_user')->name('admin.user.create');
            Route::post('home/user-create', 'AdminController@store_user');
            Route::get('home/user-edit/{id}', 'AdminController@edit_user')->name('admin.user.edit');
            Route::post('home/user-edit/{id}', 'AdminController@update_user');
            Route::delete('home/user-delete/{id}', 'AdminController@delete_user')->name('admin.user.delete');

            //ADMIN-CLIENT-CONTROLS
            Route::get('client-list', 'AdminController@client_list')->name('admin.client.list');
            Route::get('client-list/client-create', 'AdminController@create_client')->name('admin.client.create');
            Route::post('client-list/client-create', 'AdminController@store_client');
            Route::get('client-list/client-edit/{id}', 'AdminController@edit_client')->name('admin.client.edit');
            Route::post('client-list/client-edit/{id}', 'AdminController@update_client');
            Route::delete('client-list/client-delete/{id}', 'AdminController@delete_client')->name('admin.client.delete');

            // ADMIN-TASK-CONTROLS
            Route::get('task/all', 'AdminController@all_task')->name('admin.task.all');
            Route::get('task/create', 'AdminController@create_task')->name('admin.task.create');
            Route::post('task/create', 'AdminController@store_task');
            Route::get('task/edit/{id}', 'AdminController@edit_task')->name('admin.task.edit');
            Route::post('task/edit/{id}', 'AdminController@update_task');
            Route::delete('task/delete/{id}', 'AdminController@delete_task')->name('admin.task.delete');

            // NOTIFY CLIENT
            Route::get('admin/notify-client/{id}',  'AdminController@notify_client')->name('admin.notify.client');
        });
    });

    // CLIENT ROUTES 
    Route::group(['prefix' => 'client'], function () {
        Route::group(['middleware' => ['client']], function () {
            Route::get('/task/all', 'ClientController@index')->name('client.home');
            Route::get('/task/view/{slug}', 'ClientController@view')->name('client.task.view');
            Route::post('/task/feedback/{id}', 'ClientController@store_feedback')->name('client.feedback');
            // Route::get('task/feedback/edit/{task_id}/{id}', 'ClientController@edit_feedback')->name('client.feedback.edit');
            // Route::post('task/feedback/edit/{task_id}/{id}', 'ClientController@update_feedback');
            Route::delete('task/feedback/{id}', 'ClientController@delete_feedback')->name('client.feedback.delete');
        });
    });

    // USER ROUTES
    Route::group(['prefix' => 'user'], function () {
        Route::group(['middleware' => ['user']], function () {
            Route::get('task/all', 'UserController@index')->name('user.home');
            Route::get('task/view/{id}', 'UserController@view')->name('user.task.view');
            Route::post('task/file/{id}', 'UserController@store_file')->name('user.file.create');
            // Route::get('task/file/edit/{task_id}/{id}', 'UserController@edit_file')->name('user.file.edit');
            // Route::post('task/file/edit/{task_id}/{id}', 'UserController@update_file');
            Route::delete('task/file/delete/{id}', 'UserController@delete_file')->name('user.file.delete');
        });
    });
});