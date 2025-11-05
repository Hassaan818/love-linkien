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
            'title' => $this->title,
            'slug' => $this->slug,
            'location' => $this->venue_location,
            'Owner' => $this->venue_owner,
            'featured_image' => $this->featured_image
                ? asset($this->featured_image)
                : null,
            'gallery' => $this->gallery
                ? collect(json_decode($this->gallery))
                ->map(fn($image) => asset($image))
                ->toArray()
                : [],
            'description' => $this->description,
            'short_description' => $this->short_description

        ];
    }
}
