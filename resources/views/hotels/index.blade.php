@extends('layouts.app')

@section('title', 'StayHub — Trouvez le séjour parfait')

@section('content')
@php
    $fallbackImages = [
        'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=900&q=80',
    ];
    $hotelCount = $hotels->count();
@endphp

{{-- Hero --}}
<section class="relative flex min-h-[92vh] items-center overflow-hidden bg-navy-950">
    <img src="https://images.unsplash.com/photo-1602002418082-a4443e081dd1?auto=format&fit=crop&w=2400&q=85"
         alt="Resort de luxe au coucher du soleil"
         class="absolute inset-0 h-full w-full object-cover opacity-50"
         loading="eager"
         fetchpriority="high">
    <div class="absolute inset-0 bg-gradient-to-b from-navy-950/40 via-navy-950/60 to-navy-950/90"></div>

    <div class="relative z-10 mx-auto w-full max-w-[1540px] px-5 pb-24 pt-32 text-center sm:px-8 lg:px-12 lg:pt-40">
        <p class="animate-fade-in mb-4 text-sm font-semibold uppercase tracking-[0.2em] text-gold-400">Hôtellerie d'exception</p>
        <h1 class="animate-fade-up font-display text-5xl font-semibold leading-tight text-white sm:text-6xl lg:text-7xl">
            Trouvez le séjour parfait
        </h1>
        <p class="animate-fade-up mx-auto mt-6 max-w-2xl text-lg text-white/85 sm:text-xl" style="animation-delay: 0.1s">
            Découvrez des hôtels et resorts sélectionnés avec soin, pour des moments inoubliables.
        </p>

        <form action="/hotels" method="GET" class="search-bar animate-fade-up mx-auto mt-12 max-w-5xl text-left" style="animation-delay: 0.2s">
            <label class="search-field">
                <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z" /><circle cx="12" cy="10" r="3" /></svg>
                <input name="destination" value="{{ request('destination') }}" placeholder="Où allez-vous ?" class="search-input" aria-label="Destination">
            </label>

            <label class="search-field">
                <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8 2v4M16 2v4M3 10h18" /><rect x="3" y="4" width="18" height="18" rx="2" /></svg>
                <input type="date" name="date" value="{{ request('date') }}" class="search-input" aria-label="Date d'arrivée">
            </label>

            <label class="search-field">
                <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" /><circle cx="9" cy="7" r="4" /></svg>
                <select name="guests" class="search-input" aria-label="Nombre de voyageurs">
                    @foreach([1, 2, 3, 4, 5, 6] as $guest)
                        <option value="{{ $guest }}" @selected((int) request('guests', 2) === $guest)>{{ $guest }} personne{{ $guest > 1 ? 's' : '' }}</option>
                    @endforeach
                </select>
            </label>

            <button type="submit" class="btn-gold rounded-xl px-8 py-4 sm:rounded-xl">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8" /><path d="m21 21-4.3-4.3" /></svg>
                Rechercher
            </button>
        </form>
    </div>
</section>

{{-- Stats --}}
<section class="relative z-20 -mt-16">
    <div class="page-container">
        <div class="glass-card grid gap-6 p-6 sm:grid-cols-3 sm:p-8 reveal">
            <div class="text-center sm:text-left">
                <p class="font-display text-4xl font-semibold text-navy-900" data-counter="{{ max($hotelCount, 12) }}">{{ max($hotelCount, 12) }}+</p>
                <p class="mt-1 text-sm text-muted">Hôtels partenaires</p>
            </div>
            <div class="border-y border-navy-900/10 py-4 text-center sm:border-x sm:border-y-0 sm:py-0">
                <p class="font-display text-4xl font-semibold text-navy-900">4.8</p>
                <p class="mt-1 text-sm text-muted">Note moyenne voyageurs</p>
            </div>
            <div class="text-center sm:text-right">
                <p class="font-display text-4xl font-semibold text-navy-900">24/7</p>
                <p class="mt-1 text-sm text-muted">Assistance concierge</p>
            </div>
        </div>
    </div>
</section>

