<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class SejourController extends Controller
{
    /**
     * Affiche la page « Mon séjour » avec les recommandations
     * liées à l'hôtel de la dernière réservation confirmée du client.
     */
    public function index()
    {
        $client = Auth::user();

        // Récupérer la dernière réservation confirmée (non annulée) du client
        $booking = Booking::with('room.hotel')
            ->where('client_id', $client->id)
            ->where('statut', '!=', 'annule')
            ->latest()
            ->first();

        if (!$booking || !$booking->room || !$booking->room->hotel) {
            return view('sejour.index', [
                'booking' => null,
                'hotel'   => null,
                'room'    => null,
                'places'  => collect(),
            ]);
        }

        $hotel = $booking->room->hotel;
        $room  = $booking->room;

        // Récupérer les lieux uniquement si la table existe
        $places = collect();
        if (Schema::hasTable('places')) {
            $places = $hotel->places()->get()->groupBy('type');
        }

        return view('sejour.index', compact('booking', 'hotel', 'room', 'places'));
    }
}

