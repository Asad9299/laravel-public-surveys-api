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

    public static function list(int $user_id)
    {
        return self::where('user_id', $user_id)->paginate();
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
}
