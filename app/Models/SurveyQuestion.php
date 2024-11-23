<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{
    use HasFactory;

    public function add(int $surveyId, array $question): void
    {
        $this->survey_id    = $surveyId;
        $this->type         = $question['type'];
        $this->description  = $question['description'];
        $this->question     = $question['question'];
        $this->data         = !empty($question['data']) ? json_encode($question['data']) : json_encode([]);
        $this->save();
    }

    public static function edit(array $question): bool
    {
        return SurveyQuestion::where('id', $question['id'])->update($question);
    }

    public static function remove(array $questionsToDelete): bool
    {
        return SurveyQuestion::whereIn('id', $questionsToDelete)->delete();
    }
}
