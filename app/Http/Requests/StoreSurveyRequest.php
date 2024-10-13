<?php

namespace App\Http\Requests;

use App\Enums\SurveyQuestionTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

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
            'questions'   => 'present|array',
            'questions.*.question' => 'required|string|max:1000',
            'questions.*.type' => ['required', new Enum(SurveyQuestionTypes::class)],
            'questions.*.description' => 'nullable|string',
            'questions.*.data' => [
                'present',
                'required_if:questions.*.type,' . SurveyQuestionTypes::Select->value . ',' . SurveyQuestionTypes::Radio->value . ',' . SurveyQuestionTypes::Checkbox->value,
            ],
            'questions.*.data.options' => [
                'required_with:questions.*.data',
                'array',
                'min:1',
            ],
            'questions.*.data.options.*.text' => [
                'required_with:questions.*.data.options'
            ],
            'questions.*.survey_id' => 'exists:App\Models\Survey,id'

        ];
    }

    public function messages(): array
    {
        return [
            'questions.*.question.required' => 'Each question must have a question text.',
            'questions.*.question.string' => 'The question text must be a string.',
            'questions.*.question.max' => 'The question text may not be greater than 1000 characters.',

            'questions.*.type.required' => 'Each question must have a type.',
            'questions.*.type.enum' => 'The selected question type is invalid.',

            'questions.*.description.string' => 'The description must be a string.',

            'questions.*.data.present' => 'Data field must be present.',
            'questions.*.data.required_if' => 'Data must be provided for selection, radio, or checkbox questions.',

            'questions.*.data.options.required_with' => 'Options are required when data is present.',
            'questions.*.data.options.array' => 'Options must be an array.',
            'questions.*.data.options.min' => 'There must be at least one option provided.',

            'questions.*.data.options.*.text.required_with' => 'Option text is required when options are present.',

            'questions.*.survey_id.exists' => 'The selected survey ID is invalid.',
        ];
    }
}
