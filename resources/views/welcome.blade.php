<x-layout>
    {{-- Search bar --}}
    <div id="search">
        <div>
            <div>
                <input type="text" name="search" id="search-input" placeholder="">
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div id="filter-container">

        <div id="year-range-container">
            <label>Year range</label> 
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


    <div id="map"></div> 


    @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif

</x-layout>