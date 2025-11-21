<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InspirationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'gallery' => $this->gallery
                ? collect(json_decode($this->gallery))
                ->map(fn($image) => asset($image))
                ->toArray()
                : [],
            'notes' => $this->notes,
            'short_description' => $this->short_description,
        ];
    }
}
