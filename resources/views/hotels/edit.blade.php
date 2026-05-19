@extends('layouts.app')

@section('title', 'Modifier l\'hôtel — StayHub')

@section('content')
<main class="page-container section-padding">
    <div class="mx-auto max-w-xl reveal">
        <h1 class="section-title">Modifier l'hôtel</h1>
        <p class="section-subtitle">{{ $hotel->nom }}</p>

        <form method="POST" action="{{ route('hotels.update', $hotel->id) }}" class="card mt-8 space-y-5 p-6 sm:p-8">
            @csrf
            @method('PUT')

            <label class="block">
                <span class="form-label">Nom</span>
                <input type="text" name="nom" value="{{ $hotel->nom }}" required class="form-input">
            </label>
            <label class="block">
                <span class="form-label">Ville</span>
                <input type="text" name="localisation" value="{{ $hotel->localisation }}" required class="form-input">
            </label>
            <label class="block">
                <span class="form-label">Pays</span>
                <input type="text" name="pays" value="{{ $hotel->pays }}" required class="form-input">
            </label>

            <button type="submit" class="btn-primary w-full">Enregistrer les modifications</button>
        </form>
    </div>
</main>
@endsection
