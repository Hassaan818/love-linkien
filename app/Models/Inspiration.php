<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inspiration extends Model
{
    protected $fillable = ['name', 'category_id', 'slug', 'image', 'notes', 'short_description', 'tags'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
