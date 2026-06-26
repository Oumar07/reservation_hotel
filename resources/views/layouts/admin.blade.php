<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Administration — StayHub')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=cormorant-garamond:500,600,700|dm-sans:400,500,600,700" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col bg-surface">
    <header class="site-nav is-scrolled border-b border-navy-900/5 bg-white shadow-sm" data-site-nav>
        <div class="page-container flex items-center justify-between py-4 lg:py-5">
            <a href="/admin" class="flex items-center gap-3">
                <span class="grid h-11 w-11 place-items-center rounded-2xl bg-gradient-to-br from-navy-900 to-navy-700 text-gold-400 shadow-md">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z" />
                    </svg>
                </span>
                <span class="font-display text-2xl font-semibold text-navy-900">StayHub <span class="text-sm font-sans font-medium text-muted">Admin</span></span>
            </a>

            <nav class="hidden items-center gap-1 sm:flex" aria-label="Navigation admin">
                <a href="/hotels" class="nav-link-item">Hôtels</a>
                <a href="{{ route('bookings.index') }}" class="nav-link-item">Réservations</a>
                <a href="{{ route('admin.users.index') }}" class="nav-link-item">Utilisateurs</a>
                <a href="{{ route('places.index') }}" class="nav-link-item">Lieux</a>
                <a href="/admin" class="nav-link-item is-active">Tableau de bord</a>
            </nav>

            <div class="hidden items-center gap-3 sm:flex">
                @auth
                    <span class="flex items-center gap-2 text-sm font-medium text-navy-900">
                        <span class="grid h-8 w-8 place-items-center rounded-full bg-gold-400/20 text-xs font-bold uppercase text-gold-600">
                            {{ mb_substr(Auth::user()->nom, 0, 1) }}
                        </span>
                        {{ Auth::user()->nom }}
                    </span>
                    <form method="POST" action="{{ route('auth.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="btn-outline text-sm">Déconnexion</button>
                    </form>
                @endauth
                <a href="/hotels" class="btn-outline hidden sm:inline-flex">Voir le site</a>
            </div>
        </div>
    </header>

    <main class="flex-1">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
