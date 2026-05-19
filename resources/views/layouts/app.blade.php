<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="StayHub — Réservez des hôtels et resorts d'exception partout dans le monde.">
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

    @stack('scripts')
</body>
</html>
