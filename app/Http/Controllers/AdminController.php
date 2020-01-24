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
}
