<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Review;
use App\Models\Client;

class AdminController extends Controller
{
    public function dashboard()
    {
        $hotels   = Hotel::with('rooms')->get();
        $rooms    = Room::with('hotel')->get();
        $bookings = Booking::with('room.hotel', 'client')->latest()->get();

        $revenue        = $bookings->sum('prix_total');
        $activeBookings = $bookings->where('statut', 'confirme')->count();

        // Statistiques des avis
        $totalReviews  = Review::count();
        $latestReviews = Review::with('client', 'hotel')
            ->latest()
            ->take(8)
            ->get();

        // Statistiques des utilisateurs
        $totalUsers = Client::count();

        return view('admin.dashboard', compact(
            'hotels',
            'rooms',
            'bookings',
            'revenue',
            'activeBookings',
            'totalReviews',
            'latestReviews',
            'totalUsers'
        ));
    }
}
