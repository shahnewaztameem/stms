<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Support\Facades\Hash;

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
    // USER MODULE END HERE

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
     * Store an Client
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
     * Update and Client
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
     * Delete an Client
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
}
