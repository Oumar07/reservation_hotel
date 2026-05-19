@extends('layouts.app')

@section('title', 'Mes réservations — StayHub')

@section('content')
@php
    $statusLabels = [
        'confirme' => 'confirmée',
        'annule' => 'annulée',
        'en_attente' => 'en attente',
    ];
    $statusChips = [
        'confirme' => 'chip-success',
        'annule' => 'chip-danger',
        'en_attente' => 'chip-warning',
    ];
@endphp

<main class="page-container section-padding">
    <div class="reveal mb-10 flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-widest text-gold-600">Mon espace</p>
            <h1 class="section-title mt-2">Mes réservations</h1>
            <p class="section-subtitle">Vos séjours confirmés et en cours apparaissent ici.</p>
        </div>
        <a href="/hotels" class="btn-gold shrink-0">Trouver des hôtels</a>
    </div>

    @include('partials.flash')

    <div class="space-y-5">
        @forelse($bookings as $booking)
            <article class="card reveal overflow-hidden transition hover:shadow-lift">
                <div class="flex flex-col gap-6 p-5 sm:flex-row sm:items-center sm:justify-between sm:p-6">
                    <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
                        <img src="{{ $booking->room->hotel->image ?? 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=500&q=80' }}"
                             alt="{{ $booking->room->hotel->nom ?? 'Hôtel' }}"
                             class="h-36 w-full rounded-2xl object-cover sm:h-28 sm:w-44"
                             loading="lazy">
                        <div>
                            <h2 class="font-display text-2xl font-semibold text-navy-900">{{ $booking->room->hotel->nom ?? 'Hôtel supprimé' }}</h2>
                            <p class="mt-1 text-muted">Chambre {{ ['simple' => 'Simple', 'double' => 'Double', 'suite' => 'Suite'][$booking->room->type ?? ''] ?? ucfirst($booking->room->type ?? 'chambre') }}</p>
                            <p class="mt-3 flex items-center gap-2 text-sm text-navy-800">
                                <svg class="h-4 w-4 text-gold-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M8 2v4M16 2v4M3 10h18" /><rect x="3" y="4" width="18" height="18" rx="2" /></svg>
                                {{ $booking->date_arrivee }} → {{ $booking->date_depart }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between gap-6 border-t border-navy-900/5 pt-5 sm:flex-col sm:items-end sm:border-0 sm:pt-0">
                        <span class="{{ $statusChips[$booking->statut] ?? 'chip-info' }}">{{ $statusLabels[$booking->statut] ?? $booking->statut }}</span>
                        <p class="text-2xl font-bold text-navy-900">{{ number_format($booking->prix_total, 0, ',', ' ') }} <span class="text-base font-normal text-muted">CFA</span></p>
                    </div>
                </div>
            </article>
        @empty
            <div class="empty-state reveal">
                <div class="empty-state-icon">
                    <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M8 2v4M16 2v4M3 10h18" /><rect x="3" y="4" width="18" height="18" rx="2" /></svg>
                </div>
                <h3 class="text-xl font-semibold text-navy-900">Aucune réservation</h3>
                <p class="mt-2 max-w-md text-muted">Explorez nos hôtels d'exception et réservez votre prochain séjour inoubliable.</p>
                <a href="/hotels" class="btn-primary mt-6">Découvrir les hôtels</a>
            </div>
        @endforelse
    </div>
</main>
@endsection
