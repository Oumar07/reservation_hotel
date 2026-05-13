<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\Booking;

class AdminController extends Controller
{
    //
    /*public function dashboard()
    {
        $hotels = Hotel::all();
        $rooms = Room::with('hotel')->get();
        $bookings = Booking::with('room.hotel')->get();

        $revenu = Booking::sum('prix_total');

        return view('admin.dashboard', compact(
            'hotels',
            'rooms',
            'bookings',
            'revenu'
        ));
    }
    */

    

    public function dashboard()
    {
        $hotels = Hotel::with('rooms')->get();
        $rooms = Room::with('hotel')->get();
        $bookings = Booking::with('room.hotel')->get();
        $revenue = $bookings->sum('prix_total');
        $activeBookings = $bookings->where('statut', 'confirme')->count();

        return view('admin.dashboard', compact(
            'hotels',
            'rooms',
            'bookings',
            'revenue',
            'activeBookings'
        ));
    }
}
