<h1>Liste des chambres</h1>

<a href="{{ route('rooms.create') }}">Ajouter</a>

@foreach($rooms as $room)
    <p>
        {{ $room->type }} - {{ $room->prix }} FCFA  
        (Hotel: {{ $room->hotel->nom }})
    </p>

    <a href="{{ route('rooms.edit', $room->id) }}">Modifier</a>

    <form method="POST" action="{{ route('rooms.destroy', $room->id) }}">
        @csrf
        @method('DELETE')
        <button>Supprimer</button>
    </form>
@endforeach