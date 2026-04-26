<!DOCTYPE html>
<html>
<head>
    <title>Hotel Booking</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">

<nav class="bg-white shadow p-4 flex justify-between">
    <h1 class="text-xl font-bold">HotelApp</h1>
    <div>
        <a href="/hotels">Hotels</a>
        <a href="/rooms">Rooms</a>
    </div>
</nav>

<div class="p-6">
    @yield('content')
</div>

</body>
</html>