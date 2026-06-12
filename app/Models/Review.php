<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'client_id',
        'hotel_id',
        'room_id',
        'booking_id',
        'note',
        'commentaire',
    ];

    protected $casts = [
        'note' => 'integer',
    ];

    /**
     * L'avis appartient à un client.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * L'avis appartient à un hôtel.
     */
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    /**
     * L'avis appartient à une chambre.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * L'avis est lié à une réservation.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
