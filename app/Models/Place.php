<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $fillable = [
        'hotel_id',
        'nom',
        'type',
        'description',
        'adresse',
        'image',
    ];

    /**
     * Un lieu appartient à un hôtel.
     */
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
