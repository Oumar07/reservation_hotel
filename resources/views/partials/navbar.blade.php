@php
    $heroNav = request()->is('/') || (request()->is('hotels') && ! request()->routeIs('hotels.show'));
@endphp
<header class="site-nav {{ $heroNav ? '' : 'is-scrolled' }}" data-site-nav>
    <div class="page-container flex items-center justify-between py-4 lg:py-5">
        <a href="/hotels" class="flex items-center gap-3 transition-opacity hover:opacity-90">
            <span class="grid h-11 w-11 place-items-center rounded-2xl bg-gradient-to-br from-navy-900 to-navy-700 text-gold-400 shadow-md ring-2 ring-gold-400/30">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M4 21V5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v16" />
                    <path d="M9 21v-6h6v6" />
                    <path d="M8 7h.01M12 7h.01M16 7h.01M8 11h.01M12 11h.01M16 11h.01" />
                </svg>
            </span>
            <span class="nav-brand-text font-display text-2xl font-semibold tracking-tight">StayHub</span>
        </a>

        <nav class="hidden items-center gap-1 lg:flex" aria-label="Navigation principale">
            <a href="/hotels" class="nav-link-item {{ request()->is('hotels*') && !request()->is('admin*') ? 'is-active' : '' }}">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M4 21V5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v16" />
                    <path d="M9 21v-6h6v6" />
                </svg>
                Hôtels
            </a>
            <a href="/bookings" class="nav-link-item {{ request()->is('bookings*') ? 'is-active' : '' }}">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M8 2v4M16 2v4M3 10h18" />
                    <rect x="3" y="4" width="18" height="18" rx="2" />
                </svg>
                Mes réservations
            </a>
            <a href="/admin" class="nav-link-item {{ request()->is('admin*') ? 'is-active' : '' }}">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z" />
                </svg>
                Administration
            </a>
        </nav>

        <div class="hidden items-center gap-3 lg:flex">
            <a href="/hotels" class="nav-cta">
                Réserver
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M5 12h14M12 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <button type="button"
                class="site-nav-toggle relative z-50 grid h-11 w-11 place-items-center rounded-xl border border-white/20 bg-white/10 text-white backdrop-blur-sm transition hover:bg-white/20 lg:hidden"
                data-mobile-toggle
                aria-expanded="false"
                aria-controls="mobile-menu"
                aria-label="Ouvrir le menu">
            <span class="sr-only">Menu</span>
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
                <path d="M4 7h16M4 12h16M4 17h16" />
            </svg>
        </button>
    </div>
</header>

<div class="fixed inset-0 z-40 hidden bg-navy-950/50 backdrop-blur-sm lg:hidden" data-mobile-overlay aria-hidden="true"></div>

<nav id="mobile-menu"
     class="fixed inset-y-0 right-0 z-50 flex w-[min(100%,320px)] translate-x-full flex-col bg-white shadow-2xl transition-transform duration-300 ease-out lg:hidden"
     data-mobile-menu
     aria-label="Menu mobile">
    <div class="flex items-center justify-between border-b border-navy-900/10 px-6 py-5">
        <span class="font-display text-xl font-semibold text-navy-900">StayHub</span>
        <button type="button" class="grid h-10 w-10 place-items-center rounded-xl text-navy-600 hover:bg-navy-900/5" data-mobile-toggle aria-label="Fermer le menu">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
                <path d="M18 6 6 18M6 6l12 12" />
            </svg>
        </button>
    </div>
    <div class="flex flex-1 flex-col gap-1 p-4">
        <a href="/hotels" class="rounded-xl px-4 py-3.5 font-medium text-navy-900 hover:bg-surface {{ request()->is('hotels*') ? 'bg-navy-900 text-white hover:bg-navy-800' : '' }}">Hôtels</a>
        <a href="/bookings" class="rounded-xl px-4 py-3.5 font-medium text-navy-900 hover:bg-surface {{ request()->is('bookings*') ? 'bg-navy-900 text-white hover:bg-navy-800' : '' }}">Mes réservations</a>
        <a href="/admin" class="rounded-xl px-4 py-3.5 font-medium text-navy-900 hover:bg-surface {{ request()->is('admin*') ? 'bg-navy-900 text-white hover:bg-navy-800' : '' }}">Administration</a>
        <a href="/hotels" class="btn-gold mt-4 w-full">Réserver maintenant</a>
    </div>
</nav>

<style>
    .site-nav.is-scrolled .site-nav-toggle {
        border-color: rgb(12 31 61 / 0.1);
        background: white;
        color: rgb(12 31 61);
    }
    .site-nav:not(.is-scrolled) .site-nav-toggle {
        border-color: rgb(255 255 255 / 0.2);
        background: rgb(255 255 255 / 0.1);
        color: white;
    }
</style>
