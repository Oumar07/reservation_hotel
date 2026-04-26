<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //
    protected $fillable = [
        'client_id',
        'hotel_id',
        'note',
        'commentaire'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
