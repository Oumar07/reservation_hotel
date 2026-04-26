<form method="POST" action="{{ route('hotels.update', $hotel->id) }}">
    @csrf
    @method('PUT')

    <input type="text" name="nom" value="{{ $hotel->nom }}">
    <input type="text" name="localisation" value="{{ $hotel->localisation }}">
    <input type="text" name="pays" value="{{ $hotel->pays }}">

    <button>Modifier</button>
</form>