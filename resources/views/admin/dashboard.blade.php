@extends('layouts.admin')

@section('content')
@php
    $confirmedCount = $bookings->where('statut', 'confirme')->count();
    $canceledCount = $bookings->where('statut', 'annule')->count();
    $pendingCount = $bookings->where('statut', 'en_attente')->count();

    $statusStyles = [
        'confirme' => 'bg-green-50 text-green-600',
        'annule' => 'bg-red-50 text-red-500',
        'en_attente' => 'bg-blue-50 text-blue-600',
    ];

    $statusLabels = [
        'confirme' => 'confirmée',
        'annule' => 'annulée',
        'en_attente' => 'en attente',
    ];
@endphp

<div class="mx-auto max-w-[1540px] px-6 py-10 sm:px-10 lg:px-16">
    <div class="mb-10">
        <h1 class="text-4xl font-semibold tracking-normal text-slate-950">Tableau de bord admin</h1>
        <p class="mt-3 text-lg font-normal text-slate-500">Gérez votre activité hôtelière</p>
    </div>

    <div class="mb-10 grid gap-5 md:grid-cols-2 xl:grid-cols-4">
        <div class="stat-card">
            <span class="stat-icon text-emerald-500">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M12 2v20" />
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7H14a3.5 3.5 0 0 1 0 7H6" />
                </svg>
            </span>
            <div>
                <p class="text-sm font-normal text-slate-500">Revenu total</p>
                <h2 class="text-2xl font-semibold text-slate-950">{{ number_format($revenue, 0) }} CFA</h2>
            </div>
        </div>

        <div class="stat-card">
            <span class="stat-icon text-blue-500">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M8 2v4M16 2v4M3 10h18" />
                    <rect x="3" y="4" width="18" height="18" rx="2" />
                    <path d="M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01" />
                </svg>
            </span>
            <div>
                <p class="text-sm font-normal text-slate-500">Réservations totales</p>
                <h2 class="text-2xl font-semibold text-slate-950">{{ $bookings->count() }}</h2>
            </div>
        </div>

        <div class="stat-card">
            <span class="stat-icon text-amber-500">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M3 17l6-6 4 4 7-7" />
                    <path d="M14 8h6v6" />
                </svg>
            </span>
            <div>
                <p class="text-sm font-normal text-slate-500">Réservations actives</p>
                <h2 class="text-2xl font-semibold text-slate-950">{{ $activeBookings }}</h2>
            </div>
        </div>

        <div class="stat-card">
            <span class="stat-icon text-indigo-500">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M4 21V5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v16" />
                    <path d="M9 21v-6h6v6" />
                    <path d="M8 7h.01M12 7h.01M16 7h.01M8 11h.01M12 11h.01M16 11h.01" />
                </svg>
            </span>
            <div>
                <p class="text-sm font-normal text-slate-500">Hôtels au total</p>
                <h2 class="text-2xl font-semibold text-slate-950">{{ $hotels->count() }}</h2>
            </div>
        </div>
    </div>

    <div class="mb-10 flex flex-wrap gap-3 rounded-2xl bg-white/60 p-3 shadow-sm ring-1 ring-slate-100">
        <button type="button" class="tab-button is-active" data-tab="hotels">
            <svg class="tab-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 21V5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v16" /><path d="M9 21v-6h6v6" /><path d="M8 7h.01M12 7h.01M16 7h.01M8 11h.01M12 11h.01M16 11h.01" /></svg>
            Hôtels
        </button>
        <button type="button" class="tab-button" data-tab="rooms">
            <svg class="tab-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 7v11M21 18v-6a3 3 0 0 0-3-3H3" /><path d="M7 9V6a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v3" /></svg>
            Chambres
        </button>
        <button type="button" class="tab-button" data-tab="bookings">
            <svg class="tab-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8 2v4M16 2v4M3 10h18" /><rect x="3" y="4" width="18" height="18" rx="2" /></svg>
            Réservations
        </button>
        <button type="button" class="tab-button" data-tab="revenue">
            <svg class="tab-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 2v20" /><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7H14a3.5 3.5 0 0 1 0 7H6" /></svg>
            Revenus
        </button>
    </div>

    <section data-panel="hotels">
        <div class="mb-6 flex items-center justify-between gap-4">
            <h2 class="text-2xl font-semibold text-slate-950">Gestion des hôtels</h2>
            <button type="button" data-open-modal class="rounded-xl bg-blue-600 px-5 py-3 font-medium text-white shadow-sm transition hover:bg-blue-700">+ Ajouter un hôtel</button>
        </div>

        <div class="space-y-5">
            @forelse($hotels as $hotel)
                @php
                    $priceFrom = $hotel->rooms->min('prix');
                @endphp
                <div class="flex flex-col gap-5 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-100 md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center gap-5">
                        <img src="{{ $hotel->image ?: 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=240&q=80' }}"
                             alt="{{ $hotel->nom }}"
                             class="h-24 w-32 rounded-xl object-cover">
                        <div>
                            <h3 class="text-xl font-semibold text-slate-950">{{ $hotel->nom }}</h3>
                            <p class="text-slate-500">{{ $hotel->localisation }}, {{ $hotel->pays }} &middot; {{ $hotel->rooms->count() }} chambres</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between gap-7 md:justify-end">
                        <div class="text-right">
                            <p class="text-xl font-semibold text-slate-950">{{ $priceFrom ? number_format($priceFrom, 0) : '0' }} CFA</p>
                            <p class="text-sm text-slate-500">à partir de / nuit</p>
                        </div>
                        <a href="/hotels/{{ $hotel->id }}/edit" class="text-slate-900 transition hover:text-blue-600" aria-label="Edit {{ $hotel->nom }}">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 20h9" /><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z" /></svg>
                        </a>
                        <form action="/hotels/{{ $hotel->id }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-400 transition hover:text-red-600" aria-label="Delete {{ $hotel->nom }}">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 6h18" /><path d="M8 6V4h8v2" /><path d="M19 6l-1 15H6L5 6" /><path d="M10 11v6M14 11v6" /></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="rounded-2xl bg-white p-8 text-slate-500 shadow-sm ring-1 ring-slate-100">Aucun hôtel pour le moment.</div>
            @endforelse
        </div>
    </section>

    <section data-panel="rooms" class="hidden">
        <div class="mb-6 flex items-center justify-between gap-4">
            <h2 class="text-2xl font-semibold text-slate-950">Toutes les chambres</h2>
            <button type="button" data-open-room-modal class="rounded-xl bg-blue-600 px-5 py-3 font-medium text-white shadow-sm transition hover:bg-blue-700">+ Ajouter une chambre</button>
        </div>
        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @forelse($rooms as $room)
                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-100">
                    <img src="{{ $room->image ?: 'https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=500&q=80' }}"
                         alt="{{ $room->type }}"
                         class="mb-4 h-40 w-full rounded-xl object-cover">
                    <p class="text-sm font-medium uppercase text-blue-600">{{ $room->hotel->nom ?? 'Hôtel' }}</p>
                    <h3 class="mt-1 text-xl font-semibold capitalize text-slate-950">{{ $room->type }}</h3>
                    <div class="mt-4 flex items-end justify-between text-slate-500">
                        <span>{{ $room->capacite }} personnes</span>
                        <span class="text-xl font-semibold text-slate-950">{{ number_format($room->prix, 0) }} CFA</span>
                    </div>
                    <div class="mt-5 flex items-center gap-4 border-t border-slate-100 pt-4">
                        <a href="/rooms/{{ $room->id }}/edit" class="text-sm font-medium text-slate-700 transition hover:text-blue-600">Modifier</a>
                        <form action="/rooms/{{ $room->id }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm font-medium text-red-500 transition hover:text-red-700">Supprimer</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="rounded-2xl bg-white p-8 text-slate-500 shadow-sm ring-1 ring-slate-100">Aucune chambre pour le moment.</div>
            @endforelse
        </div>
    </section>

    <section data-panel="bookings" class="hidden">
        <h2 class="mb-6 text-2xl font-semibold text-slate-950">Toutes les réservations</h2>
        <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-100">
            <table class="w-full min-w-[760px] text-left">
                <thead class="border-b border-slate-100 text-sm text-slate-500">
                    <tr>
                        <th class="px-6 py-4 font-medium">Hôtel</th>
                        <th class="px-6 py-4 font-medium">Chambre</th>
                        <th class="px-6 py-4 font-medium">Dates</th>
                        <th class="px-6 py-4 font-medium">Statut</th>
                        <th class="px-6 py-4 text-right font-medium">Montant</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($bookings as $booking)
                        <tr>
                            <td class="px-6 py-5 font-medium text-slate-950">{{ $booking->room->hotel->nom ?? 'Hôtel supprimé' }}</td>
                            <td class="px-6 py-5 capitalize text-slate-500">{{ $booking->room->type ?? 'Chambre supprimée' }}</td>
                            <td class="px-6 py-5 text-slate-500">{{ $booking->date_arrivee }} &rarr; {{ $booking->date_depart }}</td>
                            <td class="px-6 py-5">
                                <span class="rounded-full px-3 py-1 text-sm font-medium {{ $statusStyles[$booking->statut] ?? 'bg-slate-100 text-slate-600' }}">
                                    {{ $statusLabels[$booking->statut] ?? $booking->statut }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-right font-semibold text-slate-950">{{ number_format($booking->prix_total ?? 0, 0) }} CFA</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-slate-500">Aucune réservation pour le moment.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section data-panel="revenue" class="hidden">
        <h2 class="mb-6 text-2xl font-semibold text-slate-950">Aperçu des revenus</h2>
        <div class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-slate-100">
                <h3 class="mb-5 text-lg font-normal text-slate-500">Revenus par hôtel</h3>
                <div class="divide-y divide-slate-100">
                    @foreach($hotels as $hotel)
                        @php
                            $hotelRevenue = $bookings->filter(fn ($booking) => optional(optional($booking->room)->hotel)->id === $hotel->id)->sum('prix_total');
                        @endphp
                        <div class="flex items-center justify-between py-4">
                            <span class="font-normal text-slate-700">{{ $hotel->nom }}</span>
                            <span class="text-xl font-semibold text-slate-950">{{ number_format($hotelRevenue, 0) }} CFA</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-slate-100">
                <h3 class="mb-6 text-lg font-normal text-slate-500">Statistiques des réservations</h3>
                <div class="space-y-8">
                    <div class="flex items-center gap-5">
                        <span class="stat-icon text-green-500"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" /><circle cx="9" cy="7" r="4" /><path d="M22 21v-2a4 4 0 0 0-3-3.87" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /></svg></span>
                        <div>
                            <p class="font-medium text-slate-700">Confirmées</p>
                            <p class="text-2xl font-semibold text-slate-950">{{ $confirmedCount }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-5">
                        <span class="stat-icon text-red-500"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 6 6 18M6 6l12 12" /></svg></span>
                        <div>
                            <p class="font-medium text-slate-700">Annulées</p>
                            <p class="text-2xl font-semibold text-slate-950">{{ $canceledCount }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-5">
                        <span class="stat-icon text-blue-500"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9" /><path d="M12 7v5l3 2" /></svg></span>
                        <div>
                            <p class="font-medium text-slate-700">En attente</p>
                            <p class="text-2xl font-semibold text-slate-950">{{ $pendingCount }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="hotel-modal" class="fixed inset-0 z-50 hidden place-items-start overflow-y-auto bg-black/70 px-4 py-8 sm:place-items-center">
        <div data-modal-card class="my-auto w-full max-w-lg rounded-2xl bg-white p-6 shadow-2xl">
            <div class="mb-5 flex items-center justify-between">
                <h2 class="text-2xl font-semibold text-slate-950">Ajouter un hôtel</h2>
                <button type="button" data-close-modal class="text-3xl font-light leading-none text-slate-500 hover:text-slate-900" aria-label="Close">&times;</button>
            </div>

            <form method="POST" action="{{ route('hotels.store') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="redirect_to" value="admin">

                <label class="block">
                    <span class="mb-2 block text-sm font-medium text-slate-900">Nom de l'hôtel</span>
                    <input type="text" name="nom" placeholder="Nom de l'hôtel" required class="modal-input">
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-medium text-slate-900">Ville</span>
                    <input type="text" name="localisation" placeholder="Ville" required class="modal-input">
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-medium text-slate-900">Pays</span>
                    <input type="text" name="pays" placeholder="Pays" required class="modal-input">
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-medium text-slate-900">URL de l'image</span>
                    <input type="url" name="image" placeholder="https://example.com/hotel.jpg" class="modal-input">
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-medium text-slate-900">Description</span>
                    <textarea name="description" rows="2" placeholder="Courte description" class="modal-input resize-none"></textarea>
                </label>

                <button type="submit" class="w-full rounded-xl bg-blue-600 px-5 py-3 font-medium text-white shadow-sm transition hover:bg-blue-700">Enregistrer l'hôtel</button>
            </form>
        </div>
    </div>

    <div id="room-modal" class="fixed inset-0 z-50 hidden place-items-start overflow-y-auto bg-black/70 px-4 py-8 sm:place-items-center">
        <div data-room-modal-card class="my-auto w-full max-w-lg rounded-2xl bg-white p-6 shadow-2xl">
            <div class="mb-5 flex items-center justify-between">
                <h2 class="text-2xl font-semibold text-slate-950">Ajouter une chambre</h2>
                <button type="button" data-close-room-modal class="text-3xl font-light leading-none text-slate-500 hover:text-slate-900" aria-label="Fermer">&times;</button>
            </div>

            <form method="POST" action="{{ route('rooms.store') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="redirect_to" value="admin">

                <label class="block">
                    <span class="mb-2 block text-sm font-medium text-slate-900">Hôtel</span>
                    <select name="hotel_id" required class="modal-input">
                        <option value="">Choisir un hôtel</option>
                        @foreach($hotels as $hotel)
                            <option value="{{ $hotel->id }}">{{ $hotel->nom }} - {{ $hotel->localisation }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-medium text-slate-900">Type de chambre</span>
                    <select name="type" required class="modal-input">
                        <option value="simple">Simple</option>
                        <option value="double">Double</option>
                        <option value="suite">Suite</option>
                    </select>
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-medium text-slate-900">Prix par nuit (CFA)</span>
                    <input type="number" name="prix" min="0" step="1000" placeholder="35000" required class="modal-input">
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-medium text-slate-900">Capacité</span>
                    <input type="number" name="capacite" min="1" placeholder="2" required class="modal-input">
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-medium text-slate-900">URL de l'image</span>
                    <input type="url" name="image" placeholder="https://example.com/chambre.jpg" class="modal-input">
                </label>

                <button type="submit" class="w-full rounded-xl bg-blue-600 px-5 py-3 font-medium text-white shadow-sm transition hover:bg-blue-700">Enregistrer la chambre</button>
            </form>
        </div>
    </div>
</div>

<style>
    .stat-card {
        display: flex;
        align-items: center;
        gap: 1.25rem;
        border-radius: 1.25rem;
        background: white;
        padding: 1.75rem;
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
        border: 1px solid rgb(241 245 249);
    }

    .stat-icon {
        display: grid;
        height: 3rem;
        width: 3rem;
        place-items: center;
        border-radius: 9999px;
        background: rgb(248 250 252);
    }

    .stat-icon svg {
        height: 1.45rem;
        width: 1.45rem;
    }

    .tab-button {
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
        border-radius: 0.75rem;
        padding: 0.75rem 1.15rem;
        font-weight: 500;
        color: rgb(15 23 42);
        transition: 150ms ease;
    }

    .tab-icon {
        height: 1.15rem;
        width: 1.15rem;
    }

    .tab-button:hover {
        background: rgb(239 246 255);
        color: rgb(37 99 235);
    }

    .tab-button.is-active {
        background: rgb(37 99 235);
        color: white;
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.08);
    }

    .tab-button.is-active:hover {
        background: rgb(37 99 235);
        color: white;
    }

    .modal-input {
        width: 100%;
        border-radius: 0.85rem;
        border: 1px solid rgb(226 232 240);
        padding: 0.75rem 0.95rem;
        color: rgb(15 23 42);
        outline: none;
    }

    .modal-input:focus {
        border-color: rgb(37 99 235);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const buttons = document.querySelectorAll('[data-tab]');
        const panels = document.querySelectorAll('[data-panel]');
        const modal = document.getElementById('hotel-modal');
        const modalCard = document.querySelector('[data-modal-card]');
        const roomModal = document.getElementById('room-modal');
        const roomModalCard = document.querySelector('[data-room-modal-card]');

        const activateTab = (tab) => {
            const activeButton = document.querySelector(`[data-tab="${tab}"]`);

            if (!activeButton) {
                return;
            }

            buttons.forEach((item) => item.classList.toggle('is-active', item === activeButton));
            panels.forEach((panel) => panel.classList.toggle('hidden', panel.dataset.panel !== tab));
        };

        buttons.forEach((button) => {
            button.addEventListener('click', () => {
                activateTab(button.dataset.tab);
            });
        });

        activateTab(new URLSearchParams(window.location.search).get('tab') || 'hotels');

        document.querySelectorAll('[data-open-modal]').forEach((button) => {
            button.addEventListener('click', () => {
                modal.classList.remove('hidden');
                modal.classList.add('grid');
            });
        });

        document.querySelectorAll('[data-open-room-modal]').forEach((button) => {
            button.addEventListener('click', () => {
                roomModal.classList.remove('hidden');
                roomModal.classList.add('grid');
            });
        });

        const closeModal = () => {
            modal.classList.add('hidden');
            modal.classList.remove('grid');
        };

        const closeRoomModal = () => {
            roomModal.classList.add('hidden');
            roomModal.classList.remove('grid');
        };

        document.querySelectorAll('[data-close-modal]').forEach((button) => {
            button.addEventListener('click', closeModal);
        });

        document.querySelectorAll('[data-close-room-modal]').forEach((button) => {
            button.addEventListener('click', closeRoomModal);
        });

        modal.addEventListener('click', closeModal);
        modalCard.addEventListener('click', (event) => event.stopPropagation());
        roomModal.addEventListener('click', closeRoomModal);
        roomModalCard.addEventListener('click', (event) => event.stopPropagation());
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeModal();
                closeRoomModal();
            }
        });
    });
</script>
@endsection
