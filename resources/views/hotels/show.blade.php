@extends('layouts.app')

@section('content')
@php
    $fallbackImage = 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1800&q=85';
    $roomFallback = 'https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=700&q=80';
    $heroImage = $hotel->image ?: $fallbackImage;
    $rating = round($hotel->reviews->avg('note') ?: (4.4 + (($hotel->id % 6) / 10)), 1);
    $reviewCount = $hotel->reviews->count() ?: (160 + ($hotel->id * 37));
    $roomTypeLabels = ['simple' => 'Simple', 'double' => 'Double', 'suite' => 'Suite'];
@endphp

<main class="mx-auto max-w-[1540px] px-5 py-10 sm:px-8 lg:px-10" data-booking-page>
    <section>
        <div class="relative h-[520px] overflow-hidden rounded-3xl bg-slate-200">
            <img src="{{ $heroImage }}" alt="{{ $hotel->nom }}" class="h-full w-full object-cover">
            <button class="absolute left-5 top-1/2 grid h-11 w-11 -translate-y-1/2 place-items-center rounded-full bg-white/85 text-slate-700 shadow-sm">&lsaquo;</button>
            <button class="absolute right-5 top-1/2 grid h-11 w-11 -translate-y-1/2 place-items-center rounded-full bg-white/85 text-slate-700 shadow-sm">&rsaquo;</button>
        </div>
        <div class="mt-4 flex gap-3">
            @foreach([0, 1, 2] as $item)
                <img src="{{ $item === 0 ? $heroImage : $roomFallback }}" alt="Hotel preview" class="h-20 w-28 rounded-xl object-cover ring-2 {{ $loop->first ? 'ring-blue-500' : 'ring-transparent' }}">
            @endforeach
        </div>
    </section>

    <section class="mt-10 grid gap-10 lg:grid-cols-[1fr_460px]">
        <div>
            <h1 class="text-4xl font-semibold tracking-normal">{{ $hotel->nom }}</h1>
            <div class="mt-3 flex flex-wrap items-center gap-3 text-slate-500">
                <span>{{ $hotel->localisation }}, {{ $hotel->pays }}</span>
                <span>&middot;</span>
                <span class="text-amber-400">★★★★★</span>
                <span class="font-medium text-slate-800">{{ $rating }}</span>
                <span>({{ $reviewCount }} avis)</span>
            </div>

            <p class="mt-7 max-w-5xl text-lg leading-8 text-slate-600">
                {{ $hotel->description ?: 'Situé dans une destination agréable, cet hôtel StayHub propose des chambres confortables, un service attentif, des espaces de détente et tout le nécessaire pour un séjour mémorable.' }}
            </p>

            <div class="mt-7 flex flex-wrap gap-8 text-sm font-medium text-slate-600">
                @foreach(['Piscine', 'Spa', 'Restaurant', 'Bar', 'Salle de sport', 'WiFi', 'Parking'] as $amenity)
                    <span class="flex items-center gap-2">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12.55a11 11 0 0 1 14.08 0" /><path d="M8.53 16.11a6 6 0 0 1 6.95 0" /><path d="M12 20h.01" /></svg>
                        {{ $amenity }}
                    </span>
                @endforeach
            </div>

            <h2 class="mt-12 text-2xl font-semibold">Chambres disponibles</h2>
            <div class="mt-5 space-y-5">
                @forelse($hotel->rooms as $room)
                    <button type="button"
                            class="room-option w-full rounded-2xl border border-slate-100 bg-white p-5 text-left shadow-sm transition hover:border-blue-300 hover:bg-blue-50/40"
                            data-room-id="{{ $room->id }}"
                            data-room-name="Chambre {{ $roomTypeLabels[$room->type] ?? ucfirst($room->type) }}"
                            data-room-price="{{ (float) $room->prix }}">
                        <div class="flex items-center justify-between gap-5">
                            <div class="flex items-center gap-5">
                                <img src="{{ $room->image ?: $roomFallback }}" alt="{{ $room->type }}" class="h-32 w-48 rounded-xl object-cover">
                                <div>
                                    <h3 class="text-xl font-semibold">Chambre {{ $roomTypeLabels[$room->type] ?? ucfirst($room->type) }}</h3>
                                    <p class="mt-1 text-slate-500">Chambre {{ $roomTypeLabels[$room->type] ?? ucfirst($room->type) }}</p>
                                    <p class="mt-3 text-sm text-slate-500">{{ $room->capacite }} personne{{ $room->capacite > 1 ? 's' : '' }}</p>
                                    <div class="mt-4 flex flex-wrap gap-5 text-sm text-slate-500">
                                        <span>WiFi</span>
                                        <span>AC</span>
                                        <span>Mini-bar</span>
                                        @if($room->type === 'suite')
                                            <span>Piscine privée</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-semibold">{{ number_format($room->prix, 0) }} CFA</p>
                                <p class="text-sm text-slate-500">par nuit</p>
                            </div>
                        </div>
                    </button>
                @empty
                    <div class="rounded-2xl bg-white p-7 text-slate-500 shadow-sm ring-1 ring-slate-100">Aucune chambre disponible pour le moment.</div>
                @endforelse
            </div>

            <h2 class="mt-12 text-2xl font-semibold">Avis des voyageurs</h2>
            <div class="mt-5 space-y-5">
                @foreach([
                    ['S', 'Sarah M.', '2026-02-15', 'Vue absolument magnifique et service impeccable. Le séjour était inoubliable.', 5],
                    ['J', 'James K.', '2026-01-20', 'Très bel établissement avec de superbes équipements. Le restaurant est excellent.', 4],
                    ['E', 'Emma L.', '2025-12-10', 'Destination parfaite pour une lune de miel. Chaque détail était soigné.', 5],
                ] as $review)
                    <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-100">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex gap-4">
                                <span class="grid h-12 w-12 place-items-center rounded-full bg-blue-50 font-medium text-blue-600">{{ $review[0] }}</span>
                                <div>
                                    <p class="font-medium">{{ $review[1] }}</p>
                                    <p class="text-sm text-slate-500">{{ $review[2] }}</p>
                                </div>
                            </div>
                            <span class="text-amber-400">{{ str_repeat('★', $review[4]) }}{{ str_repeat('☆', 5 - $review[4]) }}</span>
                        </div>
                        <p class="mt-4 text-slate-600">{{ $review[3] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <aside class="h-max rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-100 lg:sticky lg:top-28">
            <h2 class="text-2xl font-semibold">Réserver votre séjour</h2>
            <form method="POST" action="{{ route('bookings.payment') }}" data-booking-form>
                @csrf
                <input type="hidden" name="room_id" data-room-id-input>
                <input type="hidden" name="email" data-email-input>
                <input type="hidden" name="password" data-password-input>

                <div class="mt-6 rounded-xl bg-blue-50 p-4 text-slate-700 hidden" data-selected-room-box>
                    <p class="font-medium" data-selected-room-name></p>
                    <p class="text-slate-500"><span data-selected-room-price></span>/nuit</p>
                </div>
                <p class="mt-5 text-slate-500" data-empty-room-text>Sélectionnez une chambre ci-dessus</p>

                <label class="mt-6 block">
                    <span class="mb-2 block font-medium">Arrivée</span>
                    <input type="date" name="date_arrivee" required class="booking-input" data-checkin>
                </label>

                <label class="mt-5 block">
                    <span class="mb-2 block font-medium">Départ</span>
                    <input type="date" name="date_depart" required class="booking-input" data-checkout>
                </label>

                <div class="mt-6 hidden rounded-xl border border-slate-200 p-4" data-total-box>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500" data-total-label></span>
                        <span class="font-semibold" data-total-price></span>
                    </div>
                </div>

                <button type="button" data-open-auth class="mt-6 w-full rounded-xl bg-blue-600 px-5 py-4 font-medium text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:bg-blue-300" disabled>Réserver maintenant</button>
            </form>
        </aside>
    </section>

    <div id="auth-modal" class="fixed inset-0 z-50 hidden place-items-center bg-black/70 px-4 py-8">
        <div data-auth-card class="w-full max-w-md rounded-2xl bg-white p-7 shadow-2xl">
            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-2xl font-semibold">Créer votre compte</h2>
                <button type="button" data-close-auth class="text-3xl font-light leading-none text-slate-500">&times;</button>
            </div>
            <div class="space-y-4">
                <label class="block">
                    <span class="mb-2 block text-sm font-medium">Adresse e-mail</span>
                    <input type="email" data-auth-email class="booking-input" placeholder="vous@exemple.com" required>
                </label>
                <label class="block">
                    <span class="mb-2 block text-sm font-medium">Mot de passe</span>
                    <input type="password" data-auth-password class="booking-input" placeholder="Mot de passe" required>
                </label>
                <button type="button" data-submit-auth class="w-full rounded-xl bg-blue-600 px-5 py-3 font-medium text-white">Continuer vers le paiement</button>
            </div>
        </div>
    </div>
</main>

<style>
    .booking-input {
        width: 100%;
        border-radius: 0.85rem;
        border: 1px solid rgb(226 232 240);
        background: rgb(248 250 252);
        padding: 0.9rem 1rem;
        color: rgb(15 23 42);
        outline: none;
    }

    .booking-input:focus {
        border-color: rgb(37 99 235);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    .room-option.is-selected {
        border-color: rgb(147 197 253);
        background: rgb(239 246 255);
    }
</style>

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
                return;
            }

            const start = new Date(checkin.value);
            const end = new Date(checkout.value);
            const nights = Math.round((end - start) / 86400000);

            if (nights <= 0) {
                totalBox.classList.add('hidden');
                bookButton.disabled = true;
                return;
            }

            totalLabel.textContent = `${selectedPrice.toLocaleString()} CFA x ${nights} nuit${nights > 1 ? 's' : ''}`;
            totalPrice.textContent = `${(selectedPrice * nights).toLocaleString()} CFA`;
            totalBox.classList.remove('hidden');
            bookButton.disabled = false;
        };

        options.forEach((option) => {
            option.addEventListener('click', () => {
                options.forEach((item) => item.classList.remove('is-selected'));
                option.classList.add('is-selected');
                selectedPrice = Number(option.dataset.roomPrice);
                roomIdInput.value = option.dataset.roomId;
                roomName.textContent = option.dataset.roomName;
                roomPrice.textContent = `${selectedPrice.toLocaleString()} CFA`;
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

        bookButton.addEventListener('click', () => {
            if (bookButton.disabled) return;
            modal.classList.remove('hidden');
            modal.classList.add('grid');
        });

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
@endsection
