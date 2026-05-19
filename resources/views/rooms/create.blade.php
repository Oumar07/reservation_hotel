@extends('layouts.app')

@section('title', 'Créer une chambre — StayHub')

@section('content')
<main class="page-container section-padding">
    <div class="mx-auto max-w-xl reveal">
        <h1 class="section-title">Créer une chambre</h1>

        <form method="POST" action="{{ route('rooms.store') }}" class="card mt-8 space-y-5 p-6 sm:p-8">
            @csrf

            <label class="block">
                <span class="form-label">Hôtel</span>
                <select name="hotel_id" required class="form-input">
                    @foreach($hotels as $hotel)
                        <option value="{{ $hotel->id }}">{{ $hotel->nom }}</option>
                    @endforeach
                </select>
            </label>

            <label class="block">
                <span class="form-label">Type de chambre</span>
                <input type="text" name="type" placeholder="simple, double, suite" required class="form-input">
            </label>
            <label class="block">
                <span class="form-label">Prix (CFA)</span>
                <input type="number" name="prix" placeholder="35000" required class="form-input">
            </label>
            <label class="block">
                <span class="form-label">Capacité</span>
                <input type="number" name="capacite" placeholder="2" required class="form-input">
            </label>

            <button type="submit" class="btn-primary w-full">Créer</button>
        </form>
    </div>
</main>
@endsection
