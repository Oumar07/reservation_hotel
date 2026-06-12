<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    /**
     * Affiche la liste de tous les utilisateurs.
     */
    public function index()
    {
        $users = Client::orderBy('created_at', 'desc')->get();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Affiche les détails d'un utilisateur.
     */
    public function show(Client $user)
    {
        $user->load('bookings.room.hotel', 'reviews.hotel');

        return view('admin.users.show', compact('user'));
    }

    /**
     * Modifier le rôle d'un utilisateur (client ↔ admin).
     */
    public function updateRole(Request $request, Client $user)
    {
        // Sécurité : un admin ne peut pas modifier son propre rôle
        if (Auth::id() === $user->id) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Vous ne pouvez pas modifier votre propre rôle.');
        }

        $request->validate([
            'role' => 'required|in:client,admin',
        ]);

        $user->role = $request->input('role');
        $user->save();

        $roleLabel = $user->role === 'admin' ? 'Administrateur' : 'Client';

        return redirect()->route('admin.users.index')
            ->with('success', "Le rôle de {$user->nom} a été changé en {$roleLabel}.");
    }
}
