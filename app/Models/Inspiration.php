<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inspiration extends Model
{
    protected $fillable = ['name', 'slug', 'gallery', 'notes', 'short_description', 'user_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
