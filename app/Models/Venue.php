<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'featured_image',
        'gallery',
        'short_description',
        'description',
        'venue_owner',
        'venue_location',
    ];

    protected $casts = [
        'gallery' => 'array',
    ];
}
