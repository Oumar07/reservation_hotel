@extends('layouts.admin')

@section('title', 'Modifier un lieu — StayHub Admin')

@section('content')
<div class="page-container section-padding">
    <div class="reveal mb-10">
        <p class="text-sm font-semibold uppercase tracking-widest text-gold-600">Administration</p>
        <h1 class="section-title mt-2">Modifier le lieu</h1>
        <p class="section-subtitle">{{ $place->nom }}</p>
    </div>

    @if($errors->any())
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-red-700">
            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mx-auto max-w-2xl rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-100 sm:p-8">
        <form method="POST" action="{{ route('places.update', $place->id) }}" class="space-y-5" id="edit-place-form">
            @csrf
            @method('PUT')

            <label class="block">
                <span class="mb-2 block text-sm font-medium text-slate-900">Hôtel associé</span>
                <select name="hotel_id" required class="modal-input" id="edit-place-hotel">
                    <option value="">Choisir un hôtel</option>
                    @foreach($hotels as $hotel)
                        <option value="{{ $hotel->id }}" {{ (old('hotel_id', $place->hotel_id) == $hotel->id) ? 'selected' : '' }}>
                            {{ $hotel->nom }} — {{ $hotel->localisation }}
                        </option>
                    @endforeach
                </select>
            </label>

            <label class="block">
                <span class="mb-2 block text-sm font-medium text-slate-900">Nom du lieu</span>
                <input type="text" name="nom" value="{{ old('nom', $place->nom) }}" required class="modal-input" id="edit-place-nom">
            </label>

            <label class="block">
                <span class="mb-2 block text-sm font-medium text-slate-900">Catégorie</span>
                <select name="type" required class="modal-input" id="edit-place-type">
                    <option value="restaurant" {{ old('type', $place->type) == 'restaurant' ? 'selected' : '' }}>🍴 Restaurant</option>
                    <option value="cinema" {{ old('type', $place->type) == 'cinema' ? 'selected' : '' }}>🎬 Cinéma</option>
                    <option value="supermarche" {{ old('type', $place->type) == 'supermarche' ? 'selected' : '' }}>🛒 Supermarché</option>
                </select>
            </label>

            <label class="block">
                <span class="mb-2 block text-sm font-medium text-slate-900">Description</span>
                <textarea name="description" rows="3" class="modal-input resize-none" id="edit-place-description">{{ old('description', $place->description) }}</textarea>
            </label>

            <label class="block">
                <span class="mb-2 block text-sm font-medium text-slate-900">Adresse</span>
                <input type="text" name="adresse" value="{{ old('adresse', $place->adresse) }}" required class="modal-input" id="edit-place-adresse">
            </label>

            <label class="block">
                <span class="mb-2 block text-sm font-medium text-slate-900">URL de l'image</span>
                <input type="url" name="image" value="{{ old('image', $place->image) }}" placeholder="https://example.com/photo.jpg" class="modal-input" id="edit-place-image">
            </label>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary" id="edit-place-submit">Enregistrer les modifications</button>
                <a href="{{ route('places.index') }}" class="btn-outline">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
