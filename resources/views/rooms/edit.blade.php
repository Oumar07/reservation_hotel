@extends('layouts.app')

@section('title', 'Modifier la chambre — StayHub')

@section('content')
<main class="page-container section-padding">
    <div class="mx-auto max-w-xl reveal">
        <h1 class="section-title">Modifier la chambre</h1>

        <form method="POST" action="{{ route('rooms.update', $room->id) }}" class="card mt-8 space-y-5 p-6 sm:p-8">
            @csrf
            @method('PUT')

            <label class="block">
                <span class="form-label">Hôtel</span>
                <select name="hotel_id" required class="form-input">
                    @foreach($hotels as $hotel)
                        <option value="{{ $hotel->id }}" {{ $room->hotel_id == $hotel->id ? 'selected' : '' }}>
                            {{ $hotel->nom }}
                        </option>
                    @endforeach
                </select>
            </label>

            <label class="block">
                <span class="form-label">Type</span>
                <input type="text" name="type" value="{{ $room->type }}" required class="form-input">
            </label>
            <label class="block">
                <span class="form-label">Prix (CFA)</span>
                <input type="number" name="prix" value="{{ $room->prix }}" required class="form-input">
            </label>
            <label class="block">
                <span class="form-label">Capacité</span>
                <input type="number" name="capacite" value="{{ $room->capacite }}" required class="form-input">
            </label>

            <button type="submit" class="btn-primary w-full">Enregistrer les modifications</button>
        </form>
    </div>
</main>
@endsection
