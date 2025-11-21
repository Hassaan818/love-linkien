<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvailabilitySlot extends Model
{
    protected $fillable = ['availability_id', 'start_time', 'end_time'];

    public function availability()
    {
        return $this->belongsTo(Availability::class);
    }
}
