<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    //
    protected $fillable = [
        'hotel_id',
        'nom',
        'description',
        'localisation'
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
