<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Affiche la page de connexion.
     */
    public function showLoginForm()
    {
        // Si déjà connecté, rediriger selon le rôle
        if (Auth::check()) {
            return Auth::user()->role === 'admin'
                ? redirect()->route('admin.dashboard')
                : redirect()->route('bookings.my');
        }

        return view('auth.login');
    }

    /**
     * Traite la tentative de connexion.
     * Laravel Auth tente de comparer request('password') avec getAuthPassword()
     * qui retourne $this->mot_de_passe — ça fonctionne via attempt().
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required'    => 'L\'adresse e-mail est requise.',
            'email.email'       => 'Adresse e-mail invalide.',
            'password.required' => 'Le mot de passe est requis.',
        ]);

        // attempt() cherche par email et compare password avec getAuthPassword()
        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            $request->session()->regenerate();

            $defaultRedirect = Auth::user()->role === 'admin'
                ? route('admin.dashboard')
                : route('bookings.my');

            return redirect()->intended($defaultRedirect)
                ->with('success', 'Bienvenue, ' . Auth::user()->nom . ' !');
        }

        return back()
            ->withErrors(['email' => 'Ces informations d\'identification ne correspondent pas à nos enregistrements.'])
            ->withInput($request->only('email'));
    }

    /**
     * Déconnecte l'utilisateur.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Vous avez été déconnecté avec succès.');
    }
}
