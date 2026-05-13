<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Client;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('room.hotel')->latest()->get();

        return view('bookings.index', compact('bookings'));
    }

    public function create($id)
    {
        $room = Room::findOrFail($id);

        return view('bookings.create', compact('room'));
    }

    public function payment(Request $request)
    {
        $data = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'date_arrivee' => 'required|date',
            'date_depart' => 'required|date|after:date_arrivee',
            'email' => 'required|email',
            'password' => 'required|string|min:4',
        ]);

        $room = Room::with('hotel')->findOrFail($data['room_id']);
        $nights = Carbon::parse($data['date_arrivee'])->diffInDays(Carbon::parse($data['date_depart']));
        $total = $nights * $room->prix;

        return view('bookings.payment', compact('room', 'nights', 'total', 'data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'date_arrivee' => 'required|date',
            'date_depart' => 'required|date|after:date_arrivee',
            'email' => 'nullable|email',
            'password' => 'nullable|string|min:4',
        ]);

        $room = Room::findOrFail($request->room_id);
        $nights = Carbon::parse($request->date_arrivee)->diffInDays(Carbon::parse($request->date_depart));
        $total = $nights * $room->prix;
        $clientId = null;

        if ($request->filled('email')) {
            $client = Client::firstOrCreate(
                ['email' => $request->email],
                [
                    'nom' => str($request->email)->before('@')->replace('.', ' ')->title(),
                    'mot_de_passe' => Hash::make($request->password ?? 'password'),
                ]
            );

            $clientId = $client->id;
        }

        Booking::create([
            'client_id' => $clientId,
            'room_id' => $room->id,
            'date_arrivee' => $request->date_arrivee,
            'date_depart' => $request->date_depart,
            'prix_total' => $total,
            'statut' => 'confirme',
        ]);

        return redirect('/bookings')->with('success', 'Réservation confirmée');
    }
}
