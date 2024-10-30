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

    # Survey by Slug Route
    Route::get('survey-by-slug/{survey:slug}', [SurveyController::class, 'getSurveyBySlug']);

    # Save Survey Question's Answers Route
    Route::post('survey/{survey}', [SurveyController::class, 'saveAnswers']);
});

# Register Route
Route::post('/register', [AuthController::class, 'register']);

# Login Route
Route::post('/login', [AuthController::class, 'login']);
