<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MeetingResource extends JsonResource
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
            'user_id' => $this->user_id,
            'admin_user' => $this->whenLoaded('adminUser', function () {
                return [
                    'id' => $this->adminUser->id,
                    'name' => $this->adminUser->name,
                    'email' => $this->adminUser->email,
                    'image' => $this->adminUser->image ? asset($this->adminUser->image) : null,
                ];
            }),
            'meeting_date' => $this->meeting_date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
