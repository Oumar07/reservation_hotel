@extends('layouts.app')

@section('title', 'Créer un hôtel — StayHub')

@section('content')
<main class="page-container section-padding">
    <div class="mx-auto max-w-xl reveal">
        <h1 class="section-title">Créer un hôtel</h1>
        <p class="section-subtitle">Ajoutez un nouvel établissement à la plateforme.</p>

        <form method="POST" action="{{ route('hotels.store') }}" class="card mt-8 space-y-5 p-6 sm:p-8">
            @csrf
            <label class="block">
                <span class="form-label">Nom</span>
                <input type="text" name="nom" placeholder="Nom de l'hôtel" required class="form-input">
            </label>
            <label class="block">
                <span class="form-label">Ville</span>
                <input type="text" name="localisation" placeholder="Ville" required class="form-input">
            </label>
            <label class="block">
                <span class="form-label">Pays</span>
                <input type="text" name="pays" placeholder="Pays" required class="form-input">
            </label>
            <button type="submit" class="btn-primary w-full">Créer</button>
        </form>
    </div>
</main>
@endsection
