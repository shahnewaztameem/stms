<?php

use App\Task;
use App\User;
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

Route::get('/layout', function () {
    return view('layouts.final_layout');
});

Route::get('/', function () {
    return redirect('/home');
});

Auth::routes(['register' => false]);

/**CLIENT NOTIFICATION ROUTES - FROM THE LINK*/
Route::get('task-notify/{hash_url}',  'Auth\LoginController@task_notify')->name('client.task.notify');


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
            Route::get('/manager-list', 'AdminController@user_list')->name('admin.user.list');
            Route::get('user/user-create', 'AdminController@create_user')->name('admin.user.create');
            Route::post('user/user-create', 'AdminController@store_user');
            Route::get('user/user-edit/{id}', 'AdminController@edit_user')->name('admin.user.edit');
            Route::post('user/user-edit/{id}', 'AdminController@update_user');
            Route::delete('user/user-delete/{id}', 'AdminController@delete_user')->name('admin.user.delete');

            //ADMIN-CLIENT-CONTROLS
            Route::get('client-list', 'AdminController@client_list')->name('admin.client.list');
            Route::get('client/client-create', 'AdminController@create_client')->name('admin.client.create');
            Route::post('client/client-create', 'AdminController@store_client');
            Route::get('client/client-edit/{id}', 'AdminController@edit_client')->name('admin.client.edit');
            Route::post('client/client-edit/{id}', 'AdminController@update_client');
            Route::delete('client/client-delete/{id}', 'AdminController@delete_client')->name('admin.client.delete');

            // ADMIN-TASK-CONTROLS
            Route::get('task/add-task', 'AdminController@add_task')->name('admin.task.add');
            Route::get('task/all', 'AdminController@all_task')->name('admin.task.all');
            Route::get('task/view/{slug}', 'AdminController@view_task')->name('admin.task.view');
            Route::get('task/create', 'AdminController@create_task')->name('admin.task.create');
            Route::post('task/create', 'AdminController@store_task');

            Route::get('task/phase/create-design-phase', 'AdminController@create_design_phase')->name('admin.task.create-design-phase');
            Route::post('task/phase/create-design-phase', 'AdminController@store_design_phase');

            Route::get('task/phase/create-development-phase', 'AdminController@create_development_phase')->name('admin.task.create-development-phase');
            Route::post('task/phase/create-development-phase', 'AdminController@store_development_phase');

            Route::get('task/phase/create-seo-phase', 'AdminController@create_seo_phase')->name('admin.task.create-seo-phase');
            Route::post('task/phase/create-seo-phase', 'AdminController@store_seo_phase');

            Route::get('task/edit/{id}', 'AdminController@edit_task')->name('admin.task.edit');
            Route::post('task/edit/{id}', 'AdminController@update_task');
            Route::delete('task/delete/{id}', 'AdminController@delete_task')->name('admin.task.delete');
            Route::delete('task/delete-design/{id}', 'AdminController@delete_design_phase')->name('admin.task.delete-design');
            Route::delete('task/delete-dev/{id}', 'AdminController@delete_dev_phase')->name('admin.task.delete-dev');
            Route::delete('task/delete-seo/{id}', 'AdminController@delete_seo_phase')->name('admin.task.delete-seo');
            Route::delete('task/file/delete/{id}', 'AdminController@delete_file')->name('admin.file.delete');


            // NOTIFY CLIENT
            Route::get('admin/notify-client/{id}',  'AdminController@notify_client')->name('admin.notify.client');
        });
    });

    // CLIENT ROUTES 
    Route::group(['prefix' => 'client'], function () {
        Route::group(['middleware' => ['client']], function () {
            Route::get('/change-pass', 'ClientController@change_pass')->name('client.change.pass');
            Route::post('/change-pass', 'ClientController@store_pass');

            Route::get('/home', 'ClientController@index')->name('client.home');
            Route::get('/tasks', 'ClientController@all_task')->name('client.tasks');
            Route::get('/task/design', 'ClientController@design_phase')->name('client.task.design');
            Route::get('/task/dev', 'ClientController@dev_phase')->name('client.task.dev');
            Route::get('/task/seo', 'ClientController@seo_phase')->name('client.task.seo');
            Route::get('/task/view/{slug}', 'ClientController@view')->name('client.task.view');
            Route::post('/task/feedback/{id}', 'ClientController@store_feedback')->name('client.feedback');

            Route::post('/task/design-feedback/{file_id}', 'ClientController@design_feedback')->name('client.design_feedback');
            Route::delete('/task/design-feedback/{feedback_id}', 'ClientController@delete_design_feedback')->name('client.design_feedback.delete');

            Route::post('/task/dev-feedback/{dev_id}', 'ClientController@dev_feedback')->name('client.dev_feedback');
            Route::delete('/task/dev-feedback/{dev_id}', 'ClientController@delete_dev_feedback')->name('client.dev_feedback.delete');

            Route::post('/task/seo-feedback/{seo_id}', 'ClientController@seo_feedback')->name('client.seo_feedback');
            Route::delete('/task/seo-feedback/{seo_id}', 'ClientController@delete_seo_feedback')->name('client.seo_feedback.delete');
            
            Route::delete('task/feedback/{id}', 'ClientController@delete_feedback')->name('client.feedback.delete');
        });
    });

    // USER ROUTES
    Route::group(['prefix' => 'user'], function () {
        Route::group(['middleware' => ['user']], function () {
            Route::get('/home', 'UserController@index')->name('user.home');
            Route::get('/tasks', 'UserController@all_task')->name('user.tasks');
            Route::get('/task/design', 'UserController@design_phase')->name('user.task.design');
            Route::get('/task/dev', 'UserController@dev_phase')->name('user.task.dev');
            Route::get('/task/seo', 'UserController@seo_phase')->name('user.task.seo');
            Route::get('/task/view/{slug}', 'UserController@view')->name('user.task.view');
        });
    });
});

Route::get('/project-details/design/{id}', function ($id) {
    $task = Task::whereId($id)->with('task_files', 'design_phase', 'design_phase.design_pm')->first();
    if ($task) {
        return response()->json(['data' => $task]);
    } else {
        return response()->json(['data' => 'No data found']);
    }
});

Route::get('/project-details/development/{id}', function ($id) {
    $task = Task::whereId($id)->with('development_phase', 'development_phase.dev_pm')->first();
    if ($task) {
        return response()->json(['data' => $task]);
    } else {
        return response()->json(['data' => 'No data found']);
    }
});

Route::get('/project-details/seo/{id}', function ($id) {
    $task = Task::whereId($id)->with('seo_phase', 'seo_phase.seo_pm')->first();
    if ($task) {
        return response()->json(['data' => $task]);
    } else {
        return response()->json(['data' => 'No data found']);
    }
});

Route::get('search/{query}', function ($query) {
    $tasks = Task::where('title', 'like', '%'.$query.'%')
                ->orWhere('details', 'like', '%'.$query.'%')
                ->get();
    $html = "<ul class='list-group' style='width: 100%'>";
    if (count($tasks)) {
        foreach ($tasks as $index => $task) {
            $html .= "<a class='list-group-item list-group-item-action' href=".route('admin.task.view', $task->slug).">$task->title</a>";
        }
        $html .= "</ul>";
        return $html;
    } else {
        $html .= "<a class='list-group-item list-group-item-action' href='#'>No data found</a>";
        $html .= "</ul>";
        return $html;
    }
    
});