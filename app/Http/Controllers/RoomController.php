<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $rooms = \App\Models\Room::with('hotel')->get();
        return view('rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $hotels = \App\Models\Hotel::all();
        return view('rooms.create', compact('hotels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'type' => 'required|in:simple,double,suite',
            'prix' => 'required|numeric|min:0',
            'capacite' => 'required|integer|min:1',
            'image' => 'nullable|url',
        ]);

        \App\Models\Room::create($request->only([
            'hotel_id',
            'type',
            'prix',
            'capacite',
            'image',
        ]));

        if ($request->input('redirect_to') === 'admin') {
            return redirect('/admin?tab=rooms')->with('success', 'Chambre ajoutée avec succès');
        }

        return redirect()->route('rooms.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $room = \App\Models\Room::findOrFail($id);
        $hotels = \App\Models\Hotel::all();

        return view('rooms.edit', compact('room','hotels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $room = \App\Models\Room::findOrFail($id);
        $room->update($request->all());

        return redirect()->route('rooms.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        \App\Models\Room::destroy($id);

        return redirect()->route('rooms.index');
    }
}
