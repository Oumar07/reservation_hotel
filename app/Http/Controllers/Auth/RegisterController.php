<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Affiche la page d'inscription.
     */
    public function showRegistrationForm()
    {
        if (Auth::check()) {
            return Auth::user()->role === 'admin'
                ? redirect()->route('admin.dashboard')
                : redirect()->route('bookings.my');
        }

        return view('auth.register');
    }

    /**
     * Traite l'inscription d'un nouveau client.
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'nom'                  => 'required|string|max:100',
            'email'                => 'required|email|unique:clients,email',
            'telephone'            => 'nullable|string|max:20',
            'password'             => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ], [
            'nom.required'          => 'Le nom est requis.',
            'email.required'        => 'L\'adresse e-mail est requise.',
            'email.email'           => 'Adresse e-mail invalide.',
            'email.unique'          => 'Un compte existe déjà avec cette adresse e-mail.',
            'password.required'     => 'Le mot de passe est requis.',
            'password.min'          => 'Le mot de passe doit contenir au moins 6 caractères.',
            'password.confirmed'    => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        // Créer le client avec mot_de_passe hashé
        $client = Client::create([
            'nom'          => $data['nom'],
            'email'        => $data['email'],
            'telephone'    => $data['telephone'] ?? null,
            'mot_de_passe' => Hash::make($data['password']),
        ]);

        // Connexion automatique après inscription
        Auth::login($client);
        $request->session()->regenerate();

        return redirect()->intended(route('bookings.my'))
            ->with('success', 'Compte créé avec succès ! Bienvenue, ' . $client->nom . ' !');
    }
}
