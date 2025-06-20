<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request) {
        // $responseData = json_decode($request->getContent(), true);

        $validatedData = $request->validate([
            'email' => ['required'],
            'password' => ['required']]);
        $credentials = [
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
        ]; 

        $user = User::firstWhere('email', $validatedData['email']);

        
        if(!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Authentication failed',
                'status' => 401
            ], 401); 
        } else {
            return response()->json([
                'message' => 'Succesfully Authenticated',
                'token' => $user->createToken('Token')->plainTextToken,
            ], 200);
        }

    }

    public function logout(Request $request)
    {
        $userId = $request->input('id');

        $user = User::firstWhere('id', $userId);
        $user->tokens()->delete();

        return response()->json([
            'message' => 'Logged out',
        ], 200);
    }
    public function register(Request $request) {

        // $responseData = json_decode($request->getContent(), true);

        $validatedData = $request->validate([

            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'email' => ['required', 'unique:users', 'max:255'],
            'password' => ['required',
                            'min:6',
                            'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!@$#%]).*$/',]]);
        
        $firstName = $validatedData['first_name'];
        $lastName = $validatedData['last_name'];
        $email = $validatedData['email'];
        $password = $validatedData['password'];

        $user = User::Create(['first_name' => $firstName, 'last_name' => $lastName, 'email' => $email, 'password' => Hash::make($password)]);

        $user->save();

        return response()->json(
            [
                'message' => 'Succesfully Registered',
                'token' => $user->createToken('Token')->plainTextToken,
            ], 200
        );
    }
}
