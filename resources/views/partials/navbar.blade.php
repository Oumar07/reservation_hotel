@php
    $heroNav = false; // Navbar toujours solide
@endphp
<header class="site-nav is-scrolled" data-site-nav>
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
            @auth
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="nav-link-item {{ request()->is('admin*') ? 'is-active' : '' }}">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z" />
                        </svg>
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('bookings.my') }}" class="nav-link-item {{ request()->is('mes-reservations*') ? 'is-active' : '' }}">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M8 2v4M16 2v4M3 10h18" />
                            <rect x="3" y="4" width="18" height="18" rx="2" />
                        </svg>
                        Mes réservations
                    </a>
                @endif
            @endauth
        </nav>

        <div class="hidden items-center gap-3 lg:flex">
            @auth
                {{-- Client connecté --}}
                <span class="flex items-center gap-2 text-sm font-medium nav-brand-text">
                    <span class="grid h-8 w-8 place-items-center rounded-full bg-gold-400/20 text-xs font-bold uppercase text-gold-600">
                        {{ mb_substr(Auth::user()->nom, 0, 1) }}
                    </span>
                    {{ Auth::user()->nom }}
                </span>
                <form method="POST" action="{{ route('auth.logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="nav-cta" id="btn-logout">
                        Déconnexion
                    </button>
                </form>
            @else
                {{-- Non connecté --}}
                <a href="{{ route('auth.login') }}" class="nav-link-item">
                    Connexion
                </a>
                <a href="{{ route('auth.register') }}" class="nav-cta">
                    S'inscrire
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </a>
            @endauth
        </div>

        <button type="button"
                class="site-nav-toggle relative z-50 grid h-11 w-11 place-items-center rounded-xl border border-navy-900/10 bg-white text-navy-900 transition hover:bg-navy-900/5 lg:hidden"
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
        @auth
            @if(Auth::user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="rounded-xl px-4 py-3.5 font-medium text-navy-900 hover:bg-surface {{ request()->is('admin*') ? 'bg-navy-900 text-white hover:bg-navy-800' : '' }}">Dashboard</a>
            @else
                <a href="{{ route('bookings.my') }}" class="rounded-xl px-4 py-3.5 font-medium text-navy-900 hover:bg-surface {{ request()->is('mes-reservations*') ? 'bg-navy-900 text-white hover:bg-navy-800' : '' }}">Mes réservations</a>
            @endif
            <form method="POST" action="{{ route('auth.logout') }}" class="mt-1">
                @csrf
                <button type="submit" class="w-full rounded-xl px-4 py-3.5 text-left font-medium text-red-600 hover:bg-red-50">
                    Déconnexion ({{ Auth::user()->nom }})
                </button>
            </form>
        @else
            <div class="flex flex-col gap-2 mt-2 border-t border-navy-900/10 pt-3">
                <a href="{{ route('auth.login') }}" class="rounded-xl px-4 py-3 text-center font-medium text-navy-900 border border-navy-900/20 hover:bg-surface">Connexion</a>
                <a href="{{ route('auth.register') }}" class="btn-gold w-full text-center">S'inscrire</a>
            </div>
        @endauth
    </div>
</nav>


