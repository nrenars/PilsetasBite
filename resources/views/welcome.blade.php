<x-layout>

    <div id="container">
        <div id="filter-container">    
            {{-- Filters --}}
            <form action="">
                <div id="filters">
            
                    <div id="year-range-container">
                        {{-- <label>Year range</label>  --}}
                        <div id="year-range">
                            <input type="number" name="year-from" id="year-from" placeholder="{{ __('messages.year_from') }}">
                            -
                            <input type="number" name="year-to" id="year-to" placeholder="{{ __('messages.year_to') }}">
                        </div>
                    </div>

                    {{-- Dropdowni, lai izveletos masinas pec markas, transmisijas, vietu skaita utt --}}
                    <select name="" id="model-dropdown"> <option value="">{{ __('messages.models') }}</option></select>
                    <select name="" id="fuel-dropdown"><option value="">{{ __('messages.fuel') }}</option></select>
                    <select name="" id="transmission-dropdown"><option value="">{{ __('messages.transmission_filter') }}</option></select>

                </div>
                <button id="filter-btn" type="submit">{{ __('messages.filter') }}</button>
                <p id="filter-error"></p>
            </form>
        </div>
        <div id="map-and-card">
            <div id="map"></div> 
            <script>
                window.csrfToken = "{{ csrf_token() }}";
            </script>
            <div id="car-card"></div>
        </div>
    </div>

    @php
        $hasVerifiedDriverLicense = auth()->check() && trim((string) auth()->user()->vaditaja_apliecibas_statuss) === 'deriga';
        $hasActiveReservation = auth()->check() && auth()->user()->rezervacija()->where('statuss', 'aktīva')->where('deriguma_beigas', '>', now())->exists();
    @endphp

    <script>
        window.masinas = @json($masinas);
        window.hasVerifiedDriverLicense = @json($hasVerifiedDriverLicense);
        window.hasActiveReservation = @json($hasActiveReservation);
        window.csrfToken = @json(csrf_token());
    </script>

    @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif

</x-layout>