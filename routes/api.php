<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

# Register Route
Route::post('/register', [AuthController::class, 'register']);

# Login Route
Route::post('/login', [AuthController::class, 'login']);
