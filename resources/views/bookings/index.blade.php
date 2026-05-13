@extends('layouts.app')

@section('content')
@php
    $statusLabels = [
        'confirme' => 'confirmée',
        'annule' => 'annulée',
        'en_attente' => 'en attente',
    ];
@endphp

<main class="mx-auto max-w-[1200px] px-6 py-12">
    <div class="mb-8 flex items-end justify-between gap-4">
        <div>
            <h1 class="text-4xl font-semibold tracking-normal">Mes réservations</h1>
            <p class="mt-2 text-slate-500">Vos réservations confirmées apparaissent ici.</p>
        </div>
        <a href="/hotels" class="rounded-xl bg-blue-600 px-5 py-3 font-medium text-white">Trouver des hôtels</a>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-2xl bg-green-50 p-4 text-green-700">{{ session('success') }}</div>
    @endif

    <div class="space-y-5">
        @forelse($bookings as $booking)
            <article class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-100">
                <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center gap-5">
                        <img src="{{ $booking->room->hotel->image ?? 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=500&q=80' }}"
                             alt="{{ $booking->room->hotel->nom ?? 'Hôtel' }}"
                             class="h-28 w-40 rounded-2xl object-cover">
                        <div>
                            <h2 class="text-2xl font-semibold">{{ $booking->room->hotel->nom ?? 'Hôtel supprimé' }}</h2>
                            <p class="mt-1 text-slate-500">Chambre {{ ['simple' => 'Simple', 'double' => 'Double', 'suite' => 'Suite'][$booking->room->type ?? ''] ?? ucfirst($booking->room->type ?? 'chambre') }}</p>
                            <p class="mt-3 text-slate-500">{{ $booking->date_arrivee }} &rarr; {{ $booking->date_depart }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="rounded-full bg-green-50 px-3 py-1 text-sm font-medium text-green-600">{{ $statusLabels[$booking->statut] ?? $booking->statut }}</span>
                        <p class="mt-4 text-2xl font-semibold">{{ number_format($booking->prix_total, 0) }} CFA</p>
                    </div>
                </div>
            </article>
        @empty
            <div class="rounded-3xl bg-white p-10 text-center text-slate-500 shadow-sm ring-1 ring-slate-100">
                Aucune réservation pour le moment.
            </div>
        @endforelse
    </div>
</main>
@endsection
