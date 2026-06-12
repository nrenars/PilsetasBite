<x-layout>
    <div id="container">
        <div id="filter-container">
            {{-- Search bar --}}
            <div id="search">
                <div>
                    <div>
                        <input type="text" name="search" id="search-input" placeholder="">
                    </div>
                </div>
            </div>
        
            {{-- Filters --}}
            <div id="filters">
        
                <div id="year-range-container">
                    {{-- <label>Year range</label>  --}}
                    <div id="year-range">
                        <input type="number" name="year-from" id="year-from" placeholder="From">
                        -
                        <input type="number" name="year-to" id="year-to" placeholder="To">
                    </div>
                </div>
        
                {{-- Dropdowni, lai izveletos masinas pec markas, transmisijas, vietu skaita utt --}}
                <div id="dropdown-container">
                
                </div>
        
            </div>
    
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