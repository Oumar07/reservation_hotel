<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans text-slate-950 antialiased">

    <nav class="border-b border-slate-200 bg-white px-6 py-5">
        <div class="mx-auto flex max-w-[1540px] items-center justify-between">
            <a href="/admin" class="flex items-center gap-3">
                <span class="grid h-11 w-11 place-items-center rounded-full bg-blue-600 text-white">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M4 21V5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v16" />
                        <path d="M9 21v-6h6v6" />
                        <path d="M8 7h.01M12 7h.01M16 7h.01M8 11h.01M12 11h.01M16 11h.01" />
                    </svg>
                </span>
                <span class="text-3xl font-semibold tracking-normal text-slate-950">StayHub</span>
            </a>

            <div class="flex items-center gap-7 text-base font-medium">
                <a href="/hotels" class="flex items-center gap-2 text-slate-900 transition hover:text-blue-600">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M4 21V5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v16" />
                        <path d="M9 21v-6h6v6" />
                        <path d="M8 7h.01M12 7h.01M16 7h.01M8 11h.01M12 11h.01M16 11h.01" />
                    </svg>
                    Hôtels
                </a>
                <a href="/bookings" class="flex items-center gap-2 text-slate-900 transition hover:text-blue-600">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M20 21a8 8 0 0 0-16 0" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                    Mes réservations
                </a>
                <a href="/admin" class="flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-white shadow-sm transition hover:bg-blue-700">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z" />
                    </svg>
                    Administration
                </a>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

</body>
</html>
