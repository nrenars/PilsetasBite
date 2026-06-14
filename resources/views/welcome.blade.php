<x-layout>

    <div id="container">
        <div id="filter-container">    
            {{-- Filters --}}
            <form action="">
                <div id="filters">
            
                    <div id="year-range-container">
                        {{-- <label>Year range</label>  --}}
                        <div id="year-range">
                            <input type="number" name="year-from" id="year-from" placeholder="Year From">
                            -
                            <input type="number" name="year-to" id="year-to" placeholder="Year To">
                        </div>
                    </div>
            
                    {{-- Dropdowni, lai izveletos masinas pec markas, transmisijas, vietu skaita utt --}}
                    <select name="" id="model-dropdown"> <option value="">Models</option></select>
                    <select name="" id="fuel-dropdown"><option value="">Fuel</option></select>
                    <select name="" id="transmission-dropdown"><option value="">Transmission</option></select>
            
                </div>
                <button id="filter-btn" type="submit">Filter</button>
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

    <script>
        window.masinas = @json($masinas);
    </script>

    @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif

</x-layout>