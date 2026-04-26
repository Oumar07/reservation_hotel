@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">Hotels</h1>

<div class="grid grid-cols-3 gap-4">
@foreach($hotels as $hotel)
    <div class="bg-white p-4 rounded shadow">
        <h2 class="text-lg font-bold">{{ $hotel->nom }}</h2>
        <p>{{ $hotel->localisation }}</p>

        <a href="#" class="text-blue-500">Voir</a>
    </div>
@endforeach
</div>

@endsection