<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    //
    protected $fillable = [
        'hotel_id',
        'type',
        'prix',
        'capacite',
        'image'
    ];

    public function hotel()
    {
        return $this->belongsTo(\App\Models\Hotel::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
