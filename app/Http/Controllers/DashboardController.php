<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\SurveyAnswerResource;
use App\Http\Resources\SurveyResource;
use App\Models\Survey;
use App\Models\SurveyAnswer;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Total Number of Surveys
        $totalSurveys = Survey::totalSurveys($user);

        // Latest Survey
        $latestSurvey = Survey::latestSurvey($user);

        // Total Number of Answers
        $totalAnswers = SurveyAnswer::totalAnswers($user);

        // Latest 5 Answers
        $latestAnswers = SurveyAnswer::latestAnswers($user);

        return [
            'totalSurveys'  => $totalSurveys,
            'latestSurvey'  => $latestSurvey ? new SurveyAnswerResource($latestSurvey) : null,
            'totalAnswers'  => $totalAnswers,
            'latestAnswers' => SurveyAnswerResource::collection($latestAnswers)
        ];
    }
}
