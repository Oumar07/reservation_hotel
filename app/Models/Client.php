<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Client extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nom',
        'email',
        'mot_de_passe',
        'telephone',
        'role',
    ];

    protected $hidden = [
        'mot_de_passe',
        'remember_token',
    ];

    /**
     * Override : Laravel Auth cherche "password" mais notre colonne
     * s'appelle "mot_de_passe". Cet override corrige ça proprement.
     */
    public function getAuthPassword(): string
    {
        return $this->mot_de_passe;
    }

    /**
     * Un client peut avoir plusieurs réservations.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Un client peut laisser plusieurs avis.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Vérifie si le client a séjourné dans un hôtel donné.
     */
    public function hasBookedHotel(int $hotelId): bool
    {
        return $this->bookings()
            ->whereHas('room', fn ($q) => $q->where('hotel_id', $hotelId))
            ->where('statut', '!=', 'annule')
            ->exists();
    }

    /**
     * Vérifie si le client a déjà laissé un avis sur un hôtel donné.
     */
    public function hasReviewedHotel(int $hotelId): bool
    {
        return $this->reviews()->where('hotel_id', $hotelId)->exists();
    }

    /**
     * Vérifie si le client a déjà laissé un avis sur une chambre donnée.
     */
    public function hasReviewedRoom(int $roomId): bool
    {
        return $this->reviews()->where('room_id', $roomId)->exists();
    }

    /**
     * Vérifie si le client a une réservation confirmée pour une chambre donnée.
     */
    public function hasBookedRoom(int $roomId): bool
    {
        return $this->bookings()
            ->where('room_id', $roomId)
            ->where('statut', '!=', 'annule')
            ->exists();
    }

    /**
     * Vérifie si le client est un administrateur.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
