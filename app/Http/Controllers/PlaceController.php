<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PlaceController extends Controller
{
    /**
     * Vérifie que la table places existe, sinon redirige avec erreur.
     */
    private function ensureTableExists()
    {
        if (!Schema::hasTable('places')) {
            return redirect()->route('places.index')
                ->withErrors(['migration' => 'La table "places" n\'existe pas encore. Lancez : php artisan migrate']);
        }

        return null;
    }

    /**
     * Affiche la liste des lieux (admin).
     */
    public function index()
    {
        $hotels = Hotel::orderBy('nom')->get();

        if (!Schema::hasTable('places')) {
            $places = collect();
        } else {
            $places = Place::with('hotel')->latest()->get();
        }

        return view('admin.places.index', compact('places', 'hotels'));
    }

    /**
     * Enregistre un nouveau lieu.
     */
    public function store(Request $request)
    {
        if ($redirect = $this->ensureTableExists()) {
            return $redirect;
        }

        $request->validate([
            'hotel_id'    => 'required|exists:hotels,id',
            'nom'         => 'required|string|max:255',
            'type'        => 'required|in:restaurant,cinema,supermarche',
            'description' => 'nullable|string',
            'adresse'     => 'required|string|max:255',
            'image'       => 'nullable|string|max:500',
        ]);

        Place::create($request->only([
            'hotel_id', 'nom', 'type', 'description', 'adresse', 'image',
        ]));

        return redirect()->route('places.index')->with('success', 'Lieu ajouté avec succès !');
    }

    /**
     * Affiche le formulaire d'édition d'un lieu.
     */
    public function edit(string $id)
    {
        if ($redirect = $this->ensureTableExists()) {
            return $redirect;
        }

        $place  = Place::findOrFail($id);
        $hotels = Hotel::orderBy('nom')->get();

        return view('admin.places.edit', compact('place', 'hotels'));
    }

    /**
     * Met à jour un lieu.
     */
    public function update(Request $request, string $id)
    {
        if ($redirect = $this->ensureTableExists()) {
            return $redirect;
        }

        $request->validate([
            'hotel_id'    => 'required|exists:hotels,id',
            'nom'         => 'required|string|max:255',
            'type'        => 'required|in:restaurant,cinema,supermarche',
            'description' => 'nullable|string',
            'adresse'     => 'required|string|max:255',
            'image'       => 'nullable|string|max:500',
        ]);

        $place = Place::findOrFail($id);
        $place->update($request->only([
            'hotel_id', 'nom', 'type', 'description', 'adresse', 'image',
        ]));

        return redirect()->route('places.index')->with('success', 'Lieu modifié avec succès !');
    }

    /**
     * Supprime un lieu.
     */
    public function destroy(string $id)
    {
        if ($redirect = $this->ensureTableExists()) {
            return $redirect;
        }

        Place::destroy($id);

        return redirect()->route('places.index')->with('success', 'Lieu supprimé avec succès !');
    }
}