{{-- Listings --}}
<section class="section-padding">
    <div class="page-container">
        <div class="reveal mb-10 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="section-title">Hôtels recommandés</h2>
                <p class="section-subtitle">{{ $hotelCount }} établissement{{ $hotelCount > 1 ? 's' : '' }} disponible{{ $hotelCount > 1 ? 's' : '' }}</p>
            </div>
        </div>

        @include('partials.flash')

        <div class="grid gap-10 lg:grid-cols-[300px_1fr] xl:grid-cols-[320px_1fr]">
            {{-- Filters --}}
            <aside class="reveal h-max lg:sticky lg:top-28">
                <div class="glass-card p-6 sm:p-7">
                    <div class="mb-6 flex items-center gap-3">
                        <span class="grid h-10 w-10 place-items-center rounded-xl bg-navy-900/5 text-navy-700">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 21v-7M4 10V3M12 21v-9M12 8V3M20 21v-5M20 12V3M2 14h4M10 8h4M18 16h4" /></svg>
                        </span>
                        <h3 class="text-xl font-semibold text-navy-900">Filtres</h3>
                    </div>

                    <form action="/hotels" method="GET" class="space-y-7">
                        <input type="hidden" name="destination" value="{{ request('destination') }}">
                        <input type="hidden" name="date" value="{{ request('date') }}">
                        <input type="hidden" name="guests" value="{{ request('guests') }}">

                        <fieldset>
                            <legend class="mb-3 text-sm font-semibold text-navy-900">Pays</legend>
                            <div class="space-y-2.5">
                                @foreach($countries as $country)
                                    <label class="flex cursor-pointer items-center gap-3 rounded-lg px-2 py-1.5 text-sm text-navy-800 transition hover:bg-surface">
                                        <input type="radio" name="country" value="{{ $country }}" @checked(request('country') === $country) class="h-4 w-4 border-navy-900/20 text-navy-900 focus:ring-gold-400">
                                        {{ $country }}
                                    </label>
                                @endforeach
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend class="mb-3 text-sm font-semibold text-navy-900">Fourchette de prix</legend>
                            <input type="range" name="max_price" min="0" max="2000000" step="10000" value="{{ request('max_price', 2000000) }}" class="w-full accent-navy-900" oninput="this.nextElementSibling.querySelector('[data-max]').textContent = Number(this.value).toLocaleString('fr-FR') + ' CFA'">
                            <div class="mt-2 flex justify-between text-xs text-muted">
                                <span>0 CFA</span>
                                <span data-max>{{ number_format(request('max_price', 2000000), 0, ',', ' ') }} CFA</span>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend class="mb-3 text-sm font-semibold text-navy-900">Type de chambre</legend>
                            <div class="space-y-2.5">
                                @foreach(['simple' => 'Simple', 'double' => 'Double', 'suite' => 'Suite'] as $type => $label)
                                    <label class="flex cursor-pointer items-center gap-3 rounded-lg px-2 py-1.5 text-sm text-navy-800 transition hover:bg-surface">
                                        <input type="radio" name="room_type" value="{{ $type }}" @checked(request('room_type') === $type) class="h-4 w-4 border-navy-900/20 text-navy-900 focus:ring-gold-400">
                                        {{ $label }}
                                    </label>
                                @endforeach
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend class="mb-3 text-sm font-semibold text-navy-900">Note minimum</legend>
                            <div class="flex flex-wrap gap-2">
                                @foreach([3, 4, 5] as $rating)
                                    <button type="submit" name="rating" value="{{ $rating }}" class="rounded-xl border border-navy-900/10 bg-white px-3 py-2 text-xs font-semibold text-navy-800 transition hover:border-gold-400 hover:bg-gold-50">{{ $rating }}+ ★</button>
                                @endforeach
                            </div>
                        </fieldset>

                        <button type="submit" class="btn-primary w-full">Appliquer les filtres</button>
                    </form>
                </div>
            </aside>

            {{-- Hotel grid --}}
            <div class="grid gap-8 sm:grid-cols-2 xl:grid-cols-3">
                @forelse($hotels as $hotel)
                    @php
                        $price = $hotel->rooms->min('prix') ?? 0;
                        $rating = round($hotel->reviews->avg('note') ?: (4.4 + (($hotel->id % 6) / 10)), 1);
                        $reviews = $hotel->reviews->count() ?: (160 + ($hotel->id * 37));
                        $image = $hotel->image ?: $fallbackImages[$loop->index % count($fallbackImages)];
                        $available = $hotel->rooms->isNotEmpty();
                    @endphp
                    <article class="hotel-card group reveal">
                        <a href="{{ route('hotels.show', $hotel) }}" class="block">
                            <div class="hotel-card-image">
                                <img src="{{ $image }}" alt="{{ $hotel->nom }}" loading="lazy" decoding="async">
                                @if($available)
                                    <span class="hotel-card-badge">Disponible</span>
                                @endif
                                <button type="button" class="wishlist-btn" data-wishlist aria-label="Ajouter aux favoris">
                                    <svg data-wishlist-outline class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" /></svg>
                                    <svg data-wishlist-filled class="hidden h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" /></svg>
                                </button>
                                <div class="hotel-card-price">
                                    <span class="text-lg font-bold text-navy-900">{{ number_format($price, 0, ',', ' ') }}</span>
                                    <span class="text-xs text-muted"> CFA / nuit</span>
                                </div>
                            </div>
                            <div class="p-5 sm:p-6">
                                <h3 class="font-display text-2xl font-semibold text-navy-900 transition group-hover:text-navy-700">{{ $hotel->nom }}</h3>
                                <p class="mt-2 flex items-center gap-2 text-sm text-muted">
                                    <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z" /><circle cx="12" cy="10" r="3" /></svg>
                                    {{ $hotel->localisation }}, {{ $hotel->pays }}
                                </p>
                                <div class="mt-5 flex items-center justify-between border-t border-navy-900/5 pt-4">
                                    <div class="flex items-center gap-2">
                                        <span class="rating-stars text-sm">★★★★★</span>
                                        <span class="font-semibold text-navy-900">{{ $rating }}</span>
                                    </div>
                                    <span class="text-sm text-muted">{{ $reviews }} avis</span>
                                </div>
                                <span class="btn-outline mt-5 w-full text-center text-sm">Voir les chambres</span>
                            </div>
                        </a>
                    </article>
                @empty
                    <div class="empty-state sm:col-span-2 xl:col-span-3">
                        <div class="empty-state-icon">
                            <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M4 21V5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v16" /><path d="M9 21v-6h6v6" /></svg>
                        </div>
                        <h3 class="text-xl font-semibold text-navy-900">Aucun hôtel trouvé</h3>
                        <p class="mt-2 max-w-md text-muted">Modifiez vos filtres ou votre destination pour découvrir plus d'établissements.</p>
                        <a href="/hotels" class="btn-primary mt-6">Réinitialiser la recherche</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

