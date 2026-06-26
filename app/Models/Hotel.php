<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = [
        'nom',
        'localisation',
        'pays',
        'description',
        'image',
    ];

    /**
     * Un hôtel a plusieurs chambres.
     */
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    /**
     * Un hôtel a plusieurs avis.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Un hôtel a plusieurs lieux recommandés.
     */
    public function places()
    {
        return $this->hasMany(Place::class);
    }

    /**
     * Calcule la note moyenne de l'hôtel.
     */
    public function averageRating(): float
    {
        return round($this->reviews()->avg('note') ?? 0, 1);
    }
}
