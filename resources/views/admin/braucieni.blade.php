<x-admin-layout>
    <h1>Braucieni</h1>

    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Lietotājs</th>
                <th>Mašīna</th>
                <th>Sākums</th>
                <th>Beigas</th>
                <th>Attālums (km)</th>
                <th>Cena (€)</th>
                <th>Statuss</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($braucieni as $b)
            <tr>
                <td>{{ $b->id }}</td>
                <td>{{ $b->lietotajs?->pilns_vards ?? '—' }}</td>
                <td>{{ $b->masina?->registracijas_nr ?? '—' }}</td>
                <td>{{ $b->sakuma_laiks?->format('d.m.Y H:i') ?? '—' }}</td>
                <td>{{ $b->beigu_laiks?->format('d.m.Y H:i') ?? '—' }}</td>
                <td>{{ $b->nobrauktais_attalums ?? '—' }}</td>
                <td>{{ $b->cena ? number_format($b->cena, 2) : '—' }}</td>
                <td>{{ $b->statuss }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $braucieni->links() }}
</x-admin-layout>
