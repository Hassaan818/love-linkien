<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VenueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'featured_image' => $this->featured_image
                ? asset($this->featured_image)
                : null,
            'gallery' => $this->gallery
                ? collect(json_decode($this->gallery))
                ->map(fn($image) => asset($image))
                ->toArray()
                : [],
            'description' => $this->description,

        ];
    }
}
