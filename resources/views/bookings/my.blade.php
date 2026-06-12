@extends('layouts.app')

@section('title', 'Mes Réservations — StayHub')

@section('content')
@php
    $statusLabels = [
        'confirme'   => 'Confirmée',
        'annule'     => 'Annulée',
        'en_attente' => 'En attente',
    ];
    $statusChips = [
        'confirme'   => 'chip-success',
        'annule'     => 'chip-danger',
        'en_attente' => 'chip-warning',
    ];
    $roomTypeLabels = ['simple' => 'Simple', 'double' => 'Double', 'suite' => 'Suite'];
@endphp

<main class="page-container section-padding">
    {{-- En-tête --}}
    <div class="reveal mb-10">
        <p class="text-sm font-semibold uppercase tracking-widest text-gold-600">Mon espace</p>
        <h1 class="section-title mt-2">Mes réservations</h1>
        <p class="section-subtitle">
            Bonjour, <strong>{{ $client->nom }}</strong>. Retrouvez l'historique de tous vos séjours StayHub.
        </p>
    </div>

    {{-- Messages flash --}}
    @if(session('success'))
        <div class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-800">
            <svg class="h-5 w-5 shrink-0 text-emerald-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m9 11 3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            <p class="text-sm font-medium">{{ session('success') }}</p>
        </div>
    @endif

    @if($errors->has('cancel'))
        <div class="mb-6 flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-red-700">
            <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
            <p class="text-sm font-medium">{{ $errors->first('cancel') }}</p>
        </div>
    @endif

    @if($bookings->isEmpty())
        <div class="empty-state reveal">
            <div class="empty-state-icon">
                <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M8 2v4M16 2v4M3 10h18"/><rect x="3" y="4" width="18" height="18" rx="2"/></svg>
            </div>
            <h3 class="text-xl font-semibold text-navy-900">Aucune réservation pour le moment</h3>
            <p class="mt-2 max-w-md text-muted">Explorez nos hôtels d'exception et réservez votre prochain séjour inoubliable.</p>
            <a href="/hotels" class="btn-primary mt-6">Découvrir les hôtels</a>
        </div>
    @else
        <div class="mb-4 flex items-center justify-between">
            <p class="text-sm text-muted">
                {{ $bookings->count() }} réservation{{ $bookings->count() > 1 ? 's' : '' }}
            </p>
        </div>

        <div class="space-y-5">
            @foreach($bookings as $booking)
                @php
                    $hotel = $booking->room->hotel ?? null;
                    $room  = $booking->room ?? null;
                    $nights = \Carbon\Carbon::parse($booking->date_arrivee)->diffInDays(\Carbon\Carbon::parse($booking->date_depart));
                    $canCancel = in_array($booking->statut, ['confirme', 'en_attente']);
                    $isPast = \Carbon\Carbon::parse($booking->date_depart)->isPast();
                    $canReview = $isPast
                        && $booking->statut !== 'annule'
                        && $room
                        && !$client->hasReviewedRoom($room->id);
                @endphp
                <article class="card reveal overflow-hidden transition hover:shadow-lift" id="booking-{{ $booking->id }}">
                    <div class="flex flex-col gap-6 p-5 sm:flex-row sm:p-6">

                        {{-- Image de l'hôtel --}}
                        <div class="shrink-0">
                            <img src="{{ $hotel?->image ?? 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=500&q=80' }}"
                                 alt="{{ $hotel?->nom ?? 'Hôtel' }}"
                                 class="h-44 w-full rounded-2xl object-cover sm:h-36 sm:w-52"
                                 loading="lazy">
                        </div>

                        {{-- Informations --}}
                        <div class="flex flex-1 flex-col justify-between gap-4">
                            <div>
                                <div class="flex flex-wrap items-start justify-between gap-3">
                                    <div>
                                        <h2 class="font-display text-2xl font-semibold text-navy-900">
                                            {{ $hotel?->nom ?? 'Hôtel supprimé' }}
                                        </h2>
                                        @if($hotel)
                                            <p class="mt-0.5 flex items-center gap-1.5 text-sm text-muted">
                                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                                {{ $hotel->localisation }}{{ isset($hotel->pays) ? ', ' . $hotel->pays : '' }}
                                            </p>
                                        @endif
                                    </div>
                                    <span class="{{ $statusChips[$booking->statut] ?? 'chip-info' }}">
                                        {{ $statusLabels[$booking->statut] ?? $booking->statut }}
                                    </span>
                                </div>

                                <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-3">
                                    <div class="rounded-xl bg-surface px-3 py-2.5">
                                        <p class="text-xs text-muted">Chambre</p>
                                        <p class="mt-0.5 font-medium text-navy-900">
                                            {{ $roomTypeLabels[$room?->type ?? ''] ?? ucfirst($room?->type ?? 'N/A') }}
                                        </p>
                                    </div>
                                    <div class="rounded-xl bg-surface px-3 py-2.5">
                                        <p class="text-xs text-muted">Arrivée</p>
                                        <p class="mt-0.5 font-medium text-navy-900">
                                            {{ \Carbon\Carbon::parse($booking->date_arrivee)->format('d M Y') }}
                                        </p>
                                    </div>
                                    <div class="rounded-xl bg-surface px-3 py-2.5">
                                        <p class="text-xs text-muted">Départ</p>
                                        <p class="mt-0.5 font-medium text-navy-900">
                                            {{ \Carbon\Carbon::parse($booking->date_depart)->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-wrap items-center justify-between gap-4 border-t border-navy-900/5 pt-4">
                                <div>
                                    <p class="text-sm text-muted">{{ $nights }} nuit{{ $nights > 1 ? 's' : '' }} · Prix total</p>
                                    <p class="text-2xl font-bold text-navy-900">
                                        {{ number_format($booking->prix_total, 0, ',', ' ') }}
                                        <span class="text-base font-normal text-muted">CFA</span>
                                    </p>
                                </div>

                                <div class="flex flex-wrap items-center gap-3">
                                    @if($hotel)
                                        <a href="{{ route('hotels.show', $hotel->id) }}"
                                           class="btn-outline text-sm"
                                           id="view-hotel-{{ $booking->id }}">
                                            Voir l'hôtel
                                        </a>
                                    @endif

                                    @if($canCancel)
                                        <button type="button"
                                                class="rounded-xl border border-red-200 bg-red-50 px-4 py-2 text-sm font-medium text-red-600 transition hover:bg-red-100 hover:border-red-300"
                                                id="cancel-btn-{{ $booking->id }}"
                                                data-cancel-booking
                                                data-cancel-action="{{ route('bookings.cancel', $booking->id) }}">
                                            Annuler
                                        </button>
                                    @endif
                                </div>
                            </div>

                            {{-- Formulaire d'avis sur la chambre (séjour terminé) --}}
                            @if($canReview)
                                <div class="mt-2 border-t border-navy-900/5 pt-4">
                                    <p class="mb-3 text-sm font-semibold text-navy-900">⭐ Donnez votre avis sur cette chambre</p>
                                    @if(session('room_review_success'))
                                        <p class="text-sm text-emerald-600">{{ session('room_review_success') }}</p>
                                    @else
                                        <form action="{{ route('reviews.room') }}" method="POST" class="space-y-3" id="room-review-form-{{ $booking->id }}">
                                            @csrf
                                            <input type="hidden" name="room_id" value="{{ $room->id }}">
                                            <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                                            {{-- Sélecteur étoiles --}}
                                            <div class="flex items-center gap-1">
                                                @for($s = 1; $s <= 5; $s++)
                                                    <button type="button"
                                                            class="star-btn-room text-2xl text-gray-300 transition hover:scale-110"
                                                            data-value="{{ $s }}"
                                                            data-booking="{{ $booking->id }}"
                                                            aria-label="{{ $s }} étoile{{ $s > 1 ? 's' : '' }}">★</button>
                                                @endfor
                                                <input type="hidden" name="note" class="room-note-input" value="{{ old('note') }}">
                                            </div>

                                            <textarea name="commentaire"
                                                      rows="2"
                                                      class="form-input-filled resize-none text-sm"
                                                      placeholder="Partagez votre expérience dans cette chambre...">{{ old('commentaire') }}</textarea>

                                            <button type="submit" class="btn-outline text-sm" id="submit-room-review-{{ $booking->id }}">
                                                Publier mon avis
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @elseif($isPast && $booking->statut !== 'annule' && $room && $client->hasReviewedRoom($room->id))
                                <p class="mt-2 pt-3 border-t border-navy-900/5 text-xs text-muted">✓ Vous avez déjà laissé un avis pour cette chambre.</p>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</main>

@push('scripts')
<script>
    // Sélecteurs d'étoiles pour les avis par chambre (page mes-reservations)
    (function () {
        document.querySelectorAll('[data-booking]').forEach(function (btn) {
            const bookingId = btn.dataset.booking;
            const form = document.getElementById('room-review-form-' + bookingId);
            if (!form) return;

            const stars = form.querySelectorAll('.star-btn-room');
            const noteInput = form.querySelector('.room-note-input');

            const setStars = (value) => {
                stars.forEach(b => {
                    b.style.color = parseInt(b.dataset.value) <= value ? '#c9a84c' : '#d1d5db';
                });
                noteInput.value = value;
            };

            // Restaurer si old()
            if (noteInput.value) setStars(parseInt(noteInput.value));

            stars.forEach(b => {
                b.addEventListener('click', () => setStars(parseInt(b.dataset.value)));
                b.addEventListener('mouseenter', () => {
                    stars.forEach(s => {
                        s.style.color = parseInt(s.dataset.value) <= parseInt(b.dataset.value) ? '#c9a84c' : '#d1d5db';
                    });
                });
                b.addEventListener('mouseleave', () => setStars(parseInt(noteInput.value) || 0));
            });
        });
    })();
</script>
@endpush
@endsection
