<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
use App\TaskFile;
use App\TaskUser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CreateUserRequest;
use App\Notifications\ClientTaskNotification;
use App\NotifyClient;

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
     * Show all the users
     * 
     * @return view with all users
     */
    public function user_list()
    {
        $users = User::whereIn('user_type', [0, 2])->latest()->get();
        return view('admin.user.user_list', compact('users'));
    }

    /**
     * User create form
     *
     * @return view
     */
    public function create_user()
    {
        // return view('admin.user.create');
        return view('admin.user.add_user');
    }

    /**
     * Store an User
     *
     * @return Response 
     */
    public function store_user(CreateUserRequest $request)
    {
        // $request['user_type'] = 2;
        $request['password'] = Hash::make($request->password);
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

        // return $request;

        $request->validate([
            'name' => 'bail | nullable | max: 100',
            'email' => 'bail | nullable | email | max: 30 | unique:users,email,' . $user->id,
            'password' => 'bail | nullable | min: 6 | max: 100 | confirmed'
        ]);

        $user->name = $request->name ?? $user->name;
        $user->email = $request->email ?? $user->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
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
        // return view('admin.client.create');
        return view('admin.client.add_user');
    }

    /**
     * Store a Client
     *
     * @return Response 
     */
    public function store_client(CreateUserRequest $request)
    {
        $request['user_type'] = 1;
        $request['password'] = Hash::make($request->password);
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
            'email' => 'bail | nullable | email | max: 30 | unique:users,email,' . $client->id,
            'password' => 'bail | nullable | min: 6 | max: 100 | confirmed'
        ]);

        $client->name = $request->name ?? $client->name;
        $client->email = $request->email ?? $client->email;
        if ($request->password) {
            $client->password = Hash::make($request->password);
        }
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
        $task->slug = Str::slug($request->title);

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


        if ($request->hasFile('task_files')) {
            // return $request;
            $i = 0;
            $destinationPath = public_path() . '/img/task/';
            foreach ($request->task_files as $task_file) {
                $i++;
                $input['imagename'] = 'Task_' . $task->id . "_" . Str::random(5) . $i . '.' . $task_file->getClientOriginalExtension();

                $task_file->move($destinationPath, $input['imagename']);

                $fileurl = 'img/task/' . $input['imagename'];
                $file = new TaskFile();
                $file->task_id = $task->id;
                $file->user_id = auth()->id();
                $file->file_url = $fileurl;
                $file->save();
            }
        } else {
            return redirect()->back()->with('err', "No file found");
        }
        return redirect()->back()->with('success', "Task ($task->title) is added successfully");
    }


    /**
     * View a single task 
     * 
     * @param [type] $slug
     * @return void
     */
    public function view_task($slug)
    {
        $task = Task::where('slug', $slug)->with('users', 'task_files', 'feedback')->first();
        // return $task;
        return view('admin.task.view_task', compact('task'));
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

        if ($task->title != $request->title) {
            /**Generate Slug for the title */
            $task->slug = Str::slug($request->title);

            /**Check for uniqueness of the slug....If Not, Append a random unique id based on the microtime */
            if (Task::where('slug', $task->slug)->first()) {
                $task->slug = $task->slug . '-' . uniqid();
            }
        }

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

        if ($request->hasFile('task_files')) {
            // return $request;
            $i = 0;
            $destinationPath = public_path() . '/img/task/';
            foreach ($request->task_files as $task_file) {
                $i++;
                $input['imagename'] = 'Task_' . $task->id . "_" . Str::random(5) . $i . '.' . $task_file->getClientOriginalExtension();

                $task_file->move($destinationPath, $input['imagename']);

                $fileurl = 'img/task/' . $input['imagename'];
                $file = new TaskFile();
                $file->task_id = $task->id;
                $file->user_id = auth()->id();
                $file->file_url = $fileurl;
                $file->save();
            }
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
        $taskFiles = TaskFile::where('task_id', $id)->get();

        foreach ($taskFiles as $file) {
            $filePath = public_path('\\');
            // return $filePath . $file->file_url;

            if (File::exists($filePath . $file->file_url)) {
                File::delete($filePath . $file->file_url);
            }

            $file->delete();
        }

        $task->delete();
        return redirect()->back()->with('success', "Task ($task->title) is deleted successfully");
    }


    /**
     * Delete a file
     *
     * @param [type] $id
     * @return void
     */
    public function delete_file($id)
    {
        $file = TaskFile::find($id);

        $filePath = public_path('\\');
        // return $filePath . $file->file_url;

        if (File::exists($filePath . $file->file_url)) {
            File::delete($filePath . $file->file_url);
        }

        $file->delete();
        return redirect()->back()->with('success', "File ($file->file_url) is deleted successfully");
    }

    public function notify_client($id)
    {
        $task = Task::whereId($id)->with('users')->first();
        $client = User::find($task->users[0]->id);
        // return $client;
        $notifyClient = NotifyClient::where('task_id', $task->id)->first();
        if (!$notifyClient) {
            $notifyClient = new NotifyClient();
            $notifyClient->task_id = $task->id;
            $notifyClient->user_id = $client->id;
            $notifyClient->hash_url = Str::random(35) . "_" . $task->id . "_" . uniqid();
            $notifyClient->save();
        }
        $client->notify(new ClientTaskNotification($task, $notifyClient));
        return redirect()->back()->with('success', "Client ($client->name) is notified successfully");
    }
}