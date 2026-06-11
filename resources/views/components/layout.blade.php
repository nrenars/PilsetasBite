<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PilsetasBite</title>
    @vite(['resources/css/app.css'])
    {{-- @vite(['resources/js/map.js']) --}}
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
            <a href="{{ route('profile')}}">Profile</a>
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
    @vite(['resources/js/map.js'])
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&map_ids={{ config('services.google_maps.map_id') }}" defer></script>
</body>
</html>