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

    public static function add(int $surveyId): SurveyAnswer
    {
        return self::create([
            'survey_id'  => $surveyId,
            'start_date' => Carbon::now()->format('Y-m-d H:i:s'),
            'end_date'   => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