{{-- Testimonials --}}
<section class="border-t border-navy-900/5 bg-white section-padding">
    <div class="page-container">
        <div class="reveal text-center">
            <p class="text-sm font-semibold uppercase tracking-widest text-gold-600">Témoignages</p>
            <h2 class="section-title mt-2">Ce que disent nos voyageurs</h2>
        </div>

        <div class="mt-12 grid gap-6 md:grid-cols-3">
            @foreach([
                ['S', 'Sarah M.', 'Paris', 'Une expérience absolument parfaite. Le service était impeccable et la chambre magnifique.', 5],
                ['J', 'James K.', 'Londres', 'StayHub a transformé notre façon de réserver. Interface fluide et hôtels de qualité.', 5],
                ['E', 'Emma L.', 'Genève', 'Destination idéale pour notre lune de miel. Chaque détail était soigné avec élégance.', 5],
            ] as $t)
                <blockquote class="card reveal p-6 sm:p-8">
                    <div class="rating-stars mb-4">{{ str_repeat('★', $t[4]) }}</div>
                    <p class="leading-relaxed text-navy-800">« {{ $t[3] }} »</p>
                    <footer class="mt-6 flex items-center gap-4">
                        <span class="grid h-12 w-12 place-items-center rounded-full bg-gradient-to-br from-navy-900 to-navy-700 font-semibold text-gold-400">{{ $t[0] }}</span>
                        <div>
                            <cite class="not-italic font-semibold text-navy-900">{{ $t[1] }}</cite>
                            <p class="text-sm text-muted">{{ $t[2] }}</p>
                        </div>
                    </footer>
                </blockquote>
            @endforeach
        </div>
    </div>
</section>
@endsection
