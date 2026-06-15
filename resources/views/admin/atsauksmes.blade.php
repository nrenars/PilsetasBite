<x-admin-layout>
    <h1>Atsauksmes</h1>

    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Lietotājs</th>
                <th>Brauciens</th>
                <th>Vērtējums</th>
                <th>Komentārs</th>
                <th>Darbības</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($atsauksmes as $a)
            <tr>
                <td>{{ $a->id }}</td>
                <td>{{ $a->lietotajs?->pilns_vards ?? '—' }}</td>
                <td>#{{ $a->ire_id }}</td>
                <td>{{ $a->vertejums }}/5</td>
                <td>{{ $a->komentars }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.atsauksmes.destroy', $a->id) }}" onsubmit="return confirm('Dzēst atsauksmi?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-small btn-danger">Dzēst</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $atsauksmes->links() }}
</x-admin-layout>
