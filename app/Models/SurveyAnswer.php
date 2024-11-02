<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyAnswer extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'survey_id',
        'start_date',
        'end_date'
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public static function add(int $surveyId): SurveyAnswer
    {
        return self::create([
            'survey_id'  => $surveyId,
            'start_date' => Carbon::now()->format('Y-m-d H:i:s'),
            'end_date'   => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }

    public static function totalAnswers(User $user): int
    {
        return self::query()
            ->where('user_id', $user->id)
            ->join('surveys', 'survey_answers.survey_id', '=', 'surveys.id')
            ->latest('end_date')
            ->count();
    }

    public static function latestAnswers(User $user): int
    {
        return self::query()
            ->join('surveys', 'survey_answer.survey_id', '=', 'survey.id')
            ->where('surveys.user_id', $user->id)
            ->latest('end_date')
            ->limit(5)
            ->getModels('survey_answers.*');
    }
}
