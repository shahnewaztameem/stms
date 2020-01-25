<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CreateUserRequest;
use App\Notifications\ClientTaskNotification;
use App\TaskUser;

class AdminController extends Controller
{
    /**
     * Index function for admin to view
     * dashboard of an admin
     * 
     * @return view with all users
     */
    public function index()
    {
        $users = User::whereUserType(2)->latest()->get();
        return view('admin.home', compact('users'));
    }

    /**
     * User create form
     *
     * @return view
     */
    public function create_user()
    {
        return view('admin.user.create');
    }

    /**
     * Store an User
     *
     * @return Response 
     */
    public function store_user(CreateUserRequest $request)
    {
        $request['user_type'] = 2;
        $user = User::create($request->all());
        return redirect()->back()->with('success', "User ($user->name) is added successfully");
    }

    /**
     * User edit form
     *
     * @param [type] $id
     * @return view
     */
    public function edit_user($id)
    {
        $user = User::find($id);
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update and User
     *
     * @param [type] $id
     * @return view
     */
    public function update_user(Request $request, $id)
    {
        $user = User::find($id);

        $request->validate([
            'name' => 'bail | nullable | max: 100',
            'email' => 'bail | nullable | email | max: 30 | unique:users,email,'.$user->id,
            'password' => 'bail | nullable | min: 6 | max: 100 | confirmed'
        ]);

        $user->name = $request->name ?? $user->name;
        $user->email = $request->email ?? $user->email;
        $user->password = Hash::make($request->passowrd) ?? $user->password;
        $user->save();
        return redirect()->back()->with('success', "User ($user->name) is updated successfully");
    }

    /**
     * Delete an user
     *
     * @param [type] $id
     * @return void
     */
    public function delete_user($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->back()->with('success', "User ($user->name) is deleted successfully");
    }
    /** USER MODULE END HERE  */

    // CLIENT MODULE START FROM HERE
    /**
     * Index function for admin to view
     * dashboard of an admin
     * 
     * @return view with all users
     */
    public function client_list()
    {
        $clients = User::whereUserType(1)->latest()->get();
        return view('admin.client.client_list', compact('clients'));
    }

    /**
     * Client create form
     *
     * @return view
     */
    public function create_client()
    {
        return view('admin.client.create');
    }

    /**
     * Store a Client
     *
     * @return Response 
     */
    public function store_client(CreateUserRequest $request)
    {
        $request['user_type'] = 1;
        $client = User::create($request->all());
        return redirect()->back()->with('success', "Client ($client->name) is added successfully");
    }

    /**
     * Client edit form
     *
     * @param [type] $id
     * @return view
     */
    public function edit_client($id)
    {
        $client = User::find($id);
        return view('admin.client.edit', compact('client'));
    }

    /**
     * Update a Client
     *
     * @param [type] $id
     * @return view
     */
    public function update_client(Request $request, $id)
    {
        $client = User::find($id);

        $request->validate([
            'name' => 'bail | nullable | max: 100',
            'email' => 'bail | nullable | email | max: 30 | unique:users,email,'.$client->id,
            'password' => 'bail | nullable | min: 6 | max: 100 | confirmed'
        ]);

        $client->name = $request->name ?? $client->name;
        $client->email = $request->email ?? $client->email;
        $client->password = Hash::make($request->passowrd) ?? $client->password;
        $client->save();
        return redirect()->back()->with('success', "Client ($client->name) is updated successfully");
    }

    /**
     * Delete a Client
     *
     * @param [type] $id
     * @return void
     */
    public function delete_client($id)
    {
        $client = User::find($id);
        $client->delete();
        return redirect()->back()->with('success', "Client ($client->name) is deleted successfully");
    }
    /** CLIENT MODULE END HERE */

    // TASK MODULE START FROM HERE
    /**
     * All task of the system
     * 
     * @return view with all tasks
     */
    public function all_task()
    {
        $tasks = Task::with('users', 'task_files')->latest()->paginate(10);
        // return $tasks;
        return view('admin.task.all_tasks', compact('tasks'));
    }

    /**
     * Task create form
     *
     * @return view
     */
    public function create_task()
    {
        $clients = User::whereUserType(1)->latest()->get();
        $users = User::whereUserType(2)->latest()->get();
        return view('admin.task.create', compact('clients', 'users'));
    }

    /**
     * Store a task
     *
     * @return Response 
     */
    public function store_task(TaskRequest $request)
    {

        // return Str::random(20) . uniqid();

        $task = new Task();
        $task->title = $request->title;
        $task->details = $request->details;

        /**Generate Slug for the title */
        $task->slug = Str::random(25) . uniqid();

        /**Check for uniqueness of the slug....If Not, Append a random unique id based on the microtime */
        if (Task::where('slug', $task->slug)->first()) {
            $task->slug = $task->slug . '-' . uniqid();
        }

        // store the task in 'tasks table'
        $task->save();

        /**For Storing task and client */
        $taskClient = new TaskUser();
        $taskClient->task_id = $task->id;
        $taskClient->user_id = $request->client_name;
        $taskClient->save();

        $taskUser = new TaskUser();
        $taskUser->task_id = $task->id;
        $taskUser->user_id = $request->user_name;
        $taskUser->save();

        return redirect()->back()->with('success', "Task ($task->title) is added successfully");
    }

    /**
     * Task edit form
     *
     * @param [type] $id
     * @return view
     */
    public function edit_task($id)
    {
        $task = Task::with('users')->whereId($id)->first();
        $clients = User::whereUserType(1)->latest()->get();
        // return $task;
        $users = User::whereUserType(2)->latest()->get();
        return view('admin.task.edit', compact('task', 'clients', 'users'));
    }

    /**
     * Update a Task
     *
     * @param [type] $id
     * @return view
     */
    public function update_task(TaskRequest $request, $id)
    {
        $task = Task::whereId($id)->first();

        // return $task;

        $task->title = $request->title;
        $task->details = $request->details;

        // store the task in 'tasks table'
        $task->save();

        /**For Storing task and client */
        $taskClient = TaskUser::where('task_id', $task->id)->get();
        // return $taskClient;
        $loop = 2 - count($taskClient);
        //  return $loop;

        switch ($loop) {
            case 0:
                $taskCLientUpdate = TaskUser::find($taskClient[0]->id); 
                $taskCLientUpdate->user_id = $request->client_name;
                $taskCLientUpdate->save();

                $taskCLientUpdate = TaskUser::find($taskClient[1]->id);
                $taskCLientUpdate->user_id = $request->user_name;
                $taskCLientUpdate->save();
                break;
            case 1:
                $taskCLientUpdate = TaskUser::find($taskClient[0]->id);
                $taskCLientUpdate->user_id = $request->client_name;
                $taskCLientUpdate->save();

                $taskCLientUpdate = new TaskUser();
                $taskCLientUpdate->task_id = $task->id;
                $taskCLientUpdate->user_id = $request->user_name;
                $taskCLientUpdate->save();
                
                break;
            
            case 2:
                $taskCLientUpdate = new TaskUser();
                $taskCLientUpdate->task_id = $task->id;
                $taskCLientUpdate->user_id = $request->client_name;
                $taskCLientUpdate->save();

                $taskCLientUpdate = new TaskUser();
                $taskCLientUpdate->task_id = $task->id;
                $taskCLientUpdate->user_id = $request->user_name;
                $taskCLientUpdate->save();

                break;
        }

        return redirect()->back()->with('success', "Task ($task->title) is updated successfully");
    }

    /**
     * Delete a task
     *
     * @param [type] $id
     * @return void
     */
    public function delete_task($id)
    {
        $task = Task::find($id);
        $task->delete();
        return redirect()->back()->with('success', "Task ($task->title) is deleted successfully");
    }

    public function notify_client($id)
    {
        $task = Task::whereId($id)->with('users')->first();
        $client = User::find($task->users[0]->id);
        // return $client;
        $client->notify(new ClientTaskNotification($task));
        return redirect()->back()->with('success', "Client ($client->name) is notified successfully");
    }
}
