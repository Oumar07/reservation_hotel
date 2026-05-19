@extends('layouts.app')

@section('title', $hotel->nom . ' — StayHub')

@section('content')
@php
    $fallbackImage = 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1800&q=85';
    $roomFallback = 'https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=700&q=80';
    $heroImage = $hotel->image ?: $fallbackImage;
    $rating = round($hotel->reviews->avg('note') ?: (4.4 + (($hotel->id % 6) / 10)), 1);
    $reviewCount = $hotel->reviews->count() ?: (160 + ($hotel->id * 37));
    $roomTypeLabels = ['simple' => 'Simple', 'double' => 'Double', 'suite' => 'Suite'];
@endphp

<main class="page-container py-8 sm:py-12 lg:py-14" data-booking-page>
    {{-- Gallery --}}
    <section class="reveal">
        <div class="grid gap-3 lg:grid-cols-[1.5fr_1fr] lg:grid-rows-2 lg:h-[520px]">
            <div class="relative overflow-hidden rounded-2xl bg-navy-900/10 lg:row-span-2">
                <img src="{{ $heroImage }}" alt="{{ $hotel->nom }}" class="h-full min-h-[280px] w-full object-cover lg:min-h-full" loading="eager">
            </div>
            @foreach([$heroImage, $roomFallback, $roomFallback] as $i => $thumb)
                <div class="relative hidden overflow-hidden rounded-2xl bg-navy-900/10 lg:block {{ $i === 0 ? 'lg:hidden' : '' }}">
                    <img src="{{ $thumb }}" alt="Aperçu {{ $hotel->nom }}" class="h-full w-full object-cover" loading="lazy">
                </div>
            @endforeach
        </div>
        <div class="mt-3 flex gap-3 overflow-x-auto lg:hidden">
            @foreach([$heroImage, $roomFallback, $roomFallback] as $i => $thumb)
                <img src="{{ $thumb }}" alt="Miniature" class="h-20 w-28 shrink-0 rounded-xl object-cover ring-2 {{ $loop->first ? 'ring-gold-400' : 'ring-transparent' }}">
            @endforeach
        </div>
    </section>

    <section class="mt-10 grid gap-10 lg:grid-cols-[1fr_420px] xl:grid-cols-[1fr_460px]">
        <div class="reveal">
            <h1 class="font-display text-4xl font-semibold text-navy-900 sm:text-5xl">{{ $hotel->nom }}</h1>
            <div class="mt-4 flex flex-wrap items-center gap-3 text-muted">
                <span class="flex items-center gap-2">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z" /><circle cx="12" cy="10" r="3" /></svg>
                    {{ $hotel->localisation }}, {{ $hotel->pays }}
                </span>
                <span aria-hidden="true">&middot;</span>
                <span class="rating-stars">★★★★★</span>
                <span class="font-semibold text-navy-900">{{ $rating }}</span>
                <span>({{ $reviewCount }} avis)</span>
            </div>

            <p class="mt-8 max-w-3xl text-lg leading-relaxed text-navy-800/80">
                {{ $hotel->description ?: 'Situé dans une destination agréable, cet hôtel StayHub propose des chambres confortables, un service attentif, des espaces de détente et tout le nécessaire pour un séjour mémorable.' }}
            </p>

            <div class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                @foreach(['Piscine', 'Spa', 'Restaurant', 'Bar', 'Salle de sport', 'WiFi', 'Parking'] as $amenity)
                    <div class="flex items-center gap-2.5 rounded-xl bg-white px-4 py-3 text-sm font-medium text-navy-800 shadow-soft ring-1 ring-navy-900/5">
                        <svg class="h-4 w-4 text-gold-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M5 12.55a11 11 0 0 1 14.08 0" /><path d="M12 20h.01" /></svg>
                        {{ $amenity }}
                    </div>
                @endforeach
            </div>

            <div class="mt-10 flex flex-wrap gap-4 rounded-2xl border border-emerald-200 bg-emerald-50/80 px-5 py-4 text-sm text-emerald-800">
                <span class="flex items-center gap-2 font-medium">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z" /></svg>
                    Annulation flexible
                </span>
                <span class="flex items-center gap-2 font-medium">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" /><path d="m9 11 3 3L22 4" /></svg>
                    Confirmation immédiate
                </span>
            </div>

            <h2 class="mt-14 text-2xl font-semibold text-navy-900">Chambres disponibles</h2>
            <div class="mt-6 space-y-4">
                @forelse($hotel->rooms as $room)
                    <button type="button"
                            class="room-option"
                            data-room-id="{{ $room->id }}"
                            data-room-name="Chambre {{ $roomTypeLabels[$room->type] ?? ucfirst($room->type) }}"
                            data-room-price="{{ (float) $room->prix }}">
                        <div class="flex flex-col gap-5 p-5 sm:flex-row sm:items-center sm:justify-between">
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                                <img src="{{ $room->image ?: $roomFallback }}" alt="{{ $room->type }}" class="h-36 w-full rounded-xl object-cover sm:h-32 sm:w-44" loading="lazy">
                                <div class="text-left">
                                    <h3 class="text-xl font-semibold text-navy-900">Chambre {{ $roomTypeLabels[$room->type] ?? ucfirst($room->type) }}</h3>
                                    <p class="mt-1 text-sm text-muted">{{ $room->capacite }} personne{{ $room->capacite > 1 ? 's' : '' }}</p>
                                    <div class="mt-3 flex flex-wrap gap-3 text-xs text-muted">
                                        <span class="rounded-full bg-surface px-2.5 py-1">WiFi</span>
                                        <span class="rounded-full bg-surface px-2.5 py-1">Climatisation</span>
                                        <span class="rounded-full bg-surface px-2.5 py-1">Mini-bar</span>
                                        @if($room->type === 'suite')
                                            <span class="rounded-full bg-gold-50 px-2.5 py-1 text-gold-700">Piscine privée</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="text-left sm:text-right">
                                <p class="text-2xl font-bold text-navy-900">{{ number_format($room->prix, 0, ',', ' ') }} <span class="text-base font-normal text-muted">CFA</span></p>
                                <p class="text-sm text-muted">par nuit</p>
                            </div>
                        </div>
                    </button>
                @empty
                    <div class="empty-state">
                        <p class="text-muted">Aucune chambre disponible pour le moment.</p>
                    </div>
                @endforelse
            </div>

            <h2 class="mt-14 text-2xl font-semibold text-navy-900">Avis des voyageurs</h2>
            <div class="mt-6 space-y-4">
                @foreach([
                    ['S', 'Sarah M.', '2026-02-15', 'Vue absolument magnifique et service impeccable. Le séjour était inoubliable.', 5],
                    ['J', 'James K.', '2026-01-20', 'Très bel établissement avec de superbes équipements. Le restaurant est excellent.', 4],
                    ['E', 'Emma L.', '2025-12-10', 'Destination parfaite pour une lune de miel. Chaque détail était soigné.', 5],
                ] as $review)
                    <article class="card p-5 sm:p-6">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex gap-4">
                                <span class="grid h-12 w-12 place-items-center rounded-full bg-gradient-to-br from-navy-900 to-navy-700 font-semibold text-gold-400">{{ $review[0] }}</span>
                                <div>
                                    <p class="font-semibold text-navy-900">{{ $review[1] }}</p>
                                    <p class="text-sm text-muted">{{ $review[2] }}</p>
                                </div>
                            </div>
                            <span class="rating-stars text-sm">{{ str_repeat('★', $review[4]) }}{{ str_repeat('☆', 5 - $review[4]) }}</span>
                        </div>
                        <p class="mt-4 leading-relaxed text-navy-800/80">{{ $review[3] }}</p>
                    </article>
                @endforeach
            </div>
        </div>

        <aside class="reveal lg:sticky lg:top-28 lg:self-start">
            <div class="glass-card p-6 sm:p-8">
                <h2 class="font-display text-2xl font-semibold text-navy-900">Réserver votre séjour</h2>

                <form method="POST" action="{{ route('bookings.payment') }}" data-booking-form class="mt-6">
                    @csrf
                    <input type="hidden" name="room_id" data-room-id-input>
                    <input type="hidden" name="email" data-email-input>
                    <input type="hidden" name="password" data-password-input>

                    <div class="hidden rounded-xl border border-gold-200 bg-gold-50/60 p-4" data-selected-room-box>
                        <p class="font-semibold text-navy-900" data-selected-room-name></p>
                        <p class="text-sm text-muted"><span data-selected-room-price></span> / nuit</p>
                    </div>
                    <p class="mt-4 text-sm text-muted" data-empty-room-text>Sélectionnez une chambre ci-dessus</p>

                    <label class="mt-6 block">
                        <span class="form-label">Arrivée</span>
                        <input type="date" name="date_arrivee" required class="form-input-filled" data-checkin>
                    </label>

                    <label class="mt-4 block">
                        <span class="form-label">Départ</span>
                        <input type="date" name="date_depart" required class="form-input-filled" data-checkout>
                    </label>

                    <div class="mt-6 hidden rounded-xl border border-navy-900/10 bg-surface p-4" data-total-box>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-muted" data-total-label></span>
                            <span class="text-lg font-bold text-navy-900" data-total-price></span>
                        </div>
                    </div>

                    <button type="button" data-open-auth class="btn-primary mt-6 w-full py-4" disabled>Réserver maintenant</button>

                    <p class="mt-4 flex items-center justify-center gap-2 text-xs text-muted">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3" y="11" width="18" height="10" rx="2" /><path d="M7 11V7a5 5 0 0 1 10 0v4" /></svg>
                        Paiement sécurisé · Sans frais cachés
                    </p>
                </form>
            </div>
        </aside>
    </section>

    <div id="auth-modal" class="modal-backdrop hidden" role="dialog" aria-modal="true" aria-labelledby="auth-modal-title">
        <div data-auth-card class="modal-panel">
            <div class="mb-6 flex items-center justify-between">
                <h2 id="auth-modal-title" class="font-display text-2xl font-semibold text-navy-900">Créer votre compte</h2>
                <button type="button" data-close-auth class="grid h-10 w-10 place-items-center rounded-xl text-muted transition hover:bg-surface hover:text-navy-900" aria-label="Fermer">&times;</button>
            </div>
            <div class="space-y-4">
                <label class="block">
                    <span class="form-label">Adresse e-mail</span>
                    <input type="email" data-auth-email class="form-input" placeholder="vous@exemple.com" required>
                </label>
                <label class="block">
                    <span class="form-label">Mot de passe</span>
                    <input type="password" data-auth-password class="form-input" placeholder="Mot de passe" required>
                </label>
                <button type="button" data-submit-auth class="btn-primary w-full">Continuer vers le paiement</button>
            </div>
        </div>
    </div>

    <div class="sticky-booking-bar" data-mobile-book-bar style="display: none;">
        <button type="button" data-open-auth-mobile class="btn-primary w-full" disabled>Réserver</button>
    </div>
