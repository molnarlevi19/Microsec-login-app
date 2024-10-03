<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'user' => $user
            ]);
        }

        return response()->json(['message' => 'The provided credentials do not match our records.'], 401);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'logout successful',
        ];
    }
    
}
