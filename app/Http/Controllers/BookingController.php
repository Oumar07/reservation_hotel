<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Affiche toutes les réservations (vue admin).
     * Route protégée par middleware auth + role:admin.
     */
    public function index()
    {
        $bookings = Booking::with('room.hotel', 'client')->latest()->get();

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Affiche les réservations du client connecté.
     * Route protégée par middleware auth → GET /mes-reservations
     */
    public function myBookings()
    {
        /** @var \App\Models\Client $client */
        $client = Auth::user();

        $bookings = Booking::with('room.hotel')
            ->where('client_id', $client->id)
            ->latest()
            ->get();

        return view('bookings.my', compact('bookings', 'client'));
    }

    /**
     * Formulaire de réservation pour une chambre donnée.
     * Route protégée par middleware auth → l'utilisateur doit être connecté.
     */
    public function create($id)
    {
        $room = Room::with('hotel')->findOrFail($id);

        return view('bookings.create', compact('room'));
    }

    /**
     * Récapitulatif de paiement avant confirmation.
     * Route protégée par middleware auth.
     */
    public function payment(Request $request)
    {
        $data = $request->validate([
            'room_id'      => 'required|exists:rooms,id',
            'date_arrivee' => 'required|date|after_or_equal:today',
            'date_depart'  => 'required|date|after:date_arrivee',
        ], [
            'date_arrivee.after_or_equal' => 'La date d\'arrivée ne peut pas être dans le passé.',
            'date_depart.after'           => 'La date de départ doit être après la date d\'arrivée.',
        ]);

        // Vérifier la disponibilité avant de passer au paiement
        $conflict = Booking::where('room_id', $data['room_id'])
            ->where('statut', '!=', 'annule')
            ->where('date_arrivee', '<', $data['date_depart'])
            ->where('date_depart', '>', $data['date_arrivee'])
            ->exists();

        if ($conflict) {
            return back()
                ->withErrors(['date_arrivee' => 'Cette chambre est déjà réservée pour cette période. Veuillez choisir d\'autres dates.'])
                ->withInput();
        }

        $room   = Room::with('hotel')->findOrFail($data['room_id']);
        $nights = Carbon::parse($data['date_arrivee'])->diffInDays(Carbon::parse($data['date_depart']));
        $total  = $nights * $room->prix;

        return view('bookings.payment', compact('room', 'nights', 'total', 'data'));
    }

    /**
     * Confirme et enregistre la réservation.
     * Route protégée par middleware auth.
     * Vérification anti-chevauchement + cohérence des données.
     */
    public function store(Request $request)
    {
        $request->validate([
            'room_id'      => 'required|exists:rooms,id',
            'date_arrivee' => 'required|date|after_or_equal:today',
            'date_depart'  => 'required|date|after:date_arrivee',
        ], [
            'date_arrivee.after_or_equal' => 'La date d\'arrivée ne peut pas être dans le passé.',
            'date_depart.after'           => 'La date de départ doit être après la date d\'arrivée.',
        ]);

        // ─── Vérification anti-chevauchement ─────────────────────────────────
        $conflict = Booking::where('room_id', $request->room_id)
            ->where('statut', '!=', 'annule')
            ->where('date_arrivee', '<', $request->date_depart)
            ->where('date_depart', '>', $request->date_arrivee)
            ->exists();

        if ($conflict) {
            return back()
                ->withErrors(['date_arrivee' => 'Cette chambre est déjà réservée pour cette période. Veuillez choisir d\'autres dates ou une autre chambre.'])
                ->withInput();
        }

        // ─── Calcul du montant ────────────────────────────────────────────────
        $room   = Room::findOrFail($request->room_id);
        $nights = Carbon::parse($request->date_arrivee)->diffInDays(Carbon::parse($request->date_depart));
        $total  = $nights * $room->prix;

        // ─── Vérification cohérence ───────────────────────────────────────────
        if ($total <= 0) {
            return back()
                ->withErrors(['date_arrivee' => 'Le prix total doit être supérieur à zéro. Vérifiez vos dates.'])
                ->withInput();
        }

        // ─── Création de la réservation ───────────────────────────────────────
        // L'utilisateur est forcément connecté (middleware auth)
        Booking::create([
            'client_id'    => Auth::id(),
            'room_id'      => $room->id,
            'date_arrivee' => $request->date_arrivee,
            'date_depart'  => $request->date_depart,
            'prix_total'   => $total,
            'statut'       => 'confirme',
        ]);

        return redirect()->route('sejour.index')->with('success', 'Réservation confirmée avec succès !');
    }

    /**
     * Annule une réservation existante.
     * Route protégée par middleware auth → POST /bookings/{id}/cancel
     */
    public function cancel(Request $request, int $id)
    {
        $booking = Booking::findOrFail($id);

        // Vérifier que la réservation appartient au client connecté
        if ($booking->client_id !== Auth::id()) {
            return back()->withErrors(['cancel' => 'Vous n\'êtes pas autorisé à annuler cette réservation.']);
        }

        if (in_array($booking->statut, ['confirme', 'en_attente'])) {
            $booking->update(['statut' => 'annule']);
            return back()->with('success', 'Votre réservation a été annulée avec succès.');
        }

        return back()->withErrors(['cancel' => 'Cette réservation ne peut pas être annulée.']);
    }
}
