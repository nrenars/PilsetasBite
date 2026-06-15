<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
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
        <div id="lang-switcher">
            <a href="{{ route('lang.switch', 'en') }}" @class(['active-lang' => app()->getLocale() === 'en'])>EN</a>
            |
            <a href="{{ route('lang.switch', 'lv') }}" @class(['active-lang' => app()->getLocale() === 'lv'])>LV</a>
        </div>
        <div id="dropdown">
            <i id="profile-icon" class="fa-regular fa-circle-user"></i>
            <div id="dropdown-content">
                @guest
                <ul>
                    <li>
                        <a href="{{ route('register') }}">{{ __('messages.register') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('login') }}">{{ __('messages.login') }}</a>
                    </li>
                </ul>
                @endguest
                @auth
                    <ul>
                        <li>
                            <a href="{{ route('showProfile')}}">{{ __('messages.profile') }}</a>
                        </li>
                        @if(Auth::user()->rezervacija()->exists())
                        <li>
                            <a href="{{ route('reservations.show')}}">{{ __('messages.reservations') }}</a>
                        </li>
                        @endif
                        @if(Auth::user()->loma === 'admins')
                        <li>
                            <a href="{{ route('admin.index') }}">{{ __('messages.admin_panel') }}</a>
                        </li>
                        @endif
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit">{{ __('messages.logout') }}</button>
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
