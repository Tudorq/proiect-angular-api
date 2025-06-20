<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function deleteUser(Request $request)
    {
        $userId = $request->route()->parameter('id');
        $user = User::firstWhere('id', $userId);
        $user->tokens()->delete();
        $user->delete();

        return response()->json([
            'message' => 'Account deleted succesfully',
        ], 200);
    }

    public function getUser(Request $request)
    {
        $userId = $request->route()->parameter('id');
        $user = User::firstWhere('id', $userId);

        return response()->json([
            'user' => $user,
        ], 200);
    }

    public function updateUser(Request $request)
    {
        $userId = $request->route()->parameter('id');
        $user = User::firstWhere('id', $userId);

        $validatedData = $request->validate([

            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
        ]);
        
        $firstName = $validatedData['first_name'];
        $lastName = $request['last_name'];
        
        $user->first_name = $firstName;
        $user->last_name = $lastName;

        $user->save();

        return response()->json([
            'user' => $user,
        ], 200);
    }
}
