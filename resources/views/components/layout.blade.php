<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PilsetasBite</title>
    @vite(['resources/css/app.css'])
</head>
<body>
    <nav>
        <p><a href="/">PilsetasBite</a></p>
        @guest
            <a href="{{ route('register') }}">Register</a>     
            <a href="{{ route('login') }}">Login</a>     
        @endguest
        @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        @endauth
    </nav>
    <main>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        {{ $slot }}
    </main>
    <script>
        window.initMap = function() {
            const map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: 56.91861501307912, lng: 24.13682950619029 },
                zoom: 12,
                mapId: "{{ config('services.google_maps.map_id') }}"
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&map_ids={{ config('services.google_maps.map_id') }}&callback=initMap&loading=async" async defer></script>
</body>
</html>