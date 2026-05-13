@extends('layouts.app')

@section('content')
<main class="mx-auto max-w-xl px-6 py-10">
    <h1 class="mb-6 text-3xl font-semibold">Créer un hôtel</h1>

    <form method="POST" action="{{ route('hotels.store') }}" class="space-y-4 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-100">
        @csrf
        <input type="text" name="nom" placeholder="Nom" class="w-full rounded-xl border border-slate-200 p-3">
        <input type="text" name="localisation" placeholder="Ville" class="w-full rounded-xl border border-slate-200 p-3">
        <input type="text" name="pays" placeholder="Pays" class="w-full rounded-xl border border-slate-200 p-3">
        <button type="submit" class="w-full rounded-xl bg-blue-600 px-5 py-3 font-medium text-white">Créer</button>
    </form>
</main>
@endsection
