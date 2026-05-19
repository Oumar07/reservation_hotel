@extends('layouts.app')

@section('title', 'Réserver une chambre — StayHub')

@section('content')
<main class="page-container section-padding">
    <div class="mx-auto max-w-xl reveal">
        <div class="booking-steps mb-8">
            <div class="booking-step is-active"><span class="booking-step-dot">1</span> Dates</div>
            <span class="hidden text-muted sm:inline">—</span>
            <div class="booking-step"><span class="booking-step-dot">2</span> Paiement</div>
        </div>

        <h1 class="section-title">Réserver une chambre</h1>

        <div class="card mt-6 p-6">
            <p class="text-sm text-muted">Type de chambre</p>
            <p class="mt-1 text-lg font-semibold text-navy-900">{{ ['simple' => 'Simple', 'double' => 'Double', 'suite' => 'Suite'][$room->type] ?? ucfirst($room->type) }}</p>
            <p class="mt-4 font-display text-3xl font-semibold text-gold-600">{{ number_format($room->prix, 0, ',', ' ') }} <span class="text-base font-sans font-normal text-muted">CFA / nuit</span></p>
        </div>

        <form method="POST" action="{{ route('bookings.store') }}" class="card mt-6 space-y-5 p-6">
            @csrf
            <input type="hidden" name="room_id" value="{{ $room->id }}">

            <label class="block">
                <span class="form-label">Date d'arrivée</span>
                <input type="date" name="date_arrivee" required class="form-input-filled">
            </label>

            <label class="block">
                <span class="form-label">Date de départ</span>
                <input type="date" name="date_depart" required class="form-input-filled">
            </label>

            <button type="submit" class="btn-primary w-full py-4">Réserver</button>
        </form>
    </div>
</main>
@endsection
