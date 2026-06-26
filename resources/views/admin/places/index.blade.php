@extends('layouts.admin')

@section('title', 'Gestion des lieux — StayHub Admin')

@section('content')
<div class="page-container section-padding">
    <div class="reveal mb-10">
        <p class="text-sm font-semibold uppercase tracking-widest text-gold-600">Administration</p>
        <h1 class="section-title mt-2">Gestion des lieux</h1>
        <p class="section-subtitle">Gérez les recommandations autour de vos hôtels</p>
    </div>

    {{-- Messages flash --}}
    @if(session('success'))
        <div class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-800">
            <svg class="h-5 w-5 shrink-0 text-emerald-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m9 11 3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            <p class="text-sm font-medium">{{ session('success') }}</p>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-red-700">
            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- En-tête + bouton ajouter --}}
    <div class="mb-6 flex items-center justify-between gap-4">
        <p class="text-sm text-slate-500">{{ $places->count() }} lieu{{ $places->count() > 1 ? 'x' : '' }} enregistré{{ $places->count() > 1 ? 's' : '' }}</p>
        <button type="button" data-open-place-modal class="btn-primary" id="add-place-btn">+ Ajouter un lieu</button>
    </div>

    {{-- Liste des lieux --}}
    <div class="space-y-4">
        @forelse($places as $place)
            @php
                $typeLabels = ['restaurant' => 'Restaurant', 'cinema' => 'Cinéma', 'supermarche' => 'Supermarché'];
                $typeColors = [
                    'restaurant'  => 'bg-orange-50 text-orange-700',
                    'cinema'      => 'bg-purple-50 text-purple-700',
                    'supermarche' => 'bg-teal-50 text-teal-700',
                ];
                $typeIcons = ['restaurant' => '🍴', 'cinema' => '🎬', 'supermarche' => '🛒'];
            @endphp
            <div class="flex flex-col gap-5 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-100 md:flex-row md:items-center md:justify-between" id="place-{{ $place->id }}">
                <div class="flex items-center gap-5">
                    <img src="{{ $place->image ?: 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=240&q=80' }}"
                         alt="{{ $place->nom }}"
                         class="h-20 w-28 rounded-xl object-cover shrink-0">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-lg">{{ $typeIcons[$place->type] ?? '📍' }}</span>
                            <h3 class="text-lg font-semibold text-slate-950">{{ $place->nom }}</h3>
                        </div>
                        <div class="flex flex-wrap items-center gap-2 text-sm">
                            <span class="rounded-full px-2.5 py-0.5 text-xs font-medium {{ $typeColors[$place->type] ?? 'bg-slate-100 text-slate-600' }}">
                                {{ $typeLabels[$place->type] ?? $place->type }}
                            </span>
                            <span class="text-slate-400">·</span>
                            <span class="text-slate-500">{{ $place->hotel->nom ?? 'Hôtel supprimé' }}</span>
                        </div>
                        <p class="mt-1 flex items-center gap-1 text-sm text-slate-500">
                            <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                            {{ $place->adresse }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-4 md:justify-end shrink-0">
                    <a href="{{ route('places.edit', $place->id) }}" class="text-slate-900 transition hover:text-blue-600" aria-label="Modifier {{ $place->nom }}">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 20h9" /><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z" /></svg>
                    </a>
                    <form action="{{ route('places.destroy', $place->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-400 transition hover:text-red-600" aria-label="Supprimer {{ $place->nom }}" onclick="return confirm('Supprimer ce lieu ?')">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 6h18" /><path d="M8 6V4h8v2" /><path d="M19 6l-1 15H6L5 6" /><path d="M10 11v6M14 11v6" /></svg>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="rounded-2xl bg-white p-8 text-center shadow-sm ring-1 ring-slate-100">
                <span class="text-4xl">📍</span>
                <p class="mt-3 font-medium text-slate-700">Aucun lieu pour le moment</p>
                <p class="mt-1 text-sm text-slate-500">Ajoutez des restaurants, cinémas et supermarchés autour de vos hôtels.</p>
            </div>
        @endforelse
    </div>
</div>

{{-- ─── Modale d'ajout de lieu ──────────────────────────────────────────────── --}}
<div id="place-modal" class="modal-backdrop hidden place-items-start overflow-y-auto sm:place-items-center">
    <div data-place-modal-card class="modal-panel my-auto">
        <div class="mb-5 flex items-center justify-between">
            <h2 class="text-2xl font-semibold text-slate-950">Ajouter un lieu</h2>
            <button type="button" data-close-place-modal class="text-3xl font-light leading-none text-slate-500 hover:text-slate-900" aria-label="Fermer">&times;</button>
        </div>

        <form method="POST" action="{{ route('places.store') }}" class="space-y-4" id="place-form">
            @csrf

            <label class="block">
                <span class="mb-2 block text-sm font-medium text-slate-900">Hôtel associé</span>
                <select name="hotel_id" required class="modal-input" id="place-hotel-select">
                    <option value="">Choisir un hôtel</option>
                    @foreach($hotels as $hotel)
                        <option value="{{ $hotel->id }}" {{ old('hotel_id') == $hotel->id ? 'selected' : '' }}>
                            {{ $hotel->nom }} — {{ $hotel->localisation }}
                        </option>
                    @endforeach
                </select>
            </label>

            <label class="block">
                <span class="mb-2 block text-sm font-medium text-slate-900">Nom du lieu</span>
                <input type="text" name="nom" placeholder="Ex : Restaurant Le Patio" required class="modal-input" value="{{ old('nom') }}" id="place-nom-input">
            </label>

            <label class="block">
                <span class="mb-2 block text-sm font-medium text-slate-900">Catégorie</span>
                <select name="type" required class="modal-input" id="place-type-select">
                    <option value="restaurant" {{ old('type') == 'restaurant' ? 'selected' : '' }}>🍴 Restaurant</option>
                    <option value="cinema" {{ old('type') == 'cinema' ? 'selected' : '' }}>🎬 Cinéma</option>
                    <option value="supermarche" {{ old('type') == 'supermarche' ? 'selected' : '' }}>🛒 Supermarché</option>
                </select>
            </label>

            <label class="block">
                <span class="mb-2 block text-sm font-medium text-slate-900">Description</span>
                <textarea name="description" rows="2" placeholder="Courte description du lieu" class="modal-input resize-none" id="place-description-input">{{ old('description') }}</textarea>
            </label>

            <label class="block">
                <span class="mb-2 block text-sm font-medium text-slate-900">Adresse</span>
                <input type="text" name="adresse" placeholder="Ex : ACI 2000, Bamako" required class="modal-input" value="{{ old('adresse') }}" id="place-adresse-input">
            </label>

            <label class="block">
                <span class="mb-2 block text-sm font-medium text-slate-900">URL de l'image</span>
                <input type="url" name="image" placeholder="https://example.com/photo.jpg" class="modal-input" value="{{ old('image') }}" id="place-image-input">
            </label>

            <button type="submit" class="btn-primary w-full" id="place-submit-btn">Enregistrer le lieu</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('place-modal');
    const modalCard = document.querySelector('[data-place-modal-card]');

    const openModal = () => {
        modal.classList.remove('hidden');
        modal.classList.add('grid');
    };

    const closeModal = () => {
        modal.classList.add('hidden');
        modal.classList.remove('grid');
    };

    document.querySelectorAll('[data-open-place-modal]').forEach(btn => {
        btn.addEventListener('click', openModal);
    });

    document.querySelectorAll('[data-close-place-modal]').forEach(btn => {
        btn.addEventListener('click', closeModal);
    });

    modal.addEventListener('click', closeModal);
    modalCard.addEventListener('click', e => e.stopPropagation());

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeModal();
    });
});
</script>
@endpush
@endsection
