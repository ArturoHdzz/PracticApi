<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Rol;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get();
        return response()->json(["data" => $users]);
    }

    public function roles()
    {
        $roles = Rol::all();
        return response()->json(["data" => $roles]);
    }

    public function show($id)
    {
        $user = User::with('role')->find($id);
        return response()->json(["data" => $user]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role_id' => 'required|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role_id = $request->role_id;
        $user->save();

        $user->load('role');

        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'nullable|min:8',
            'role_id' => 'required|exists:roles,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->role_id = $request->role_id;
        $user->save();

        $user->load('role');

        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json('User deleted successfully');
    }
}