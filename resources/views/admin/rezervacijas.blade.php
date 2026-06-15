<x-admin-layout>
    <h1>Rezervācijas</h1>

    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Lietotājs</th>
                <th>Mašīna</th>
                <th>Datums</th>
                <th>Derīguma beigas</th>
                <th>Statuss</th>
                <th>Darbības</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rezervacijas as $r)
            <tr>
                <td>{{ $r->id }}</td>
                <td>{{ $r->lietotajs?->pilns_vards ?? '—' }}</td>
                <td>{{ $r->masina?->registracijas_nr ?? '—' }}</td>
                <td>{{ $r->datums }}</td>
                <td>{{ $r->deriguma_beigas }}</td>
                <td>{{ $r->statuss }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.rezervacijas.destroy', $r->id) }}" onsubmit="return confirm('Dzēst rezervāciju?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-small btn-danger">Dzēst</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $rezervacijas->links() }}
</x-admin-layout>
