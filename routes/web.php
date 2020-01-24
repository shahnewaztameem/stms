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

Route::get('/home', function () {
    $user_type = auth()->user()->user_type;
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

Route::group(['middleware' => ['auth']], function () {

    // ADMIN ROUTES 
    Route::group(['prefix' => 'admin'], function () {
        Route::group(['middleware' => ['admin']], function () {
            Route::get('/home', 'AdminController@index')->name('admin.home');
        });
    });
    
    // CLIENT ROUTES 
    Route::group(['prefix' => 'client'], function () {
        Route::group(['middleware' => ['client']], function () {
            Route::get('/home', 'ClientController@index')->name('client.home');
        });
    });
    
    // USER ROUTES
    Route::group(['prefix' => 'user'], function () {
        Route::group(['middleware' => ['user']], function () {
            Route::get('/home', 'UserController@index')->name('user.home');
        });
    });
});