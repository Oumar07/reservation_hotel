<form method="POST" action="{{ route('rooms.update', $room->id) }}">
    @csrf
    @method('PUT')

    <select name="hotel_id">
        @foreach($hotels as $hotel)
            <option value="{{ $hotel->id }}"
                {{ $room->hotel_id == $hotel->id ? 'selected' : '' }}>
                {{ $hotel->nom }}
            </option>
        @endforeach
    </select>

    <input type="text" name="type" value="{{ $room->type }}">
    <input type="number" name="prix" value="{{ $room->prix }}">
    <input type="number" name="capacite" value="{{ $room->capacite }}">

    <button>Modifier</button>
</form>