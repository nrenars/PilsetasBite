<x-admin-layout>
    <h1>Maksājumi</h1>

    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Īre</th>
                <th>Summa bez PVN</th>
                <th>Summa ar PVN</th>
                <th>Maksājuma veids</th>
                <th>Statuss</th>
                <th>Maksājuma datums</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($maksajumi as $m)
                <tr>
                    <td>{{ $m->id }}</td>
                    <td>
                        @if ($m->ire)
                            #{{ $m->ire->id }}
                        @else
                            —
                        @endif
                    </td>
                    <td>{{ number_format($m->summa_bez_pvn, 2, ',', ' ') }} €</td>
                    <td>{{ number_format($m->summa_ar_pvn, 2, ',', ' ') }} €</td>
                    <td>{{ $m->maksajuma_veids }}</td>
                    <td>{{ $m->maksajuma_statuss }}</td>
                    <td>
                        {{ $m->maksajuma_datums ? $m->maksajuma_datums->format('d.m.Y H:i') : '—' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Nav atrasts neviens maksājums.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $maksajumi->links() }}
</x-admin-layout>