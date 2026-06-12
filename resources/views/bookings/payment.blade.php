@extends('layouts.app')

@section('title', 'Paiement — StayHub')

@section('content')
<main class="page-container section-padding">
    <div class="booking-steps reveal">
        <div class="booking-step is-done"><span class="booking-step-dot">✓</span> Chambre</div>
        <span class="hidden text-muted sm:inline" aria-hidden="true">—</span>
        <div class="booking-step is-done"><span class="booking-step-dot">✓</span> Compte</div>
        <span class="hidden text-muted sm:inline" aria-hidden="true">—</span>
        <div class="booking-step is-active"><span class="booking-step-dot">3</span> Paiement</div>
    </div>

    <h1 class="reveal section-title">Finaliser votre réservation</h1>
    <p class="reveal section-subtitle">Dernière étape avant votre séjour d'exception.</p>

    <div class="mt-10 grid gap-10 lg:grid-cols-[1.3fr_0.85fr]">
        <section class="reveal">
            <div class="card p-6 sm:p-8">
                <div class="mb-8 flex items-center gap-3">
                    <span class="grid h-12 w-12 place-items-center rounded-xl bg-navy-900/5 text-navy-700">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="2" y="5" width="20" height="14" rx="2" /><path d="M2 10h20" /></svg>
                    </span>
                    <h2 class="text-xl font-semibold text-navy-900">Détails du paiement</h2>
                </div>

                <form method="POST" action="{{ route('bookings.store') }}" id="payment-form" class="space-y-5">
                    @csrf
                    <input type="hidden" name="room_id" value="{{ $room->id }}">
                    <input type="hidden" name="date_arrivee" value="{{ $data['date_arrivee'] }}">
                    <input type="hidden" name="date_depart" value="{{ $data['date_depart'] }}">

                    <label class="block">
                        <span class="form-label">Numéro de carte</span>
                        <input type="text" value="1234 5678 9012 3456" class="form-input-filled" aria-label="Numéro de carte">
                    </label>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <label class="block">
                            <span class="form-label">Date d'expiration</span>
                            <input type="text" value="12/29" class="form-input-filled" aria-label="Expiration">
                        </label>
                        <label class="block">
                            <span class="form-label">CVV</span>
                            <input type="text" value="123" class="form-input-filled" aria-label="CVV">
                        </label>
                    </div>

                    <p class="flex items-center gap-2 text-sm text-muted">
                        <svg class="h-4 w-4 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3" y="11" width="18" height="10" rx="2" /><path d="M7 11V7a5 5 0 0 1 10 0v4" /></svg>
                        Vos informations de paiement sont sécurisées et chiffrées
                    </p>
                </form>
            </div>

            <button form="payment-form" class="btn-gold mt-6 w-full py-4 text-base sm:text-lg">
                Confirmer et payer {{ number_format($total, 0, ',', ' ') }} CFA
            </button>
        </section>

        <aside class="reveal lg:sticky lg:top-28 lg:self-start">
            <div class="glass-card p-6 sm:p-8">
                <h2 class="font-display text-2xl font-semibold text-navy-900">Résumé</h2>
                <img src="{{ $room->hotel->image ?: 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=900&q=80' }}"
                     alt="{{ $room->hotel->nom }}"
                     class="mt-6 h-48 w-full rounded-2xl object-cover"
                     loading="lazy">

                <h3 class="mt-6 text-xl font-semibold text-navy-900">{{ $room->hotel->nom }}</h3>
                <p class="text-sm text-muted">{{ $room->hotel->localisation }}, {{ $room->hotel->pays }}</p>

                <dl class="mt-6 divide-y divide-navy-900/5 border-y border-navy-900/5 text-sm">
                    <div class="flex justify-between gap-4 py-3"><dt class="text-muted">Chambre</dt><dd class="font-medium text-navy-900">Chambre {{ ['simple' => 'Simple', 'double' => 'Double', 'suite' => 'Suite'][$room->type] ?? ucfirst($room->type) }}</dd></div>
                    <div class="flex justify-between gap-4 py-3"><dt class="text-muted">Arrivée</dt><dd class="font-medium text-navy-900">{{ $data['date_arrivee'] }}</dd></div>
                    <div class="flex justify-between gap-4 py-3"><dt class="text-muted">Départ</dt><dd class="font-medium text-navy-900">{{ $data['date_depart'] }}</dd></div>
                    <div class="flex justify-between gap-4 py-3"><dt class="text-muted">Nuits</dt><dd class="font-medium text-navy-900">{{ $nights }}</dd></div>
                </dl>

                <div class="mt-6 flex items-center justify-between border-t border-navy-900/10 pt-6">
                    <span class="text-lg font-semibold text-navy-900">Total</span>
                    <span class="font-display text-3xl font-semibold text-gold-600">{{ number_format($total, 0, ',', ' ') }} CFA</span>
                </div>
            </div>
        </aside>
    </div>
</main>
@endsection
