<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSurveyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => $this->user()->id,
            'slug'    => $this->title,
        ]);
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
                Rule::unique('surveys'),
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
