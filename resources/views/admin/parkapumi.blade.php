<x-admin-layout>
    <h1>Pārkāpumi</h1>

    <h2>Pievienot pārkāpumu un nobloķēt lietotāju</h2>
    <form method="POST" action="{{ route('admin.parkapumi.nobloket') }}" style="background:#fff; padding:1.5rem; border-radius:8px; box-shadow:0 1px 4px rgba(0,0,0,.1); margin-bottom:2rem; max-width:600px;">
        @csrf
        @if(session('success'))
            <div class="alert-success" style="margin-bottom:1rem;">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div style="background:#f8d7da; color:#721c24; padding:.75rem; border-radius:6px; margin-bottom:1rem;">
                @foreach($errors->all() as $e) <div>{{ $e }}</div> @endforeach
            </div>
        @endif

        <div style="margin-bottom:1rem;">
            <label style="display:block; font-weight:bold; margin-bottom:.25rem;">Lietotājs</label>
            <select name="lietotajs_id" required style="width:100%; padding:.5rem; border:1px solid #ccc; border-radius:4px;">
                <option value="">-- Izvēlēties lietotāju --</option>
                @foreach($lietotaji as $l)
                    <option value="{{ $l->id }}">{{ $l->pilns_vards }} ({{ $l->epasts }})</option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom:1rem;">
            <label style="display:block; font-weight:bold; margin-bottom:.25rem;">Brauciens</label>
            <select name="ire_id" required style="width:100%; padding:.5rem; border:1px solid #ccc; border-radius:4px;">
                <option value="">-- Izvēlēties braucienu --</option>
                @foreach($braucieni as $b)
                    <option value="{{ $b->id }}">#{{ $b->id }} — {{ $b->lietotajs?->pilns_vards }} ({{ $b->sakuma_laiks?->format('d.m.Y') }})</option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom:1rem;">
            <label style="display:block; font-weight:bold; margin-bottom:.25rem;">Pārkāpuma veids</label>
            <select name="tips" required style="width:100%; padding:.5rem; border:1px solid #ccc; border-radius:4px;">
                <option value="">-- Izvēlēties --</option>
                <option value="smēķēšana">Smēķēšana automašīnā</option>
                <option value="satiksmes_pārkāpums">Satiksmes pārkāpums</option>
                <option value="bojājumi">Automašīnas bojājumi</option>
                <option value="novēlota_atgriešana">Novēlota atgriešana</option>
                <option value="cits">Cits</option>
            </select>
        </div>

        <div style="margin-bottom:1rem;">
            <label style="display:block; font-weight:bold; margin-bottom:.25rem;">Apraksts</label>
            <textarea name="apraksts" required rows="3" style="width:100%; padding:.5rem; border:1px solid #ccc; border-radius:4px;"></textarea>
        </div>

        <div style="margin-bottom:1.5rem;">
            <label style="display:block; font-weight:bold; margin-bottom:.25rem;">Soda nauda (€)</label>
            <input type="number" name="summa" step="0.01" min="0" required style="width:100%; padding:.5rem; border:1px solid #ccc; border-radius:4px;">
        </div>

        <button type="submit" class="btn-small btn-danger" style="padding:.6rem 1.5rem; font-size:1rem;">
            Nobloķēt lietotāju un nosūtīt e-pastu
        </button>
    </form>

    <h2>Pārkāpumu vēsture</h2>
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Lietotājs</th>
                <th>Brauciens</th>
                <th>Veids</th>
                <th>Apraksts</th>
                <th>Summa</th>
                <th>Statuss</th>
                <th>Darbības</th>
            </tr>
        </thead>
        <tbody>
            @forelse($parkapumi as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>{{ $p->lietotajs?->pilns_vards ?? '—' }}</td>
                <td>#{{ $p->ire_id }}</td>
                <td>{{ $p->tips }}</td>
                <td>{{ $p->apraksts }}</td>
                <td>{{ number_format($p->summa, 2) }} €</td>
                <td>{{ $p->statuss }}</td>
                <td>
                    @if($p->statuss === 'nesamaksats')
                        <form method="POST" action="{{ route('admin.parkapumi.samaksats', $p->id) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn-small" style="background:#28a745; color:#fff;">Atzīmēt kā samaksātu</button>
                        </form>
                    @else
                        —
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center; color:#999;">Nav pārkāpumu</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $parkapumi->links() }}
</x-admin-layout>
