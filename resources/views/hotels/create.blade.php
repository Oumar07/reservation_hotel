<form method="POST" action="{{ route('hotels.store') }}">
    @csrf
    <input type="text" name="nom" placeholder="Nom">
    <input type="text" name="localisation" placeholder="Localisation">
    <input type="text" name="pays" placeholder="Pays">
    <button type="submit">Créer</button>
</form>