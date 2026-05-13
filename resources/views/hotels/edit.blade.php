@extends('layouts.app')

@section('content')
<main class="mx-auto max-w-xl px-6 py-10">
    <h1 class="mb-6 text-3xl font-semibold">Modifier l'hôtel</h1>

    <form method="POST" action="{{ route('hotels.update', $hotel->id) }}" class="space-y-4 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-100">
        @csrf
        @method('PUT')

        <input type="text" name="nom" value="{{ $hotel->nom }}" class="w-full rounded-xl border border-slate-200 p-3">
        <input type="text" name="localisation" value="{{ $hotel->localisation }}" class="w-full rounded-xl border border-slate-200 p-3">
        <input type="text" name="pays" value="{{ $hotel->pays }}" class="w-full rounded-xl border border-slate-200 p-3">

        <button class="w-full rounded-xl bg-blue-600 px-5 py-3 font-medium text-white">Enregistrer les modifications</button>
    </form>
</main>
@endsection
