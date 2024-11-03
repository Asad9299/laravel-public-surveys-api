<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Survey extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'image', 'title', 'slug', 'status', 'description', 'expire_date'];

    public function questions()
    {
        return $this->hasMany(SurveyQuestion::class);
    }

    public function answers()
    {
        return $this->hasMany(SurveyAnswer::class);
    }

    public static function list(int $user_id)
    {
        return self::where('user_id', $user_id)->paginate(config('app.pagination.records_per_page'));
    }

    public function add(array $data)
    {
        $data['slug']   = Str::slug($data['title']);
        $survey = self::create($data);
        return $survey;
    }

    public function remove(): bool | null
    {
        return $this->delete();
    }

    public function edit(array $data): bool
    {
        return $this->update($data);
    }

    public static function totalSurveys(User $user): int
    {
        return self::where('user_id', $user->id)->count();
    }

    public static function latestSurvey(User $user): Survey
    {
        return self::where('user_id', $user->id)->latest('created_at')->first();
    }
}
