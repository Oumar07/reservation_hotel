@extends('layouts.app')

@section('title', $hotel->nom . ' — StayHub')

@section('content')
@php
    $fallbackImage = 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1800&q=85';
    $roomFallback = 'https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=700&q=80';
    $heroImage = $hotel->image ?: $fallbackImage;
    $realReviews = $hotel->reviews->sortByDesc('created_at');
    $realAvg = $realReviews->avg('note');
    $rating = $realAvg ? round($realAvg, 1) : round(4.4 + (($hotel->id % 6) / 10), 1);
    $reviewCount = $realReviews->count();
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
                @php
                    $fullStars = floor($rating);
                    $hasHalf = ($rating - $fullStars) >= 0.5;
                    $emptyStars = 5 - $fullStars - ($hasHalf ? 1 : 0);
                @endphp
                <span class="rating-stars" aria-label="Note: {{ $rating }} sur 5">
                    {!! str_repeat('★', $fullStars) . ($hasHalf ? '½' : '') . str_repeat('☆', $emptyStars) !!}
                </span>
                <span class="font-semibold text-navy-900">{{ $rating }}</span>
                <span>({{ $reviewCount }} {{ $reviewCount === 1 ? 'avis' : 'avis' }})</span>
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

            {{-- ═══════════════════════════════════════════════════════ --}}
            {{-- SECTION AVIS                                            --}}
            {{-- ═══════════════════════════════════════════════════════ --}}
            <div class="mt-14" id="avis">
                <div class="flex flex-wrap items-center gap-6">
                    <h2 class="text-2xl font-semibold text-navy-900">Avis des voyageurs</h2>
                    @if($reviewCount > 0)
                        <div class="flex items-center gap-2 rounded-full bg-gold-50 px-4 py-1.5 ring-1 ring-gold-200">
                            <span class="rating-stars text-base">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($rating))
                                        <span class="text-gold-500">★</span>
                                    @elseif($i <= $rating)
                                        <span class="text-gold-300">★</span>
                                    @else
                                        <span class="text-gray-300">☆</span>
                                    @endif
                                @endfor
                            </span>
                            <span class="font-bold text-navy-900">{{ $rating }}</span>
                            <span class="text-sm text-muted">/ 5 &middot; {{ $reviewCount }} {{ $reviewCount === 1 ? 'avis' : 'avis' }}</span>
                        </div>
                    @endif
                </div>

                {{-- Messages flash --}}
                @if(session('review_success'))
                    <div class="mt-4 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-800">
                        <svg class="h-5 w-5 shrink-0 text-emerald-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m9 11 3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                        <p class="text-sm font-medium">{{ session('review_success') }}</p>
                    </div>
                @endif

                {{-- Liste des avis réels --}}
                <div class="mt-6 space-y-4">
                    @forelse($realReviews as $review)
                        <article class="card p-5 sm:p-6">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex gap-4">
                                    <span class="grid h-12 w-12 shrink-0 place-items-center rounded-full bg-gradient-to-br from-navy-900 to-navy-700 font-semibold text-gold-400 uppercase">
                                        {{ mb_substr($review->client->nom ?? 'A', 0, 1) }}
                                    </span>
                                    <div>
                                        <p class="font-semibold text-navy-900">{{ $review->client->nom ?? 'Anonyme' }}</p>
                                        <p class="text-sm text-muted">{{ $review->created_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <div class="flex shrink-0 items-center gap-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->note)
                                            <span class="text-gold-500 text-lg">★</span>
                                        @else
                                            <span class="text-gray-300 text-lg">☆</span>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            <p class="mt-4 leading-relaxed text-navy-800/80">{{ $review->commentaire }}</p>
                        </article>
                    @empty
                        <div class="flex items-center gap-4 rounded-2xl border border-dashed border-navy-900/20 bg-surface/50 p-8 text-center">
                            <div class="w-full">
                                <span class="text-4xl">💬</span>
                                <p class="mt-3 font-medium text-navy-900">Aucun avis pour le moment</p>
                                <p class="mt-1 text-sm text-muted">Soyez le premier à partager votre expérience !</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                {{-- ─── Formulaire pour laisser un avis ───────────────────── --}}
                <div class="mt-10 rounded-2xl border border-navy-900/10 bg-white p-6 shadow-soft sm:p-8" id="laisser-un-avis">
                    <h3 class="text-xl font-semibold text-navy-900">Laisser un avis</h3>
                    <p class="mt-1 text-sm text-muted">Vous devez avoir effectué une réservation dans cet hôtel pour publier un avis.</p>

                    @if($errors->has('email') && request()->is('hotels/*'))
                        <div class="mt-4 flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-red-700">
                            <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                            <p class="text-sm font-medium">{{ $errors->first('email') }}</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('reviews.store') }}" class="mt-6 space-y-5">
                        @csrf
                        <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">

                        <label class="block">
                            <span class="form-label">Votre adresse e-mail <span class="text-red-500">*</span></span>
                            <input type="email" name="email"
                                   value="{{ old('email', session('booking_email')) }}"
                                   class="form-input-filled @error('email') border-red-400 @enderror"
                                   placeholder="vous@exemple.com" required
                                   id="review-email">
                        </label>

                        {{-- Sélecteur d'étoiles --}}
                        <div>
                            <span class="form-label">Votre note <span class="text-red-500">*</span></span>
                            <div class="mt-2 flex gap-1" id="star-rating" role="group" aria-label="Choisir une note">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button"
                                            class="star-btn text-3xl text-gray-300 transition-colors hover:text-gold-500 focus:outline-none"
                                            data-value="{{ $i }}"
                                            aria-label="{{ $i }} étoile{{ $i > 1 ? 's' : '' }}"
                                            id="star-{{ $i }}">★</button>
                                @endfor
                            </div>
                            <input type="hidden" name="note" id="review-note" value="{{ old('note') }}" required>
                            @error('note')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <label class="block">
                            <span class="form-label">Votre commentaire <span class="text-red-500">*</span></span>
                            <textarea name="commentaire" rows="4"
                                      class="form-input-filled resize-none @error('commentaire') border-red-400 @enderror"
                                      placeholder="Partagez votre expérience dans cet hôtel..."
                                      required minlength="10" maxlength="1000"
                                      id="review-commentaire">{{ old('commentaire') }}</textarea>
                            @error('commentaire')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </label>

                        <button type="submit" class="btn-primary" id="submit-review">
                            Publier mon avis
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <aside class="reveal lg:sticky lg:top-28 lg:self-start">
            <div class="card p-6 sm:p-8">
                <h2 class="font-display text-2xl font-semibold text-navy-900">Réserver votre séjour</h2>

                <form method="POST" action="{{ route('bookings.payment') }}" data-booking-form class="mt-6">
                    @csrf
                    <input type="hidden" name="room_id" data-room-id-input>

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

                    @if($errors->has('date_arrivee'))
                        <div class="mt-4 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                            <svg class="mt-0.5 h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                            <p class="text-sm font-medium">{{ $errors->first('date_arrivee') }}</p>
                        </div>
                    @endif

                    <div class="mt-6 hidden rounded-xl border border-navy-900/10 bg-surface p-4" data-total-box>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-muted" data-total-label></span>
                            <span class="text-lg font-bold text-navy-900" data-total-price></span>
                        </div>
                    </div>

                    @auth
                        {{-- Utilisateur connecté : soumettre directement --}}
                        <button type="submit" data-book-btn class="btn-primary mt-6 w-full py-4" disabled>Réserver maintenant</button>
                    @else
                        {{-- Visiteur : rediriger vers login --}}
                        <a href="{{ route('auth.login') }}" data-book-link class="btn-primary mt-6 w-full py-4 text-center hidden">
                            Se connecter pour réserver
                        </a>
                        <button type="button" data-book-btn class="btn-primary mt-6 w-full py-4" disabled>Réserver maintenant</button>
                    @endauth

                    <p class="mt-4 flex items-center justify-center gap-2 text-xs text-muted">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3" y="11" width="18" height="10" rx="2" /><path d="M7 11V7a5 5 0 0 1 10 0v4" /></svg>
                        Paiement sécurisé · Sans frais cachés
                    </p>
                </form>
            </div>
        </aside>
    </section>

    <div class="sticky-booking-bar" data-mobile-book-bar style="display: none;">
        @auth
            <button type="button" data-mobile-book class="btn-primary w-full" disabled>Réserver</button>
        @else
            <a href="{{ route('auth.login') }}" class="btn-primary w-full text-center">Se connecter pour réserver</a>
        @endauth
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
        const bookButton = document.querySelector('[data-book-btn]');
        const bookLink = document.querySelector('[data-book-link]');
        const mobileBook = document.querySelector('[data-mobile-book]');
        const mobileBar = document.querySelector('[data-mobile-book-bar]');
        const form = document.querySelector('[data-booking-form]');
        const isAuthenticated = {{ Auth::check() ? 'true' : 'false' }};
        let selectedPrice = 0;

        const calculate = () => {
            if (!selectedPrice || !checkin.value || !checkout.value) {
                totalBox.classList.add('hidden');
                if (bookButton) bookButton.disabled = true;
                if (bookLink) { bookLink.classList.add('hidden'); if (bookButton) bookButton.classList.remove('hidden'); }
                if (mobileBook) mobileBook.disabled = true;
                return;
            }

            const start = new Date(checkin.value);
            const end = new Date(checkout.value);
            const nights = Math.round((end - start) / 86400000);

            if (nights <= 0) {
                totalBox.classList.add('hidden');
                if (bookButton) bookButton.disabled = true;
                if (bookLink) { bookLink.classList.add('hidden'); if (bookButton) bookButton.classList.remove('hidden'); }
                if (mobileBook) mobileBook.disabled = true;
                return;
            }

            totalLabel.textContent = `${selectedPrice.toLocaleString('fr-FR')} CFA × ${nights} nuit${nights > 1 ? 's' : ''}`;
            totalPrice.textContent = `${(selectedPrice * nights).toLocaleString('fr-FR')} CFA`;
            totalBox.classList.remove('hidden');

            if (isAuthenticated) {
                if (bookButton) bookButton.disabled = false;
            } else {
                // Guest: show login link, hide disabled button
                if (bookButton) bookButton.classList.add('hidden');
                if (bookLink) bookLink.classList.remove('hidden');
            }

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

        // Mobile book button submits the main form
        if (mobileBook && form) {
            mobileBook.addEventListener('click', () => {
                if (!mobileBook.disabled) form.submit();
            });
        }
    });

    // ─── Sélecteur d'étoiles interactif ─────────────────────────────────────
    (function () {
        const starBtns = document.querySelectorAll('.star-btn');
        const noteInput = document.getElementById('review-note');

        if (!starBtns.length || !noteInput) return;

        const setStars = (value) => {
            starBtns.forEach((btn) => {
                const v = parseInt(btn.dataset.value, 10);
                btn.style.color = v <= value ? '#c9a84c' : '#d1d5db';
            });
            noteInput.value = value;
        };

        // Restaurer la valeur existante (old input)
        const initialNote = parseInt(noteInput.value, 10);
        if (initialNote >= 1 && initialNote <= 5) setStars(initialNote);

        starBtns.forEach((btn) => {
            btn.addEventListener('click', () => setStars(parseInt(btn.dataset.value, 10)));
            btn.addEventListener('mouseenter', () => {
                const v = parseInt(btn.dataset.value, 10);
                starBtns.forEach((b) => {
                    b.style.color = parseInt(b.dataset.value, 10) <= v ? '#c9a84c' : '#d1d5db';
                });
            });
            btn.addEventListener('mouseleave', () => {
                const current = parseInt(noteInput.value, 10);
                setStars(current || 0);
            });
        });
    })();
</script>
@endpush
@endsection
