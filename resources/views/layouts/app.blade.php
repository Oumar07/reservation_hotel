<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="StayHub — Réservez des hôtels et resorts d'exception partout dans le monde.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'StayHub — Réservation hôtelière premium')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=cormorant-garamond:500,600,700|dm-sans:400,500,600,700" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="flex min-h-screen flex-col">
    @include('partials.navbar')

    <main class="flex-1 @yield('main-class', 'pt-0')">
        @yield('content')
    </main>

    @hasSection('hide-footer')
    @else
        @include('partials.footer')
    @endif

    {{-- ─── Toast notifications globales ─────────────────────────────────────── --}}
    <div id="toast-container" class="fixed bottom-6 right-6 z-[200] flex flex-col gap-3" aria-live="polite"></div>

    {{-- ─── Modale de confirmation d'annulation ───────────────────────────── --}}
    <div id="cancel-modal" class="modal-backdrop hidden" role="dialog" aria-modal="true" aria-labelledby="cancel-modal-title">
        <div class="modal-panel max-w-md">
            <div class="mb-5 flex items-center gap-4">
                <span class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-red-100 text-red-600">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4M12 17h.01"/></svg>
                </span>
                <div>
                    <h2 id="cancel-modal-title" class="text-lg font-semibold text-navy-900">Annuler la réservation</h2>
                    <p class="mt-1 text-sm text-muted">Cette action est irréversible.</p>
                </div>
            </div>
            <p class="text-navy-800">Voulez-vous vraiment annuler cette réservation ? Vous pourrez en effectuer une nouvelle à tout moment.</p>
            <div class="mt-7 flex justify-end gap-3">
                <button type="button" id="cancel-modal-back" class="btn-outline">
                    Retour
                </button>
                <form id="cancel-modal-form" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="btn-danger px-5" id="cancel-modal-confirm">
                        Confirmer l'annulation
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- ─── Script global : toasts + modale annulation ─────────────────────── --}}
    <script>
    // ─── Système de toast notifications ─────────────────────────────────
    window.showToast = function (message, type = 'success') {
        const container = document.getElementById('toast-container');
        const icons = {
            success: '<svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 11 3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>',
            error:   '<svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>',
            warning: '<svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4M12 17h.01"/></svg>',
        };
        const colors = {
            success: 'bg-emerald-600 text-white',
            error:   'bg-red-600 text-white',
            warning: 'bg-amber-500 text-white',
        };
        const toast = document.createElement('div');
        toast.className = `flex items-center gap-3 rounded-xl px-5 py-3.5 shadow-lift text-sm font-medium animate-fade-up ${colors[type] ?? colors.success}`;
        toast.innerHTML = `${icons[type] ?? icons.success}<span>${message}</span>`;
        container.appendChild(toast);
        setTimeout(() => { toast.style.opacity = '0'; toast.style.transition = 'opacity 0.4s'; setTimeout(() => toast.remove(), 400); }, 4000);
    };

    // Afficher les messages flash Laravel comme toasts
    @if(session('success'))
        window.addEventListener('DOMContentLoaded', () => showToast({{ Js::from(session('success')) }}, 'success'));
    @endif
    @if(session('error'))
        window.addEventListener('DOMContentLoaded', () => showToast({{ Js::from(session('error')) }}, 'error'));
    @endif
    @if($errors->any() && !request()->routeIs('hotels.show', 'auth.*', 'bookings.create'))
        window.addEventListener('DOMContentLoaded', () => showToast({{ Js::from($errors->first()) }}, 'error'));
    @endif

    // ─── Modale annulation ────────────────────────────────────────────────
    (function () {
        const modal = document.getElementById('cancel-modal');
        const form  = document.getElementById('cancel-modal-form');
        const backBtn = document.getElementById('cancel-modal-back');
        if (!modal) return;

        const open  = () => { modal.classList.remove('hidden'); modal.classList.add('grid'); };
        const close = () => { modal.classList.add('hidden'); modal.classList.remove('grid'); };

        // Délégation : tous les boutons [data-cancel-booking] ouvrent la modale
        document.addEventListener('click', (e) => {
            const btn = e.target.closest('[data-cancel-booking]');
            if (!btn) return;
            const action = btn.dataset.cancelAction;
            form.action = action;
            open();
        });

        backBtn.addEventListener('click', close);
        modal.addEventListener('click', (e) => { if (e.target === modal) close(); });
    })();
    </script>

    @stack('scripts')
</body>
</html>
