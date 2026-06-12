@extends('layouts.app')

@section('title', 'Créer un compte — StayHub')

@section('content')
<main class="page-container section-padding">
    <div class="mx-auto max-w-md">

        <div class="reveal mb-8 text-center">
            <p class="text-sm font-semibold uppercase tracking-widest text-gold-600">Rejoignez StayHub</p>
            <h1 class="section-title mt-2">Créer un compte</h1>
            <p class="section-subtitle">Réservez vos séjours et gérez vos réservations facilement.</p>
        </div>

        <div class="card p-7 sm:p-10 reveal">
            {{-- Erreurs --}}
            @if($errors->any())
                <div class="mb-6 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-red-700">
                    <svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                    <div class="text-sm space-y-1">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('auth.register') }}" class="space-y-5" id="register-form">
                @csrf

                <label class="block">
                    <span class="form-label">Nom complet <span class="text-red-500">*</span></span>
                    <input type="text"
                           name="nom"
                           id="register-nom"
                           value="{{ old('nom') }}"
                           class="form-input-filled mt-1 @error('nom') border-red-400 @enderror"
                           placeholder="Jean Dupont"
                           required
                           autocomplete="name">
                </label>

                <label class="block">
                    <span class="form-label">Adresse e-mail <span class="text-red-500">*</span></span>
                    <input type="email"
                           name="email"
                           id="register-email"
                           value="{{ old('email') }}"
                           class="form-input-filled mt-1 @error('email') border-red-400 @enderror"
                           placeholder="vous@exemple.com"
                           required
                           autocomplete="email">
                </label>

                <label class="block">
                    <span class="form-label">Téléphone <span class="text-muted text-xs">(optionnel)</span></span>
                    <input type="tel"
                           name="telephone"
                           id="register-telephone"
                           value="{{ old('telephone') }}"
                           class="form-input-filled mt-1"
                           placeholder="+221 77 000 00 00">
                </label>

                <label class="block">
                    <span class="form-label">Mot de passe <span class="text-red-500">*</span></span>
                    <input type="password"
                           name="password"
                           id="register-password"
                           class="form-input-filled mt-1 @error('password') border-red-400 @enderror"
                           placeholder="Minimum 6 caractères"
                           required
                           autocomplete="new-password">
                </label>

                <label class="block">
                    <span class="form-label">Confirmer le mot de passe <span class="text-red-500">*</span></span>
                    <input type="password"
                           name="password_confirmation"
                           id="register-password-confirm"
                           class="form-input-filled mt-1"
                           placeholder="Répétez votre mot de passe"
                           required
                           autocomplete="new-password">
                </label>

                <button type="submit" class="btn-primary w-full py-3.5" id="btn-register">
                    Créer mon compte
                </button>
            </form>

            <div class="mt-6 text-center text-sm text-muted">
                Déjà un compte ?
                <a href="{{ route('auth.login') }}" class="font-medium text-navy-900 underline hover:text-gold-600">
                    Se connecter
                </a>
            </div>
        </div>
    </div>
</main>
@endsection
