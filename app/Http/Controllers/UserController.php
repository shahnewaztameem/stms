<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
use App\TaskFile;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    /**
     * Get all the tasks for the logged in User
     *
     * @return view with the tasks
     */
    public function index()
    {
        $user = User::whereId(auth()->id())->with('tasks')->first();
        // return $user;
        return view('user.home', compact('user'));
    }

    /**
     * View a single task 
     * 
     * @param [type] $slug
     * @return void
     */
    public function view($slug)
    {
        $task = Task::where('slug', $slug)->with('users', 'task_files', 'feedback')->first();
        // return $task;
        return view('user.view_task', compact('task'));
    }

    /**
     * Store a files from the assigned user
     * for an individual task
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     */
    public function store_file(Request $request, $id)
    {
        $request->validate([
            'task_files' => 'required'
        ]);

        if ($request->hasFile('task_files')) {
            // return $request;
            $i = 0;
            $destinationPath = public_path() . '/img/task/';
            foreach ($request->task_files as $task_file) {
                $i++;
                $input['imagename'] = 'Task_' . $id . "_" . Str::random(5) . $i . '.' . $task_file->getClientOriginalExtension();

                $task_file->move($destinationPath, $input['imagename']);

                $fileurl = 'img/task/' . $input['imagename'];
                $file = new TaskFile();
                $file->task_id = $id;
                $file->user_id = auth()->id();
                $file->file_url = $fileurl;
                $file->save();
            }
            return redirect()->back()->with('success', "File uploaded successfully");
        }

        return redirect()->back()->with('err', "No file found");
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
}