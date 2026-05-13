@extends('layouts.app')

@section('content')
<main class="mx-auto max-w-xl px-6 py-10">
    <h1 class="mb-6 text-3xl font-semibold">Réserver une chambre</h1>

    <div class="mb-6 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-100">
        <p>Type : {{ ['simple' => 'Simple', 'double' => 'Double', 'suite' => 'Suite'][$room->type] ?? ucfirst($room->type) }}</p>
        <p>Prix : {{ number_format($room->prix, 0) }} CFA</p>
    </div>

    <form method="POST" action="{{ route('bookings.store') }}" class="space-y-4 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-100">
        @csrf
        <input type="hidden" name="room_id" value="{{ $room->id }}">

        <label class="block">
            <span class="mb-2 block font-medium">Date d'arrivée :</span>
            <input type="date" name="date_arrivee" required class="w-full rounded-xl border border-slate-200 p-3">
        </label>

        <label class="block">
            <span class="mb-2 block font-medium">Date de départ :</span>
            <input type="date" name="date_depart" required class="w-full rounded-xl border border-slate-200 p-3">
        </label>

        <button type="submit" class="w-full rounded-xl bg-blue-600 px-5 py-3 font-medium text-white">Réserver</button>
    </form>
</main>
@endsection
