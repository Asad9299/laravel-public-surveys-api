<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SurveyQuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type'        => $this->type,
            'question'    => $this->question,
            'description' => $this->description,
            'data'        => $this->data ? json_decode($this->data) :  [],
        ];
    }
}
