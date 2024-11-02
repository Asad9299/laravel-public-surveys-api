<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SurveyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->group(function () {
    # Survey CRUD Route
    Route::resource('survey', SurveyController::class);

    # Survey by Slug Route
    Route::get('survey-by-slug/{survey:slug}', [SurveyController::class, 'getSurveyBySlug']);

    # Save Survey Question's Answers Route
    Route::post('survey/{survey}/answer', [SurveyController::class, 'saveAnswers']);

    # Load Dashboard Data
    Route::post('/dashboard', [DashboardController::class, 'index']);
});

# Register Route
Route::post('/register', [AuthController::class, 'register']);

# Login Route
Route::post('/login', [AuthController::class, 'login']);
