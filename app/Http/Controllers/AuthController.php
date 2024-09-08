<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

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
}
