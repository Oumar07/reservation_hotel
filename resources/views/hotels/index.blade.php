@extends('layouts.app')

@section('content')
@php
    $fallbackImages = [
        'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=900&q=80',
    ];
@endphp

<section class="relative min-h-[640px] overflow-hidden bg-slate-900">
    <img src="https://images.unsplash.com/photo-1602002418082-a4443e081dd1?auto=format&fit=crop&w=2200&q=85"
         alt="Luxury resort"
         class="absolute inset-0 h-full w-full object-cover opacity-65">
    <div class="absolute inset-0 bg-black/35"></div>

    <div class="relative mx-auto flex min-h-[640px] max-w-[1540px] flex-col items-center justify-center px-6 text-center text-white">
        <h1 class="max-w-5xl text-5xl font-semibold tracking-normal sm:text-7xl">Trouvez le séjour parfait</h1>
        <p class="mt-5 text-xl font-normal text-white/90">Découvrez des hôtels et resorts sélectionnés avec soin</p>

        <form action="/hotels" method="GET" class="mt-12 grid w-full max-w-5xl gap-0 overflow-hidden rounded-3xl bg-white p-2 text-left shadow-2xl md:grid-cols-[1.2fr_1fr_0.8fr_auto]">
            <label class="search-field">
                <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z" /><circle cx="12" cy="10" r="3" /></svg>
                <input name="destination" value="{{ request('destination') }}" placeholder="Où allez-vous ?" class="search-input">
            </label>

            <label class="search-field md:border-l md:border-slate-200">
                <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8 2v4M16 2v4M3 10h18" /><rect x="3" y="4" width="18" height="18" rx="2" /></svg>
                <input type="date" name="date" value="{{ request('date') }}" class="search-input">
            </label>

            <label class="search-field md:border-l md:border-slate-200">
                <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" /><circle cx="9" cy="7" r="4" /><path d="M22 21v-2a4 4 0 0 0-3-3.87" /></svg>
                <select name="guests" class="search-input">
                    @foreach([1, 2, 3, 4, 5, 6] as $guest)
                        <option value="{{ $guest }}" @selected((int) request('guests', 2) === $guest)>{{ $guest }} personne{{ $guest > 1 ? 's' : '' }}</option>
                    @endforeach
                </select>
            </label>

            <button class="flex items-center justify-center gap-3 rounded-2xl bg-blue-600 px-8 py-4 font-medium text-white transition hover:bg-blue-700">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8" /><path d="m21 21-4.3-4.3" /></svg>
                Rechercher
            </button>
        </form>
    </div>
</section>