</main>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const options = document.querySelectorAll('.room-option');
        const roomIdInput = document.querySelector('[data-room-id-input]');
        const roomBox = document.querySelector('[data-selected-room-box]');
        const roomName = document.querySelector('[data-selected-room-name]');
        const roomPrice = document.querySelector('[data-selected-room-price]');
        const emptyText = document.querySelector('[data-empty-room-text]');
        const checkin = document.querySelector('[data-checkin]');
        const checkout = document.querySelector('[data-checkout]');
        const totalBox = document.querySelector('[data-total-box]');
        const totalLabel = document.querySelector('[data-total-label]');
        const totalPrice = document.querySelector('[data-total-price]');
        const bookButton = document.querySelector('[data-open-auth]');
        const mobileBook = document.querySelector('[data-open-auth-mobile]');
        const mobileBar = document.querySelector('[data-mobile-book-bar]');
        const form = document.querySelector('[data-booking-form]');
        const modal = document.getElementById('auth-modal');
        const modalCard = document.querySelector('[data-auth-card]');
        const emailInput = document.querySelector('[data-auth-email]');
        const passwordInput = document.querySelector('[data-auth-password]');
        const hiddenEmail = document.querySelector('[data-email-input]');
        const hiddenPassword = document.querySelector('[data-password-input]');
        let selectedPrice = 0;

        const calculate = () => {
            if (!selectedPrice || !checkin.value || !checkout.value) {
                totalBox.classList.add('hidden');
                bookButton.disabled = true;
                if (mobileBook) mobileBook.disabled = true;
                return;
            }

            const start = new Date(checkin.value);
            const end = new Date(checkout.value);
            const nights = Math.round((end - start) / 86400000);

            if (nights <= 0) {
                totalBox.classList.add('hidden');
                bookButton.disabled = true;
                if (mobileBook) mobileBook.disabled = true;
                return;
            }

            totalLabel.textContent = `${selectedPrice.toLocaleString('fr-FR')} CFA × ${nights} nuit${nights > 1 ? 's' : ''}`;
            totalPrice.textContent = `${(selectedPrice * nights).toLocaleString('fr-FR')} CFA`;
            totalBox.classList.remove('hidden');
            bookButton.disabled = false;
            if (mobileBook) {
                mobileBook.disabled = false;
                mobileBook.textContent = `Réserver · ${(selectedPrice * nights).toLocaleString('fr-FR')} CFA`;
            }
            if (mobileBar) mobileBar.style.display = 'block';
        };

        options.forEach((option) => {
            option.addEventListener('click', () => {
                options.forEach((item) => item.classList.remove('is-selected'));
                option.classList.add('is-selected');
                selectedPrice = Number(option.dataset.roomPrice);
                roomIdInput.value = option.dataset.roomId;
                roomName.textContent = option.dataset.roomName;
                roomPrice.textContent = `${selectedPrice.toLocaleString('fr-FR')} CFA`;
                roomBox.classList.remove('hidden');
                emptyText.classList.add('hidden');
                calculate();
            });
        });

        checkin.addEventListener('change', calculate);
        checkout.addEventListener('change', calculate);

        const closeModal = () => {
            modal.classList.add('hidden');
            modal.classList.remove('grid');
        };

        const openModal = () => {
            if (bookButton.disabled) return;
            modal.classList.remove('hidden');
            modal.classList.add('grid');
        };

        bookButton.addEventListener('click', openModal);
        mobileBook?.addEventListener('click', openModal);

        document.querySelector('[data-submit-auth]').addEventListener('click', () => {
            if (!emailInput.value || !passwordInput.value) {
                emailInput.reportValidity();
                passwordInput.reportValidity();
                return;
            }

            hiddenEmail.value = emailInput.value;
            hiddenPassword.value = passwordInput.value;
            form.submit();
        });

        document.querySelector('[data-close-auth]').addEventListener('click', closeModal);
        modal.addEventListener('click', closeModal);
        modalCard.addEventListener('click', (event) => event.stopPropagation());
    });
</script>
@endpush
@endsection
