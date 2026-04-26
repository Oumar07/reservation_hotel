<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hotels = \App\Models\Hotel::all();
        return view('hotels.index', compact('hotels'));
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

        return redirect()->route('hotels.index');
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
