<x-admin-layout>
    @if ($errors->any())
        <div style="background:#f8d7da; color:#842029; padding:0.75rem 1rem; border-radius:6px; margin-bottom:1rem;">
            <ul style="margin:0; padding-left:1.2rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="admin-page-header">
        <div>
            <h1>Pievienot mašīnu</h1>
            <p>Izveido jaunu transportlīdzekli sistēmā.</p>
        </div>

        <a href="{{ route('admin.masinas') }}" class="admin-btn">
            Atpakaļ
        </a>
    </div>

    <form method="POST" action="{{ route('admin.masinas.store') }}" class="admin-form">
        @csrf

        <div class="form-group">
            <label for="modelis_id">Modelis</label>
            <select name="modelis_id" id="modelis_id" required>
                <option value="">-- Izvēlies modeli --</option>
                @foreach($modeli as $modelis)
                    <option value="{{ $modelis->id }}" @selected(old('modelis_id') == $modelis->id)>
                        {{ $modelis->marka }} {{ $modelis->modelis }}
                    </option>
                @endforeach
            </select>
            @error('modelis_id')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="lokacija_id">Lokācija</label>
            <select name="lokacija_id" id="lokacija_id" required>
                <option value="">-- Izvēlies lokāciju --</option>
                @foreach($lokacijas as $lokacija)
                    <option value="{{ $lokacija->id }}" @selected(old('lokacija_id') == $lokacija->id)>
                        {{ $lokacija->pilseta ?? $lokacija->nosaukums ?? 'Lokācija #' . $lokacija->id }}

                        @if(isset($lokacija->platuma_gradi) && isset($lokacija->garuma_gradi))
                            — {{ $lokacija->platuma_gradi }}, {{ $lokacija->garuma_gradi }}
                        @endif
                    </option>
                @endforeach
            </select>
            @error('lokacija_id')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="gads">Gads</label>
            <input 
                type="number" 
                name="gads" 
                id="gads" 
                value="{{ old('gads') }}" 
                min="1980" 
                max="{{ now()->year }}" 
                required
            >
            @error('gads')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            <label for="registracijas_nr">Reģistrācijas Nr.</label>
            <input 
                type="text" 
                name="registracijas_nr" 
                id="registracijas_nr" 
                value="{{ old('registracijas_nr') }}" 
                required
            >

            @error('registracijas_nr')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            <label for="tehniskas_apskates_termins">Tehn. apsk. term.</label>
            <input 
                type="date" 
                name="tehniskas_apskates_termins" 
                id="tehniskas_apskates_termins" 
                value="{{ old('tehniskas_apskates_termins') }}" 
                required
            >

            @error('tehniskas_apskates_termins')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            <label for="statuss">Statuss</label>
            <select name="statuss" id="statuss" required>
                <option value="pieejama" @selected(old('statuss') === 'pieejama')>
                    Pieejama
                </option>
                <option value="neaktīva" @selected(old('statuss') === 'neaktīva')>
                    Neaktīva
                </option>
            </select>

            @error('statuss')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            <label for="degvielas_limenis">Degvielas līmenis (%)</label>
            <input 
                type="number" 
                name="degvielas_limenis" 
                id="degvielas_limenis" 
                value="{{ old('degvielas_limenis') }}" 
                min="0" 
                max="100"
            >
            @error('degvielas_limenis')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="baterijas_limenis">Baterijas līmenis (%)</label>
            <input 
                type="number" 
                name="baterijas_limenis" 
                id="baterijas_limenis" 
                value="{{ old('baterijas_limenis') }}" 
                min="0" 
                max="100"
            >
            @error('baterijas_limenis')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="admin-btn">
            Saglabāt
        </button>
    </form>
</x-admin-layout>