<form method="POST" action="{{ route('rooms.store') }}">
    @csrf

    <select name="hotel_id">
        @foreach($hotels as $hotel)
            <option value="{{ $hotel->id }}">
                {{ $hotel->nom }}
            </option>
        @endforeach
    </select>

    <input type="text" name="type" placeholder="Type">
    <input type="number" name="prix" placeholder="Prix">
    <input type="number" name="capacite" placeholder="Capacité">

    <button type="submit">Créer</button>
</form>