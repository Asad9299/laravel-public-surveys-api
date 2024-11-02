<?php

use App\Models\Survey;
use App\Models\SurveyAnswer;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
