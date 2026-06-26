@extends('layouts.app')

@section('title', 'Mon Séjour — StayHub')

@section('content')
@php
    $typeLabels = ['restaurant' => 'Restaurants', 'cinema' => 'Cinémas', 'supermarche' => 'Supermarchés'];
    $typeIcons  = ['restaurant' => '🍴', 'cinema' => '🎬', 'supermarche' => '🛒'];
    $typeColors = [
        'restaurant'  => 'from-orange-500 to-amber-500',
        'cinema'      => 'from-purple-500 to-indigo-500',
        'supermarche' => 'from-teal-500 to-emerald-500',
    ];
    $typeBadgeColors = [
        'restaurant'  => 'bg-orange-50 text-orange-700',
        'cinema'      => 'bg-purple-50 text-purple-700',
        'supermarche' => 'bg-teal-50 text-teal-700',
    ];
    $typeDefaultImages = [
        'restaurant'  => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=500&q=80',
        'cinema'      => 'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?auto=format&fit=crop&w=500&q=80',
        'supermarche' => 'https://images.unsplash.com/photo-1604719312566-8912e9227c6a?auto=format&fit=crop&w=500&q=80',
    ];
    $roomTypeLabels = ['simple' => 'Simple', 'double' => 'Double', 'suite' => 'Suite'];
@endphp

<main class="page-container section-padding">
    {{-- En-tête --}}
    <div class="reveal mb-10">
        <p class="text-sm font-semibold uppercase tracking-widest text-gold-600">Guide du séjour</p>
        <h1 class="section-title mt-2">Mon séjour</h1>
        <p class="section-subtitle">
            Découvrez les meilleurs endroits autour de votre hôtel.
        </p>
    </div>

    @if(!$booking)
        {{-- Aucune réservation --}}
        <div class="empty-state reveal">
            <div class="empty-state-icon">
                <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M8 2v4M16 2v4M3 10h18"/><rect x="3" y="4" width="18" height="18" rx="2"/></svg>
            </div>
            <h3 class="text-xl font-semibold text-navy-900">Aucune réservation en cours</h3>
            <p class="mt-2 max-w-md text-muted">Réservez un hôtel pour découvrir les lieux intéressants autour de votre établissement.</p>
            <a href="/hotels" class="btn-primary mt-6">Découvrir les hôtels</a>
        </div>
    @else
        {{-- Carte de la réservation --}}
        <div class="card reveal mb-10 overflow-hidden">
            <div class="flex flex-col gap-6 p-5 sm:flex-row sm:p-6">
                <div class="shrink-0">
                    <img src="{{ $hotel->image ?? 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=500&q=80' }}"
                         alt="{{ $hotel->nom }}"
                         class="h-44 w-full rounded-2xl object-cover sm:h-36 sm:w-52"
                         loading="lazy">
                </div>
                <div class="flex flex-1 flex-col justify-between gap-4">
                    <div>
                        <h2 class="font-display text-2xl font-semibold text-navy-900">{{ $hotel->nom }}</h2>
                        <p class="mt-0.5 flex items-center gap-1.5 text-sm text-muted">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                            {{ $hotel->localisation }}{{ isset($hotel->pays) ? ', ' . $hotel->pays : '' }}
                        </p>

                        <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-4">
                            <div class="rounded-xl bg-surface px-3 py-2.5">
                                <p class="text-xs text-muted">Chambre</p>
                                <p class="mt-0.5 font-medium text-navy-900">
                                    {{ $roomTypeLabels[$room->type ?? ''] ?? ucfirst($room->type ?? 'N/A') }}
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
                            <div class="rounded-xl bg-surface px-3 py-2.5">
                                <p class="text-xs text-muted">Prix total</p>
                                <p class="mt-0.5 font-medium text-navy-900">
                                    {{ number_format($booking->prix_total, 0, ',', ' ') }} CFA
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section recommandations --}}
        @if($places->isEmpty())
            <div class="card reveal p-8 text-center">
                <span class="text-4xl">📍</span>
                <h3 class="mt-3 text-xl font-semibold text-navy-900">Pas encore de recommandations</h3>
                <p class="mt-2 text-muted">Les lieux intéressants autour de votre hôtel seront bientôt disponibles.</p>
            </div>
        @else
            <div class="reveal mb-8">
                <h2 class="font-display text-2xl font-semibold text-navy-900">Découvrez les alentours de votre hôtel</h2>
                <p class="mt-1 text-muted">Voici nos recommandations pour profiter de votre séjour à {{ $hotel->localisation }}.</p>
            </div>

            @foreach(['restaurant', 'cinema', 'supermarche'] as $type)
                @if($places->has($type))
                    <div class="reveal mb-10">
                        {{-- Titre de catégorie --}}
                        <div class="mb-5 flex items-center gap-3">
                            <span class="grid h-10 w-10 place-items-center rounded-xl bg-gradient-to-br {{ $typeColors[$type] }} text-lg text-white shadow-md">
                                {{ $typeIcons[$type] }}
                            </span>
                            <h3 class="text-xl font-semibold text-navy-900">{{ $typeLabels[$type] }}</h3>
                            <span class="rounded-full bg-navy-900/5 px-2.5 py-0.5 text-xs font-medium text-navy-700">
                                {{ $places[$type]->count() }}
                            </span>
                        </div>

                        {{-- Grille de cartes --}}
                        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach($places[$type] as $place)
                                <article class="card group overflow-hidden transition hover:shadow-lift" id="place-card-{{ $place->id }}">
                                    {{-- Image --}}
                                    <div class="relative overflow-hidden">
                                        <img src="{{ $place->image ?: ($typeDefaultImages[$type] ?? '') }}"
                                             alt="{{ $place->nom }}"
                                             class="h-44 w-full object-cover transition duration-500 group-hover:scale-105"
                                             loading="lazy">
                                        <span class="absolute left-3 top-3 rounded-full px-3 py-1 text-xs font-semibold {{ $typeBadgeColors[$type] }} backdrop-blur-sm bg-white/90 shadow-sm">
                                            {{ $typeIcons[$type] }} {{ $typeLabels[$type] }}
                                        </span>
                                    </div>

                                    {{-- Contenu --}}
                                    <div class="p-5">
                                        <h4 class="text-lg font-semibold text-navy-900 group-hover:text-gold-600 transition">
                                            {{ $place->nom }}
                                        </h4>

                                        @if($place->description)
                                            <p class="mt-2 text-sm text-muted line-clamp-2">
                                                {{ $place->description }}
                                            </p>
                                        @endif

                                        <div class="mt-3 flex items-center gap-1.5 text-sm text-muted">
                                            <svg class="h-3.5 w-3.5 shrink-0 text-gold-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                                <path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="3"/>
                                            </svg>
                                            {{ $place->adresse }}
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        @endif

        {{-- Lien retour --}}
        <div class="reveal mt-6 text-center">
            <a href="{{ route('bookings.my') }}" class="btn-outline">← Retour à mes réservations</a>
        </div>
    @endif
</main>
@endsection
