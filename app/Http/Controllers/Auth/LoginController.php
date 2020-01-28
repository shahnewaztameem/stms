<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\NotifyClient;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Task;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout', 'task_notify');
    }

    public function task_notify($hash_url)
    {
        $clientNotify = NotifyClient::where('hash_url', $hash_url)->first();
        if (auth()->user()) {
            Auth::logout();
        }
        $task = Task::where('id', $clientNotify->task_id)->with('users')->first();
        $user = User::find($task->users[0]->id);
        Auth::login($user);
        // return $task;
        return redirect()->route('client.task.view', $task->slug);
    }
}