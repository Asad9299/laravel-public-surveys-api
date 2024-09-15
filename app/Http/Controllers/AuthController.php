<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => $request->password,
            'password_confirmation ' => $request->password_confirmation
        ]);

        # Generate Sanctum Token
        $token = $user->createToken('main')->plainTextToken;

        return response([
            'user'  => $user,
            'token' => $token
        ]);
    }

    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            $user = Auth::user();

            # Generate Sanctum Token
            $token = $user->createToken('main')->plainTextToken;

            return response([
                'user'  => $user,
                'token' => $token
            ]);
        }
        return response([
            'error' => 'The provided credentials are incorrect'
        ], 401);
    }
}
