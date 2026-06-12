<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Client;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Enregistre un avis sur un HÔTEL.
     *
     * Règles métier :
     * 1. Le client doit avoir effectué une réservation dans cet hôtel (non annulée).
     * 2. Un seul avis par hôtel par client.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'hotel_id'    => 'required|exists:hotels,id',
            'email'       => 'required_without:_auth|email|nullable',
            'note'        => 'required|integer|min:1|max:5',
            'commentaire' => 'required|string|min:10|max:1000',
        ], [
            'note.required'        => 'Veuillez attribuer une note.',
            'commentaire.required' => 'Le commentaire est requis.',
            'commentaire.min'      => 'Le commentaire doit contenir au moins 10 caractères.',
        ]);

        // Résoudre le client : connecté ou par email
        if (Auth::check()) {
            $client = Auth::user();
        } else {
            $request->validate(['email' => 'required|email'], [
                'email.required' => 'Votre adresse e-mail est requise.',
            ]);
            $client = Client::where('email', $request->email)->first();

            if (! $client) {
                return back()
                    ->withErrors(['email' => 'Aucun compte trouvé avec cette adresse e-mail.'])
                    ->withInput();
            }
        }

        // Règle 1 : Le client doit avoir séjourné dans cet hôtel
        if (! $client->hasBookedHotel((int) $data['hotel_id'])) {
            return back()
                ->withErrors(['email' => 'Vous devez avoir effectué une réservation dans cet hôtel pour laisser un avis.'])
                ->withInput();
        }

        // Règle 2 : Un seul avis par hôtel
        if ($client->hasReviewedHotel((int) $data['hotel_id'])) {
            return back()
                ->withErrors(['email' => 'Vous avez déjà laissé un avis pour cet hôtel.'])
                ->withInput();
        }

        Review::create([
            'client_id'   => $client->id,
            'hotel_id'    => $data['hotel_id'],
            'note'        => $data['note'],
            'commentaire' => $data['commentaire'],
        ]);

        return back()->with('review_success', 'Votre avis a été publié avec succès. Merci !');
    }

    /**
     * Enregistre un avis sur une CHAMBRE (nécessite d'être connecté).
     * Route protégée par middleware auth.
     *
     * Règles métier :
     * 1. Le client doit avoir une réservation confirmée pour cette chambre.
     * 2. Un seul avis par chambre par client.
     */
    public function storeRoomReview(Request $request)
    {
        $data = $request->validate([
            'room_id'     => 'required|exists:rooms,id',
            'booking_id'  => 'nullable|exists:bookings,id',
            'note'        => 'required|integer|min:1|max:5',
            'commentaire' => 'required|string|min:10|max:1000',
        ], [
            'note.required'        => 'Veuillez attribuer une note.',
            'commentaire.required' => 'Le commentaire est requis.',
            'commentaire.min'      => 'Le commentaire doit contenir au moins 10 caractères.',
        ]);

        /** @var \App\Models\Client $client */
        $client = Auth::user();

        // Règle 1 : Le client doit avoir réservé cette chambre
        if (! $client->hasBookedRoom((int) $data['room_id'])) {
            return back()
                ->withErrors(['room_review' => 'Vous devez avoir effectué une réservation pour cette chambre pour laisser un avis.'])
                ->withInput();
        }

        // Règle 2 : Un seul avis par chambre
        if ($client->hasReviewedRoom((int) $data['room_id'])) {
            return back()
                ->withErrors(['room_review' => 'Vous avez déjà laissé un avis pour cette chambre.'])
                ->withInput();
        }

        // Récupérer le booking_id si non fourni (chercher la réservation la plus récente)
        $bookingId = $data['booking_id'] ?? Booking::where('client_id', $client->id)
            ->where('room_id', $data['room_id'])
            ->where('statut', '!=', 'annule')
            ->latest()
            ->value('id');

        // Récupérer l'hotel_id depuis la chambre
        $room = \App\Models\Room::findOrFail($data['room_id']);

        Review::create([
            'client_id'   => $client->id,
            'hotel_id'    => $room->hotel_id,
            'room_id'     => $data['room_id'],
            'booking_id'  => $bookingId,
            'note'        => $data['note'],
            'commentaire' => $data['commentaire'],
        ]);

        return back()->with('room_review_success', 'Votre avis sur la chambre a été publié. Merci !');
    }
}
