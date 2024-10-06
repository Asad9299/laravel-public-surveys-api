<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
        return [
            'id'          => $this->id,
            'image'       => $this->image,
            'image_url'   => $this->image ? config('app.url') . $this->image : '',
            'title'       => $this->title,
            'description' => $this->description,
            'slug'        => $this->slug,
            'expire_date' => Carbon::parse($this->expire_date)->format('Y-m-d'),
            'status'      => 1 === $this->status ? true : false
        ];
    }
}
