@extends('layouts.app')

@section('content')
<main class="mx-auto max-w-6xl px-6 py-16">
    <h1 class="mb-10 text-4xl font-semibold tracking-normal">Finaliser votre réservation</h1>

    <div class="grid gap-10 lg:grid-cols-[1.3fr_0.8fr]">
        <section>
            <div class="rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-100">
                <div class="mb-8 flex items-center gap-3">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="5" width="20" height="14" rx="2" /><path d="M2 10h20" /></svg>
                    <h2 class="text-2xl font-semibold">Détails du paiement</h2>
                </div>

                <form method="POST" action="{{ route('bookings.store') }}" id="payment-form">
                    @csrf
                    <input type="hidden" name="room_id" value="{{ $room->id }}">
                    <input type="hidden" name="date_arrivee" value="{{ $data['date_arrivee'] }}">
                    <input type="hidden" name="date_depart" value="{{ $data['date_depart'] }}">
                    <input type="hidden" name="email" value="{{ $data['email'] }}">
                    <input type="hidden" name="password" value="{{ $data['password'] }}">

                    <label class="block">
                        <span class="mb-2 block font-medium">Numéro de carte</span>
                        <input type="text" value="1234 5678 9012 3456" class="payment-input">
                    </label>

                    <div class="mt-6 grid gap-5 sm:grid-cols-2">
                        <label class="block">
                            <span class="mb-2 block font-medium">Date d'expiration</span>
                            <input type="text" value="12/29" class="payment-input">
                        </label>
                        <label class="block">
                            <span class="mb-2 block font-medium">CVV</span>
                            <input type="text" value="123" class="payment-input">
                        </label>
                    </div>

                    <p class="mt-6 flex items-center gap-2 text-slate-500">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="11" width="18" height="10" rx="2" /><path d="M7 11V7a5 5 0 0 1 10 0v4" /></svg>
                        Vos informations de paiement sont sécurisées et chiffrées
                    </p>
                </form>
            </div>

            <button form="payment-form" class="mt-8 w-full rounded-2xl bg-blue-600 px-6 py-5 text-lg font-medium text-white transition hover:bg-blue-700">
                Confirmer et payer {{ number_format($total, 0) }} CFA
            </button>
        </section>

        <aside class="h-max rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-100">
            <h2 class="text-2xl font-semibold">Résumé de la réservation</h2>
            <img src="{{ $room->hotel->image ?: 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=900&q=80' }}"
                 alt="{{ $room->hotel->nom }}"
                 class="mt-6 h-48 w-full rounded-2xl object-cover">

            <h3 class="mt-6 text-2xl font-semibold">{{ $room->hotel->nom }}</h3>
            <p class="text-slate-500">{{ $room->hotel->localisation }}, {{ $room->hotel->pays }}</p>

            <div class="mt-7 divide-y divide-slate-100 border-y border-slate-100 py-4">
                <div class="summary-row"><span>Chambre</span><strong>Chambre {{ ['simple' => 'Simple', 'double' => 'Double', 'suite' => 'Suite'][$room->type] ?? ucfirst($room->type) }}</strong></div>
                <div class="summary-row"><span>Arrivée</span><strong>{{ $data['date_arrivee'] }}</strong></div>
                <div class="summary-row"><span>Départ</span><strong>{{ $data['date_depart'] }}</strong></div>
                <div class="summary-row"><span>Nuits</span><strong>{{ $nights }}</strong></div>
            </div>

            <div class="mt-6 flex items-center justify-between">
                <span class="text-2xl font-semibold">Total</span>
                <span class="text-3xl font-semibold text-blue-600">{{ number_format($total, 0) }} CFA</span>
            </div>
        </aside>
    </div>
</main>

<style>
    .payment-input {
        width: 100%;
        border-radius: 0.9rem;
        border: 1px solid rgb(226 232 240);
        background: rgb(248 250 252);
        padding: 1rem;
        color: rgb(15 23 42);
        outline: none;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        gap: 1.5rem;
        padding: 0.75rem 0;
        color: rgb(100 116 139);
    }

    .summary-row strong {
        color: rgb(15 23 42);
        font-weight: 500;
        text-align: right;
    }
</style>
@endsection
