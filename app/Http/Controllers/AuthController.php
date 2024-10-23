<?php

namespace App\Http\Controllers;

use App\Events\Notify;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create($data);

        $token = $user->createToken('auth_token')->plainTextToken;

        // send email to user acknowledging registration (use event)
        event(new Notify($user, (object)[
            'subject' => 'User Registration',
            'view' => 'emails.register',
            'attachments' => [],
            'data' => $user,
        ]));

        return response()->json(['user' => $user, 'token' => $token], 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($data)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['user' => $user, 'token' => $token]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
