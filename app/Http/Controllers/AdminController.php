<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
use App\TaskFile;
use App\TaskUser;
use App\DesignPhase;
use App\DevelopmentPhase;
use App\NotifyClient;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CreateClientRequest;
use App\Notifications\ClientTaskNotification;
use App\SEOPhase;

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
        $tasks = Task::with(
            'client',
            'project_manager',
            'task_files',
            'task_files.wireframe_feedback',
            'design_phase',
            'design_phase.design_pm',
            'development_phase',
            'development_phase.dev_pm',
            'seo_phase',
            'seo_phase.seo_pm',
            'feedback'
        )->latest()->paginate(9);
        // return $tasks;
        return view('admin.home', compact('tasks'));
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
            'phone_number' => 'bail | nullable | max: 16 | min: 8',
            'other_info' => 'bail | nullable | max: 250',
            'password' => 'bail | nullable | min: 6 | max: 100 | confirmed',
        ]);

        $user->name = $request->name ?? $user->name;
        $user->email = $request->email ?? $user->email;
        $user->phone_number = $request->phone_number ?? $user->phone_number;
        $user->user_type = $request->user_type ?? $user->user_type;
        $user->other_info = $request->other_info ?? $user->other_info;
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
        return view('admin.client.create');
        // return view('admin.client.add_user');
    }

    /**
     * Store a Client
     *
     * @return Response 
     */
    public function store_client(CreateClientRequest $request)
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
            'company' => 'bail | required | max: 100',
            'email' => 'bail | nullable | email | max: 30 | unique:users,email,' . $client->id,
            'phone_number' => 'bail | nullable | max: 16 | min: 8',
            'other_info' => 'bail | nullable | max: 250',
            'password' => 'bail | nullable | min: 6 | max: 100 | confirmed',
        ]);

        $client->name = $request->name ?? $client->name;
        $client->company = $request->company ?? $client->company;
        $client->email = $request->email ?? $client->email;
        $client->phone_number = $request->phone_number ?? $client->phone_number;
        $client->other_info = $request->other_info ?? $client->other_info;
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
        $tasks = Task::with('client', 'project_manager', 'task_files', 'design_phase', 'design_phase.design_pm', 'development_phase', 'development_phase.dev_pm', 'seo_phase', 'seo_phase.seo_pm')->latest()->get();
        // return $tasks;
        return view('admin.task.task_list', compact('tasks'));
    }

    public function add_task()
    {
        $clients = User::whereUserType(1)->latest()->get();
        $users = User::whereUserType(2)->latest()->get();
        $tasks = Task::latest()->get();
        $tab = "home";
        return view('admin.task.add_task', compact('clients', 'users', 'tasks'));
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
        return view('admin.task.add_project', compact('clients', 'users'));
    }

    /**
     * Store a project details
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

        $task->project_manager_id = $request->project_manager_name;
        $task->client_id = $request->client_name;

        // store the task in 'tasks table'
        $task->save();

        return redirect()->back()->with('success', "Task ($task->title) is added successfully");
    }


    /**
     * Create Design Phase form
     *
     * @return void
     */
    public function create_design_phase()
    {
        $users = User::whereUserType(2)->latest()->get();
        $tasks = Task::latest()->get();
        return view('admin.task.add_design', compact('tasks', 'users'));
    }

    /**
     * Store/Update Design phase data
     *
     * @param Request $request
     * @return void
     */
    public function store_design_phase(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'project_title' => 'required',
            'start_date' => 'required | date',
            'end_date' => 'required | date',
            'design_pm_name' => 'required',
            'design_status' => 'required',
        ]);

        $tab = 'design';

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->withTab($tab);
        }

        if (!$request->has('show_to_client')) {
            $request->show_to_client = false;
        } else {
            $request->show_to_client = true;
        }


        $designPhase = DesignPhase::whereTaskId($request->project_title)->with('task')->first();
        // UPDATE TASK
        if ($designPhase) {
            $designPhase->start_date = $request->start_date;
            $designPhase->end_date = $request->end_date;
            $designPhase->design_pm_id = $request->design_pm_name;
            $designPhase->show_to_client = $request->show_to_client;
            $designPhase->design_status = $request->design_status;
            $designPhase->save();

            if ($request->hasFile('task_files')) {
                // return $request;
                $i = 0;
                $destinationPath = public_path() . '/img/task/';
                foreach ($request->task_files as $task_file) {

                    $input['imagename'] = 'Task_' . $designPhase->task->id . "_" . Str::random(5) . $i . '.' . $task_file->getClientOriginalExtension();

                    $task_file->move($destinationPath, $input['imagename']);

                    $fileurl = 'img/task/' . $input['imagename'];
                    $file = new TaskFile();
                    $file->task_id = $designPhase->task->id;
                    $file->user_id = auth()->id();
                    $file->file_title = $request->file_title[$i];
                    $file->file_url = $fileurl;
                    $file->save();
                    $i++;
                }
            }
            $task = Task::find($designPhase->task_id);
            return redirect()->back()->with('successDesign', "Design Phase for ($task->title) is updated successfully");
        } else {
            // STORE A TASK 
            if ($request->hasFile('task_files')) {
                $designPhase = new DesignPhase();
                $designPhase->task_id = $request->project_title;
                $designPhase->start_date = $request->start_date;
                $designPhase->end_date = $request->end_date;
                $designPhase->design_status = $request->design_status;
                $designPhase->design_pm_id = $request->design_pm_name;
                $designPhase->show_to_client = $request->show_to_client;
                $designPhase->save();

                $i = 0;
                $destinationPath = public_path() . '/img/task/';
                foreach ($request->task_files as $task_file) {

                    $input['imagename'] = 'Task_' . $designPhase->task_id . "_" . Str::random(5) . $i . '.' . $task_file->getClientOriginalExtension();

                    $task_file->move($destinationPath, $input['imagename']);

                    $fileurl = 'img/task/' . $input['imagename'];
                    $file = new TaskFile();
                    $file->task_id = $designPhase->task_id;
                    $file->user_id = auth()->id();
                    $file->file_title = $request->file_title[$i];
                    $file->file_url = $fileurl;
                    $file->save();
                    $i++;
                }
                $task = Task::find($designPhase->task_id);
                return redirect()->back()->with('successDesign', "Design Phase for ($task->title) is added successfully");
            } else {
                return redirect()->back()->with('errDesign', "No wireframes found");
            }
        }
    }

    
    /**
     * Create Development Phase form
     *
     * @return void
     */
    public function create_development_phase()
    {
        $users = User::whereUserType(2)->latest()->get();
        $tasks = Task::latest()->get();
        return view('admin.task.add_development', compact('tasks', 'users'));
    }

    /**
     * Store/Update Development phase data
     *
     * @param Request $request
     * @return void
     */
    public function store_development_phase(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_title' => 'required',
            'repo_url' => 'bail | required | url',
            'dev_start_date' => 'required | date',
            'dev_end_date' => 'required | date',
            'dev_pm_name' => 'required',
            'dev_status' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if (!$request->has('show_to_client')) {
            $request->show_to_client = false;
        } else {
            $request->show_to_client = true;
        }

        $devPhase = DevelopmentPhase::whereTaskId($request->project_title)->with('task')->first();
        // UPDATE TASK- DEVELOPMENT PHASE
        if ($devPhase) {
            $devPhase->repo_url = $request->repo_url;
            $devPhase->dev_pm_id = $request->dev_pm_name;
            $devPhase->dev_start_date = $request->dev_start_date;
            $devPhase->dev_end_date = $request->dev_end_date;
            $devPhase->dev_status = $request->dev_status;
            $devPhase->show_to_client = $request->show_to_client;
            $devPhase->save();

            $task = Task::find($devPhase->task_id);
            return redirect()->back()->with('successDevelopment', "Development Phase for ($task->title) is updated successfully");
        } else {
            // STORE A TASK - DEVELOPMENT PHASE
            $devPhase = new DevelopmentPhase();
            $devPhase->task_id = $request->project_title;
            $devPhase->repo_url = $request->repo_url;
            $devPhase->dev_start_date = $request->dev_start_date;
            $devPhase->dev_end_date = $request->dev_end_date;
            $devPhase->dev_status = $request->dev_status;
            $devPhase->show_to_client = $request->show_to_client;
            $devPhase->dev_pm_id = $request->dev_pm_name;
            $devPhase->save();

            $task = Task::find($devPhase->task_id);
            return redirect()->back()->with('successDevelopment', "Development Phase for ($task->title) is added successfully");
        }
    }

    
    /**
     * Create SEO Phase form
     *
     * @return void
     */
    public function create_seo_phase()
    {
        $users = User::whereUserType(2)->latest()->get();
        $tasks = Task::latest()->get();
        return view('admin.task.add_seo', compact('tasks', 'users'));
    }

    /**
     * Store/Update SEO phase data
     *
     * @param Request $request
     * @return void
     */
    public function store_seo_phase(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_title' => 'required',
            'seo_keywords' => 'bail | required | max: 250',
            'seo_start_date' => 'required | date',
            'seo_end_date' => 'required | date',
            'seo_pm_name' => 'required',
            'seo_status' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if (!$request->has('show_to_client')) {
            $request->show_to_client = false;
        } else {
            $request->show_to_client = true;
        }

        $seoPhase = SEOPhase::whereTaskId($request->project_title)->with('task')->first();
        // UPDATE TASK- SEO PHASE
        if ($seoPhase) {
            $seoPhase->seo_keywords = $request->seo_keywords;
            $seoPhase->seo_start_date = $request->seo_start_date;
            $seoPhase->seo_end_date = $request->seo_end_date;
            $seoPhase->seo_status = $request->seo_status;
            $seoPhase->seo_pm_id = $request->seo_pm_name;
            $seoPhase->show_to_client = $request->show_to_client;
            $seoPhase->save();

            $task = Task::find($seoPhase->task_id);
            return redirect()->back()->with('success', "SEO Phase for ($task->title) is updated successfully");
        } else {
            // STORE A TASK - SEO PHASE
            $seoPhase = new SEOPhase();
            $seoPhase->task_id = $request->project_title;
            $seoPhase->seo_keywords = $request->seo_keywords;
            $seoPhase->seo_start_date = $request->seo_start_date;
            $seoPhase->seo_end_date = $request->seo_end_date;
            $seoPhase->seo_status = $request->seo_status;
            $seoPhase->show_to_client = $request->show_to_client;
            $seoPhase->seo_pm_id = $request->seo_pm_name;
            $seoPhase->save();

            $task = Task::find($seoPhase->task_id);
            return redirect()->back()->with('success', "SEO Phase for ($task->title) is added successfully");
        }
    }

    /**
     * View a single task 
     * 
     * @param [type] $slug
     * @return void
     */
    public function view_task($slug)
    {
        $task = Task::where('slug', $slug)
            ->with(
                'client',
                'project_manager',
                'task_files',
                'design_phase',
                'design_phase.design_pm',
                'development_phase',
                'development_phase.dev_pm',
                'seo_phase',
                'seo_phase.seo_pm',
                'feedback'
            )
            ->first();
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
        $task = Task::whereId($id)->first();
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
        $task->client_id = $request->client_name;
        $task->project_manager_id = $request->project_manager_name;

        // store the task in 'tasks table'
        $task->save();

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
     * Delete a Design Phase
     *
     * @param [type] $id
     * @return void
     */
    public function delete_design_phase($id)
    {
        $designPhase = DesignPhase::with('task')->whereId($id)->first();
        $taskTitle = $designPhase->task->title;
        $taskFiles = TaskFile::where('task_id', $designPhase->task_id)->get();

        foreach ($taskFiles as $file) {
            $filePath = public_path('\\');
            // return $filePath . $file->file_url;

            if (File::exists($filePath . $file->file_url)) {
                File::delete($filePath . $file->file_url);
            }

            $file->delete();
        }

        $designPhase->delete();
        return redirect()->back()->with('success', "Design Phase for ($taskTitle) is deleted successfully");
    }

    /**
     * Delete a Development Phase
     *
     * @param [type] $id
     * @return void
     */
    public function delete_dev_phase($id)
    {
        $devPhase = DevelopmentPhase::with('task')->whereId($id)->first();
        $taskTitle = $devPhase->task->title;

        $devPhase->delete();
        return redirect()->back()->with('success', "Development Phase for ($taskTitle) is deleted successfully");
    }

    /**
     * Delete a SEO Phase
     *
     * @param [type] $id
     * @return void
     */
    public function delete_seo_phase($id)
    {
        $seoPhase = SEOPhase::with('task')->whereId($id)->first();
        $taskTitle = $seoPhase->task->title;

        $seoPhase->delete();
        return redirect()->back()->with('success', "SEO Phase for ($taskTitle) is deleted successfully");
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
        $task = Task::whereId($id)->with('client', 'project_manager')->first();
        $client = $task->client;
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