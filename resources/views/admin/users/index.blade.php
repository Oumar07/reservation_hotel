@extends('layouts.admin')

@section('title', 'Gestion des utilisateurs — StayHub Admin')

@section('content')
<div class="page-container section-padding">
    <div class="reveal mb-10">
        <p class="text-sm font-semibold uppercase tracking-widest text-gold-600">Administration</p>
        <h1 class="section-title mt-2">Gestion des utilisateurs</h1>
        <p class="section-subtitle">Gérez les comptes et les rôles de vos utilisateurs</p>
    </div>

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

    {{-- Statistiques rapides --}}
    <div class="mb-8 grid gap-5 md:grid-cols-3">
        <div class="stat-card">
            <span class="stat-icon-wrap text-violet-600">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </span>
            <div>
                <p class="text-sm font-normal text-slate-500">Total utilisateurs</p>
                <h2 class="text-2xl font-semibold text-slate-950">{{ $users->count() }}</h2>
            </div>
        </div>
        <div class="stat-card">
            <span class="stat-icon-wrap text-amber-500">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg>
            </span>
            <div>
                <p class="text-sm font-normal text-slate-500">Administrateurs</p>
                <h2 class="text-2xl font-semibold text-slate-950">{{ $users->where('role', 'admin')->count() }}</h2>
            </div>
        </div>
        <div class="stat-card">
            <span class="stat-icon-wrap text-blue-600">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </span>
            <div>
                <p class="text-sm font-normal text-slate-500">Clients</p>
                <h2 class="text-2xl font-semibold text-slate-950">{{ $users->where('role', 'client')->count() }}</h2>
            </div>
        </div>
    </div>

    {{-- Bouton retour --}}
    <div class="mb-6">
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-slate-900">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            Retour au tableau de bord
        </a>
    </div>

    {{-- Tableau des utilisateurs --}}
    <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-100">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[860px] text-left">
                <thead class="border-b border-slate-100 text-sm text-slate-500">
                    <tr>
                        <th class="px-6 py-4 font-medium">Utilisateur</th>
                        <th class="px-6 py-4 font-medium">Email</th>
                        <th class="px-6 py-4 font-medium">Téléphone</th>
                        <th class="px-6 py-4 font-medium">Rôle</th>
                        <th class="px-6 py-4 font-medium">Inscrit le</th>
                        <th class="px-6 py-4 text-right font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                        <tr class="transition hover:bg-slate-50/50">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <span class="grid h-10 w-10 place-items-center rounded-full bg-gradient-to-br from-violet-500 to-indigo-600 text-sm font-bold uppercase text-white shadow-sm">
                                        {{ mb_substr($user->nom, 0, 1) }}
                                    </span>
                                    <div>
                                        <p class="font-medium text-slate-950">{{ $user->nom }}</p>
                                        @if(Auth::id() === $user->id)
                                            <span class="text-xs text-gold-600 font-medium">(vous)</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-slate-500">{{ $user->email }}</td>
                            <td class="px-6 py-5 text-slate-500">{{ $user->telephone ?? '—' }}</td>
                            <td class="px-6 py-5">
                                @if($user->role === 'admin')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-violet-50 px-3 py-1 text-sm font-medium text-violet-700 ring-1 ring-violet-200/50">
                                        <span class="h-1.5 w-1.5 rounded-full bg-violet-500"></span>
                                        Admin
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1 text-sm font-medium text-slate-600 ring-1 ring-slate-200/50">
                                        <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                        Client
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-5 text-slate-500">{{ $user->created_at?->format('d/m/Y à H:i') ?? '—' }}</td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.users.show', $user) }}"
                                       class="inline-flex items-center gap-1.5 rounded-lg bg-slate-100 px-3 py-1.5 text-sm font-medium text-slate-700 transition hover:bg-slate-200"
                                       title="Voir les détails">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                        Détails
                                    </a>

                                    @if(Auth::id() !== $user->id)
                                        <button type="button"
                                                class="inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-sm font-medium transition
                                                    {{ $user->role === 'admin' ? 'bg-amber-50 text-amber-700 hover:bg-amber-100 ring-1 ring-amber-200/50' : 'bg-violet-50 text-violet-700 hover:bg-violet-100 ring-1 ring-violet-200/50' }}"
                                                onclick="openRoleModal({{ $user->id }}, '{{ $user->nom }}', '{{ $user->role }}')"
                                                title="Changer le rôle">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="m21 11-2 2-2-2"/><path d="M19 13V7"/></svg>
                                            Changer rôle
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <span class="text-4xl">👤</span>
                                <p class="mt-3 font-medium text-slate-700">Aucun utilisateur</p>
                                <p class="mt-1 text-sm text-slate-500">Les utilisateurs apparaîtront ici après inscription.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
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

        // Badge rôle actuel
        currentEl.textContent = currentRole === 'admin' ? 'Admin' : 'Client';
        currentEl.className = 'rounded-full px-3 py-1 text-sm font-medium ' +
            (currentRole === 'admin' ? 'bg-violet-50 text-violet-700' : 'bg-slate-100 text-slate-600');

        // Badge nouveau rôle
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

    // Fermer en cliquant sur le backdrop
    document.getElementById('role-modal').addEventListener('click', closeRoleModal);
    document.getElementById('role-modal-card').addEventListener('click', function(e) { e.stopPropagation(); });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeRoleModal();
    });
</script>
@endpush
@endsection
