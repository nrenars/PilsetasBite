<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PilsetasBite</title>
    @vite(['resources/css/app.css'])
    @vite(['resources/js/script.js'])
    <script src="https://kit.fontawesome.com/542c50e191.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">

</head>
<body>
    <nav>
        <a href="/"><img height="100px" src="{{ asset('images/logo.png') }}" alt="PilsetasBite logo"></a>
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
                    <ul id="auth-dropdown-menu">
                        <li>
                            <a href="{{ route('showProfile')}}">{{ __('messages.profile') }}</a>
                        </li>

                        @if(Auth::user()->rezervacija()->exists())
                            <li id="reservations-menu-item">
                                <a href="{{ route('reservations.show')}}">{{ __('messages.reservations') }}</a>
                            </li>
                        @endif

                        @if(Auth::user()->loma === 'admins')
                            <li>
                                <a href="{{ route('admin.index') }}">{{ __('messages.admin_panel') }}</a>
                            </li>
                        @endif

                        <li id="logout-menu-item">
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
        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif
        {{ $slot }}
    </main>

    @auth
        <script>
            window.reservationsUrl = "{{ route('reservations.show') }}";
            window.reservationsText = "{{ __('messages.reservations') }}";
        </script>
    @endauth

    <script>
        window.i18n = {
            year: @json(__('messages.year')),
            seat_count: @json(__('messages.seat_count')),
            fuel_battery: @json(__('messages.fuel_battery')),
            fuel_level: @json(__('messages.fuel_level')),
            battery: @json(__('messages.battery')),
            no_data: @json(__('messages.no_data')),

            make_reservation: @json(__('messages.make_reservation')),
            begin_ride: @json(__('messages.begin_ride')),
            license_required: @json(__('messages.license_required')),
            already_active_reservation: @json(__('messages.already_active_reservation')),
            car_not_available: @json(__('messages.car_not_available')),
            error: @json(__('messages.error')),
            reservation_successful: @json(__('messages.reservation_successful')),
            license_not_valid: @json(__('messages.license_not_valid')),
            error: @json(__('messages.error')),

            years_positive: @json(__('messages.years_positive')),
            year_from_greater: @json(__('messages.year_from_greater')),
            invalid_year_range: @json(__('messages.invalid_year_range')),
            no_cars_from: @json(__('messages.no_cars_from')),

            statuses: {
                "pieejama": @json(__('messages.status_available')),
                "rezervēta": @json(__('messages.status_reserved')),
                "lietošanā": @json(__('messages.status_in_use'))
            }
        };
    </script>

    @vite(['resources/js/map.js'])
    <script>
        window.initGoogleMaps = function () {
            if (document.getElementById('ride-map') && typeof window.initRideMap === 'function') {
                window.initRideMap();
                return;
            }

            if (document.getElementById('map') && typeof window.initMap === 'function') {
                window.initMap();
            }
        };
    </script>

    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&map_ids={{ config('services.google_maps.map_id') }}&callback=initGoogleMaps"
        async
        defer>
    </script>
</body>
</html>