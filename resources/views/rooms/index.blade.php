@extends('layouts.app')

@section('title', 'Chambres — StayHub')

@section('content')
<main class="page-container section-padding">
    <div class="reveal mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="section-title">Liste des chambres</h1>
            <p class="section-subtitle">Gérez les chambres de vos établissements.</p>
        </div>
        <a href="{{ route('rooms.create') }}" class="btn-primary shrink-0">Ajouter une chambre</a>
    </div>

    <div class="space-y-4">
        @foreach($rooms as $room)
            <article class="card reveal p-5 sm:p-6">
                <p class="font-semibold text-navy-900">
                    Chambre {{ ['simple' => 'Simple', 'double' => 'Double', 'suite' => 'Suite'][$room->type] ?? ucfirst($room->type) }}
                    <span class="font-normal text-muted">—</span>
                    {{ number_format($room->prix, 0, ',', ' ') }} CFA
                </p>
                <p class="mt-1 text-sm text-muted">Hôtel : {{ $room->hotel->nom }}</p>

                <div class="mt-5 flex flex-wrap gap-3 border-t border-navy-900/5 pt-5">
                    <a href="{{ route('rooms.edit', $room->id) }}" class="btn-outline text-sm">Modifier</a>

                    <form method="POST" action="{{ route('rooms.destroy', $room->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger text-sm">Supprimer</button>
                    </form>

                    <a href="{{ route('bookings.create', $room->id) }}" class="btn-primary text-sm">Réserver</a>
                </div>
            </article>
        @endforeach
    </div>
</main>
@endsection
