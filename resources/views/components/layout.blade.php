<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PilsetasBite</title>
    @vite(['resources/css/app.css'])
    <script src="https://kit.fontawesome.com/542c50e191.js" crossorigin="anonymous"></script>

</head>
<body>
    <nav>
        <p><a href="/">PilsetasBite</a></p>
        <div id="dropdown">
            <i id="profile-icon" class="fa-regular fa-circle-user"></i>
            {{-- <i class="fa-solid fa-circle-user"></i> --}}
            {{-- <i class="fa-regular fa-user"></i> --}}
            {{-- <i class="fa-solid fa-user"></i> --}}
            <div id="dropdown-content">
                @guest
                <ul>
                    <li>
                        <a href="{{ route('register') }}">Register</a>     
                    </li>
                    <li>
                        <a href="{{ route('login') }}">Login</a>     
                    </li>
                </ul>
                @endguest
                @auth
                    <ul>
                        <li>
                            <a href="{{ route('showProfile')}}">Profile</a>
                        </li>
                        @if(Auth::user()->rezervacija()->exists())
                        <li>
                            <a href="{{ route('reservations.show')}}">Reservations</a>
                        </li>
                        @endif
                        @if(Auth::user()->loma === 'admins')
                        <li>
                            <a href="{{ route('admin.index') }}">Admin panelis</a>
                        </li>
                        @endif
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit">Logout</button>
                            </form>
                        </li>
                    </ul>
                @endauth
            </div>
        </div>
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