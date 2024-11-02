<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyQuestionAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'survey_question_id',
        'survey_answer_id',
        'answer'
    ];

    public static function add(array $data): void
    {
        SurveyQuestionAnswer::create([
            'survey_question_id' => $data['survey_question_id'],
            'survey_answer_id'   => $data['survey_answer_id'],
            'answer'             => is_array($data['answer']) ? json_encode($data['answer']) : $data['answer']
        ]);
    }
}
