<?php

namespace App\Http\Requests;

use App\Models\Survey;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UpdateSurveyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'       => 'required|string|max:1000',
            'slug'        => [
                'nullable',
                Rule::unique('surveys', 'slug')->ignore($this->survey['id'])->withoutTrashed()
            ],
            'status'      => 'nullable|boolean',
            'image'       => 'nullable|string',
            'user_id'     => 'exists:users,id',
            'description' => 'nullable|string',
            'expire_date' => 'nullable|date|after:tomorrow',
            'questions'   => 'array',
        ];
    }
}
