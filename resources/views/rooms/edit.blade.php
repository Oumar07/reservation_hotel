@extends('layouts.app')

@section('content')
<main class="mx-auto max-w-xl px-6 py-10">
    <h1 class="mb-6 text-3xl font-semibold">Modifier la chambre</h1>

    <form method="POST" action="{{ route('rooms.update', $room->id) }}" class="space-y-4 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-100">
        @csrf
        @method('PUT')

        <select name="hotel_id" class="w-full rounded-xl border border-slate-200 p-3">
            @foreach($hotels as $hotel)
                <option value="{{ $hotel->id }}" {{ $room->hotel_id == $hotel->id ? 'selected' : '' }}>
                    {{ $hotel->nom }}
                </option>
            @endforeach
        </select>

        <input type="text" name="type" value="{{ $room->type }}" class="w-full rounded-xl border border-slate-200 p-3">
        <input type="number" name="prix" value="{{ $room->prix }}" class="w-full rounded-xl border border-slate-200 p-3">
        <input type="number" name="capacite" value="{{ $room->capacite }}" class="w-full rounded-xl border border-slate-200 p-3">

        <button class="w-full rounded-xl bg-blue-600 px-5 py-3 font-medium text-white">Enregistrer les modifications</button>
    </form>
</main>
@endsection
