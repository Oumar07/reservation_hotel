@extends('layouts.admin')

@section('title', $user->nom . ' — Gestion utilisateur — StayHub Admin')

@section('content')
<div class="page-container section-padding">
    {{-- Messages flash --}}
    @if(session('success'))
        <div class="mb-6 flex items-center gap-3 rounded-2xl bg-green-50 px-5 py-4 text-green-700 ring-1 ring-green-200">
            <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 flex items-center gap-3 rounded-2xl bg-red-50 px-5 py-4 text-red-600 ring-1 ring-red-200">
            <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6M9 9l6 6"/></svg>
            <span class="text-sm font-medium">{{ session('error') }}</span>
        </div>
    @endif

    {{-- Navigation --}}
    <div class="mb-8 flex items-center gap-2 text-sm text-slate-500">
        <a href="{{ route('admin.dashboard') }}" class="transition hover:text-slate-900">Tableau de bord</a>
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        <a href="{{ route('admin.users.index') }}" class="transition hover:text-slate-900">Utilisateurs</a>
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        <span class="text-slate-950 font-medium">{{ $user->nom }}</span>
    </div>

    {{-- Carte profil --}}
    <div class="mb-8 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-100 md:p-8">
        <div class="flex flex-col gap-6 md:flex-row md:items-start md:justify-between">
            <div class="flex items-center gap-5">
                <span class="grid h-16 w-16 place-items-center rounded-2xl bg-gradient-to-br from-violet-500 to-indigo-600 text-2xl font-bold uppercase text-white shadow-lg">
                    {{ mb_substr($user->nom, 0, 1) }}
                </span>
                <div>
                    <h1 class="text-2xl font-semibold text-slate-950">{{ $user->nom }}</h1>
                    <p class="mt-1 text-slate-500">{{ $user->email }}</p>
                    <div class="mt-2 flex items-center gap-3">
                        @if($user->role === 'admin')
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-violet-50 px-3 py-1 text-sm font-medium text-violet-700 ring-1 ring-violet-200/50">
                                <span class="h-1.5 w-1.5 rounded-full bg-violet-500"></span>
                                Administrateur
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1 text-sm font-medium text-slate-600 ring-1 ring-slate-200/50">
                                <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                Client
                            </span>
                        @endif
                        @if(Auth::id() === $user->id)
                            <span class="rounded-full bg-gold-400/20 px-3 py-1 text-sm font-medium text-gold-600">Vous</span>
                        @endif
                    </div>
                </div>
            </div>

            @if(Auth::id() !== $user->id)
                <div>
                    <button type="button"
                            class="inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold transition shadow-sm
                                {{ $user->role === 'admin' ? 'bg-amber-50 text-amber-700 hover:bg-amber-100 ring-1 ring-amber-200' : 'bg-violet-50 text-violet-700 hover:bg-violet-100 ring-1 ring-violet-200' }}"
                            onclick="openRoleModal({{ $user->id }}, '{{ $user->nom }}', '{{ $user->role }}')">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="m21 11-2 2-2-2"/><path d="M19 13V7"/></svg>
                        {{ $user->role === 'admin' ? 'Rétrograder en Client' : 'Promouvoir en Admin' }}
                    </button>
                </div>
            @endif
        </div>

        <div class="mt-6 grid gap-4 border-t border-slate-100 pt-6 sm:grid-cols-3">
            <div>
                <p class="text-sm text-slate-500">Téléphone</p>
                <p class="mt-1 font-medium text-slate-950">{{ $user->telephone ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500">Date d'inscription</p>
                <p class="mt-1 font-medium text-slate-950">{{ $user->created_at?->format('d/m/Y à H:i') ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500">Dernière mise à jour</p>
                <p class="mt-1 font-medium text-slate-950">{{ $user->updated_at?->format('d/m/Y à H:i') ?? '—' }}</p>
            </div>
        </div>
    </div>

    {{-- Réservations de l'utilisateur --}}
    <div class="mb-8">
        <h2 class="mb-5 text-xl font-semibold text-slate-950">Réservations ({{ $user->bookings->count() }})</h2>

        @if($user->bookings->isEmpty())
            <div class="rounded-2xl bg-white p-8 text-center shadow-sm ring-1 ring-slate-100">
                <span class="text-4xl">📅</span>
                <p class="mt-3 font-medium text-slate-700">Aucune réservation</p>
                <p class="mt-1 text-sm text-slate-500">Cet utilisateur n'a effectué aucune réservation.</p>
            </div>
        @else
            <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-100">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[660px] text-left">
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
                            @php
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
                            @foreach($user->bookings as $booking)
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

    {{-- Avis de l'utilisateur --}}
    <div>
        <h2 class="mb-5 text-xl font-semibold text-slate-950">Avis laissés ({{ $user->reviews->count() }})</h2>

        @if($user->reviews->isEmpty())
            <div class="rounded-2xl bg-white p-8 text-center shadow-sm ring-1 ring-slate-100">
                <span class="text-4xl">💬</span>
                <p class="mt-3 font-medium text-slate-700">Aucun avis</p>
                <p class="mt-1 text-sm text-slate-500">Cet utilisateur n'a laissé aucun avis.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($user->reviews as $review)
                    <div class="flex flex-col gap-4 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-100 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <p class="text-sm text-slate-500">
                                {{ $review->hotel->nom ?? 'Hôtel supprimé' }}
                                &middot; {{ $review->created_at?->diffForHumans() }}
                            </p>
                            <p class="mt-2 text-slate-700">{{ $review->commentaire }}</p>
                        </div>
                        <div class="flex shrink-0 items-center gap-1">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->note)
                                    <span class="text-amber-400 text-lg">★</span>
                                @else
                                    <span class="text-slate-300 text-lg">☆</span>
                                @endif
                            @endfor
                            <span class="ml-1 font-semibold text-slate-950">{{ $review->note }}/5</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

{{-- Modal de confirmation de changement de rôle --}}
<div id="role-modal" class="modal-backdrop hidden place-items-start overflow-y-auto sm:place-items-center">
    <div id="role-modal-card" class="modal-panel my-auto max-w-md">
        <div class="mb-5 flex items-center justify-between">
            <h2 class="text-xl font-semibold text-slate-950">Changer le rôle</h2>
            <button type="button" onclick="closeRoleModal()" class="text-3xl font-light leading-none text-slate-500 hover:text-slate-900" aria-label="Fermer">&times;</button>
        </div>

        <div class="mb-6">
            <p class="text-slate-600">Êtes-vous sûr de vouloir modifier le rôle de :</p>
            <p class="mt-2 text-lg font-semibold text-slate-950" id="role-modal-username"></p>
            <div class="mt-3 flex items-center gap-3">
                <span id="role-modal-current" class="rounded-full px-3 py-1 text-sm font-medium"></span>
                <svg class="h-5 w-5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                <span id="role-modal-new" class="rounded-full px-3 py-1 text-sm font-medium"></span>
            </div>
        </div>

        <div class="rounded-xl bg-amber-50 p-4 ring-1 ring-amber-200/50 mb-6">
            <div class="flex gap-3">
                <svg class="h-5 w-5 shrink-0 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
                <p class="text-sm text-amber-700">Cette action modifiera les permissions d'accès de cet utilisateur.</p>
            </div>
        </div>

        <form id="role-form" method="POST" class="flex gap-3">
            @csrf
            @method('PATCH')
            <input type="hidden" name="role" id="role-input">
            <button type="button" onclick="closeRoleModal()" class="btn-outline flex-1">Annuler</button>
            <button type="submit" class="btn-primary flex-1">Confirmer</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openRoleModal(userId, userName, currentRole) {
        const modal = document.getElementById('role-modal');
        const form = document.getElementById('role-form');
        const usernameEl = document.getElementById('role-modal-username');
        const currentEl = document.getElementById('role-modal-current');
        const newEl = document.getElementById('role-modal-new');
        const roleInput = document.getElementById('role-input');

        const newRole = currentRole === 'admin' ? 'client' : 'admin';

        usernameEl.textContent = userName;

        currentEl.textContent = currentRole === 'admin' ? 'Admin' : 'Client';
        currentEl.className = 'rounded-full px-3 py-1 text-sm font-medium ' +
            (currentRole === 'admin' ? 'bg-violet-50 text-violet-700' : 'bg-slate-100 text-slate-600');

        newEl.textContent = newRole === 'admin' ? 'Admin' : 'Client';
        newEl.className = 'rounded-full px-3 py-1 text-sm font-medium ' +
            (newRole === 'admin' ? 'bg-violet-50 text-violet-700' : 'bg-slate-100 text-slate-600');

        roleInput.value = newRole;
        form.action = '/admin/users/' + userId + '/role';

        modal.classList.remove('hidden');
        modal.classList.add('grid');
    }

    function closeRoleModal() {
        const modal = document.getElementById('role-modal');
        modal.classList.add('hidden');
        modal.classList.remove('grid');
    }

    document.getElementById('role-modal').addEventListener('click', closeRoleModal);
    document.getElementById('role-modal-card').addEventListener('click', function(e) { e.stopPropagation(); });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeRoleModal();
    });
</script>
@endpush
@endsection
