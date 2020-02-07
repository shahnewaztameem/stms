<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
use App\NotifyClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['login', 'signup', 'login_from_notification']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $token = auth()->claims(['sub' => auth()->user()->id])->attempt($credentials);
        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user_name' => auth()->user()->name,
            'user_type' => auth()->user()->user_type,
        ]);
    }

    
    public function login_from_notification($hash_url)
    {
        $clientNotify = NotifyClient::where('hash_url', $hash_url)->first();
        if ($clientNotify) {
            if (auth()->user()) {
                Auth::logout();
            }
            $task = Task::where('id', $clientNotify->task_id)->with('users')->first();
            $user = User::find($task->users[0]->id);
            $data = [];
            array_push($data, $user);
            array_push($data, $task);
            // return $task;
            return response()->json($data, Response::HTTP_FOUND);   
        } else {
            return response()->json(null, Response::HTTP_NOT_FOUND);
        }
        // return redirect()->route('client.task.view', $task->slug);
    }
}