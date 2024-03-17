<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Rol;
use App\Models\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

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
        $user->is_active = true;

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

        Log::where('user_id', $user->id)->delete();

        $user->delete();

        return response()->json('User deleted successfully');
    }

    public function createGuestToken()
    {
        $guestUser = new User;
        $guestUser->name = 'Guest_' . Str::random(6);
        $guestUser->email = Str::random(10) . '@gmail.com';
        $guestUser->password = Hash::make(Str::random(12));
        $guestUser->role_id = 3;
        $guestUser->is_active = 1;
        $guestUser->save();

        $token = auth()->login($guestUser);

        return response()->json(['token' => $token]);
    }
}