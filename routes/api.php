<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SurveyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->group(function () {
    Route::resource('survey', SurveyController::class);
});

# Register Route
Route::post('/register', [AuthController::class, 'register']);

# Login Route
Route::post('/login', [AuthController::class, 'login']);
