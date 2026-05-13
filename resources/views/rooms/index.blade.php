@extends('layouts.app')

@section('content')
<main class="mx-auto max-w-5xl px-6 py-10">
    <div class="mb-8 flex items-center justify-between">
        <h1 class="text-3xl font-semibold">Liste des chambres</h1>
        <a href="{{ route('rooms.create') }}" class="rounded-xl bg-blue-600 px-5 py-3 font-medium text-white">Ajouter une chambre</a>
    </div>

    <div class="space-y-4">
        @foreach($rooms as $room)
            <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-100">
                <p class="font-medium">
                    Chambre {{ ['simple' => 'Simple', 'double' => 'Double', 'suite' => 'Suite'][$room->type] ?? ucfirst($room->type) }}
                    - {{ number_format($room->prix, 0) }} CFA
                    (Hôtel : {{ $room->hotel->nom }})
                </p>

                <div class="mt-4 flex flex-wrap gap-3">
                    <a href="{{ route('rooms.edit', $room->id) }}" class="rounded-lg border border-slate-200 px-4 py-2">Modifier</a>

                    <form method="POST" action="{{ route('rooms.destroy', $room->id) }}">
                        @csrf
                        @method('DELETE')
                        <button class="rounded-lg border border-red-200 px-4 py-2 text-red-600">Supprimer</button>
                    </form>

                    <a href="{{ route('bookings.create', $room->id) }}" class="rounded-lg bg-blue-600 px-4 py-2 text-white">Réserver</a>
                </div>
            </div>
        @endforeach
    </div>
</main>
@endsection