<section class="mx-auto max-w-[1540px] px-6 py-14 sm:px-10 lg:px-16">
    <h2 class="mb-8 text-3xl font-semibold tracking-normal">Hôtels recommandés</h2>

    @if(session('success'))
        <div class="mb-6 rounded-2xl bg-green-50 p-4 text-green-700">{{ session('success') }}</div>
    @endif

    <div class="grid gap-8 lg:grid-cols-[320px_1fr]">
        <aside class="h-max rounded-3xl bg-white p-7 shadow-sm ring-1 ring-slate-100">
            <div class="mb-6 flex items-center gap-3">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 21v-7M4 10V3M12 21v-9M12 8V3M20 21v-5M20 12V3M2 14h4M10 8h4M18 16h4" /></svg>
                <h3 class="text-2xl font-semibold">Filtres</h3>
            </div>

            <form action="/hotels" method="GET" class="space-y-7">
                <input type="hidden" name="destination" value="{{ request('destination') }}">
                <input type="hidden" name="date" value="{{ request('date') }}">
                <input type="hidden" name="guests" value="{{ request('guests') }}">

                <div>
                    <p class="mb-3 font-medium">Pays</p>
                    <div class="space-y-3">
                        @foreach($countries as $country)
                            <label class="flex items-center gap-3 text-slate-700">
                                <input type="radio" name="country" value="{{ $country }}" @checked(request('country') === $country) class="h-5 w-5 border-slate-300 text-blue-600">
                                {{ $country }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <p class="mb-3 font-medium">Fourchette de prix</p>
                    <input type="range" name="max_price" min="0" max="2000000" step="10000" value="{{ request('max_price', 2000000) }}" class="w-full accent-blue-600" oninput="this.nextElementSibling.querySelector('span:last-child').textContent = Number(this.value).toLocaleString() + ' CFA'">
                    <div class="mt-1 flex justify-between text-slate-500"><span>0 CFA</span><span>{{ number_format(request('max_price', 2000000), 0) }} CFA</span></div>
                </div>

                <div>
                    <p class="mb-3 font-medium">Type de chambre</p>
                    <div class="space-y-3">
                        @foreach(['simple' => 'Simple', 'double' => 'Double', 'suite' => 'Suite'] as $type => $label)
                            <label class="flex items-center gap-3 text-slate-700">
                                <input type="radio" name="room_type" value="{{ $type }}" @checked(request('room_type') === $type) class="h-5 w-5 border-slate-300 text-blue-600">
                                {{ $label }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <p class="mb-3 font-medium">Note minimum</p>
                    <div class="flex gap-3">
                        @foreach([3, 4, 5] as $rating)
                            <button type="submit" name="rating" value="{{ $rating }}" class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium">{{ $rating }}+ étoiles</button>
                        @endforeach
                    </div>
                </div>

                <button class="w-full rounded-xl bg-blue-600 px-5 py-3 font-medium text-white">Appliquer les filtres</button>
            </form>
        </aside>

        <div class="grid gap-8 md:grid-cols-2 xl:grid-cols-3">
            @forelse($hotels as $hotel)
                @php
                    $price = $hotel->rooms->min('prix') ?? 0;
                    $rating = round($hotel->reviews->avg('note') ?: (4.4 + (($hotel->id % 6) / 10)), 1);
                    $reviews = $hotel->reviews->count() ?: (160 + ($hotel->id * 37));
                    $image = $hotel->image ?: $fallbackImages[$loop->index % count($fallbackImages)];
                @endphp
                <a href="{{ route('hotels.show', $hotel) }}" class="group overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-slate-100 transition hover:-translate-y-1 hover:shadow-lg">
                    <div class="relative h-72 overflow-hidden">
                        <img src="{{ $image }}" alt="{{ $hotel->nom }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                        <span class="absolute bottom-5 right-5 rounded-2xl bg-white/95 px-5 py-3 font-semibold shadow-sm">
                            {{ number_format($price, 0) }} CFA <span class="font-normal text-slate-500">/ nuit</span>
                        </span>
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-semibold">{{ $hotel->nom }}</h3>
                        <p class="mt-2 flex items-center gap-2 text-slate-500">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z" /><circle cx="12" cy="10" r="3" /></svg>
                            {{ $hotel->localisation }}, {{ $hotel->pays }}
                        </p>
                        <div class="mt-5 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="text-amber-400">★★★★★</span>
                                <span class="font-medium">{{ $rating }}</span>
                            </div>
                            <span class="text-slate-500">{{ $reviews }} avis</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="rounded-3xl bg-white p-8 text-slate-500 shadow-sm ring-1 ring-slate-100 md:col-span-2 xl:col-span-3">
                    Aucun hôtel ne correspond à votre recherche.
                </div>
            @endforelse
        </div>
    </div>
</section>

<style>
    .search-field {
        display: flex;
        align-items: center;
        gap: 0.9rem;
        padding: 0.95rem 1.25rem;
        color: rgb(100 116 139);
    }

    .search-icon {
        height: 1.35rem;
        width: 1.35rem;
        flex: none;
    }

    .search-input {
        width: 100%;
        border: 0;
        background: transparent;
        color: rgb(15 23 42);
        outline: none;
    }
</style>
@endsection
