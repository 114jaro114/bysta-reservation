<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register()
    {
        $validatedData = request()->validate([
            'name' => 'unique:users|required',
            'email' => 'unique:users|required',
            'password' => 'required'
        ]);

        $user = new User([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'status'  => 'offline'
        ]);
        $user->save();

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function login()
    {
        $credentials = request()->only('email', 'password');
        $token = Auth::attempt($credentials);

        if (!$token) {
            return response()->json([
                'error' => 'Bad credentials.'
            ], 401);
        } else {
            User::where('id', auth()->user()->id)->update(['status' => 'online']);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        User::where('id', auth()->user()->id)->update(['status' => 'offline']);

        Auth::logout();

        return response()->json(['msg' => 'Logged out.'], 200);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function respondWithToken($token)
    {
        return response()->json([
            'user' => auth()->user(),
            'token' => $token
        ], 201);
    }
}
