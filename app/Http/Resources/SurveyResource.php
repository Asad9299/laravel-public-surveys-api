<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SurveyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // TODO: Add response columns as needed
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'slug'        => $this->slug,
            'expire_date' => $this->expire_date,
        ];
    }
}
