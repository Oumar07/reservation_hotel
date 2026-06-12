@extends('layouts.app')

@section('title', 'Connexion — StayHub')

@section('content')
<main class="page-container section-padding">
    <div class="mx-auto max-w-md">

        <div class="reveal mb-8 text-center">
            <p class="text-sm font-semibold uppercase tracking-widest text-gold-600">Mon espace</p>
            <h1 class="section-title mt-2">Connexion</h1>
            <p class="section-subtitle">Accédez à vos réservations et gérez votre compte.</p>
        </div>

        {{-- Message flash --}}
        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-800">
                <svg class="h-5 w-5 shrink-0 text-emerald-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m9 11 3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <div class="card p-7 sm:p-10 reveal">
            {{-- Erreur générale --}}
            @if($errors->any())
                <div class="mb-6 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-red-700">
                    <svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                    <div class="text-sm">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('auth.login') }}" class="space-y-5" id="login-form">
                @csrf

                <label class="block">
                    <span class="form-label">Adresse e-mail <span class="text-red-500">*</span></span>
                    <input type="email"
                           name="email"
                           id="login-email"
                           value="{{ old('email') }}"
                           class="form-input-filled mt-1 @error('email') border-red-400 @enderror"
                           placeholder="vous@exemple.com"
                           required
                           autocomplete="email">
                </label>

                <label class="block">
                    <span class="form-label">Mot de passe <span class="text-red-500">*</span></span>
                    <input type="password"
                           name="password"
                           id="login-password"
                           class="form-input-filled mt-1"
                           placeholder="••••••••"
                           required
                           autocomplete="current-password">
                </label>

                <div class="flex items-center justify-between">
                    <label class="flex cursor-pointer items-center gap-2 text-sm text-muted" for="remember">
                        <input type="checkbox" name="remember" id="remember" class="rounded border-navy-900/20">
                        Se souvenir de moi
                    </label>
                </div>

                <button type="submit" class="btn-primary w-full py-3.5" id="btn-login">
                    Se connecter
                </button>
            </form>

            <div class="mt-6 text-center text-sm text-muted">
                Pas encore de compte ?
                <a href="{{ route('auth.register') }}" class="font-medium text-navy-900 underline hover:text-gold-600">
                    Créer un compte
                </a>
            </div>
        </div>

        <p class="mt-6 text-center text-xs text-muted">
            En vous connectant, vous acceptez nos conditions d'utilisation.
        </p>
    </div>
</main>
@endsection
