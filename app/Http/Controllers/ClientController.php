<?php

namespace App\Http\Controllers;

use App\ClientFeedback;
use App\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    /**
     * Get all the tasks for the logged in client
     *
     * @return view with the tasks
     */
    public function index()
    {
        $user = User::whereId(auth()->id())->with('tasks')->first();
        // return $user;
        return view('client.home', compact('user'));
    }

    /**
     * View a single task
     * It searches with the slug for email HASH url 
     * 
     * @param [type] $slug
     * @return void
     */
    public function view($slug)
    {
        $task = Task::where('slug', $slug)->with('users', 'task_files', 'feedback')->first();
        // return $task;
        return view('client.view_task', compact('task'));
    }

    /**
     * Store a feedback from a client for an
     * individual task
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     */
    public function store_feedback(Request $request, $id)
    {
        $request->validate([
            'star' => 'required',
            'comment' => 'nullable | max: 250'
        ]);

        $feedback = new ClientFeedback();
        $feedback->task_id = $id;
        $feedback->user_id = auth()->id();
        $feedback->rating = $request->star;
        $feedback->comment = $request->comment;

        $feedback->save();

        return redirect()->back()->with('success', "Thanks for your feedback");
    }

    /**
     * Delete a feedback
     *
     * @param [type] $id
     * @return void
     */
    public function delete_feedback($id)
    {
        $feedback = ClientFeedback::find($id);
        $feedback->delete();
        return redirect()->back()->with('success', "Your feedback is deleted successfully");
    }

    /**
     * Change password form for client
     *
     * @return void
     */
    public function change_pass()
    {
        return view('client.change_pass');
    }

    /**
     * Store the new password
     *
     * @return void
     */
    public function store_pass(Request $request)
    {
        $request->validate([
            'password' => 'bail | required | min: 6 | confirmed'
        ]);

        $user = User::find(auth()->id());
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', "Your password is changed successfully");
    }
}