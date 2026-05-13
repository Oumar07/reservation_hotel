<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use Illuminate\Support\Facades\Schema;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! Schema::hasTable('hotels')) {
            $hotels = collect();
            $countries = collect();

            return view('hotels.index', compact('hotels', 'countries'));
        }

        $query = Hotel::with(['rooms', 'reviews']);

        if (request('destination')) {
            $destination = request('destination');
            $query->where(function ($builder) use ($destination) {
                $builder->where('localisation', 'like', "%{$destination}%")
                    ->orWhere('pays', 'like', "%{$destination}%")
                    ->orWhere('nom', 'like', "%{$destination}%");
            });
        }

        if (request('country')) {
            $query->where('pays', request('country'));
        }

        if (request('room_type')) {
            $query->whereHas('rooms', function ($builder) {
                $builder->where('type', request('room_type'));
            });
        }

        if (request('guests')) {
            $query->whereHas('rooms', function ($builder) {
                $builder->where('capacite', '>=', request('guests'));
            });
        }

        if (request('max_price')) {
            $query->whereHas('rooms', function ($builder) {
                $builder->where('prix', '<=', request('max_price'));
            });
        }

        $hotels = $query->get();

        if (request('rating')) {
            $hotels = $hotels->filter(function ($hotel) {
                $rating = round($hotel->reviews->avg('note') ?: (4.4 + (($hotel->id % 6) / 10)), 1);

                return $rating >= (int) request('rating');
            });
        }

        $countries = Hotel::query()->select('pays')->distinct()->orderBy('pays')->pluck('pays');

        return view('hotels.index', compact('hotels', 'countries'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('hotels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        \App\Models\Hotel::create($request->all());

        if ($request->input('redirect_to') === 'admin') {
            return redirect('/admin');
        }

        return redirect()->route('hotels.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $hotel = Hotel::with(['rooms', 'reviews'])->findOrFail($id);

        return view('hotels.show', compact('hotel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $hotel = \App\Models\Hotel::findOrFail($id);
        return view('hotels.edit', compact('hotel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $hotel = \App\Models\Hotel::findOrFail($id);
        $hotel->update($request->all());

        return redirect()->route('hotels.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        \App\Models\Hotel::destroy($id);

        return redirect()->route('hotels.index');
    }
}
