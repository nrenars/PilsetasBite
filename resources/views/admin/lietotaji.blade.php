<x-admin-layout>
    <h1>Lietotāji</h1>

    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Vārds</th>
                <th>E-pasts</th>
                <th>Telefons</th>
                <th>Loma</th>
                <th>Statuss</th>
                <th>Darbības</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lietotaji as $l)
            <tr>
                <td>{{ $l->id }}</td>
                <td>{{ $l->pilns_vards }}</td>
                <td>{{ $l->epasts }}</td>
                <td>{{ $l->telefons }}</td>
                <td>{{ $l->loma }}</td>
                <td>{{ $l->statuss }}</td>
                <td class="admin-actions">
                    @if ($l->loma !== 'admins')
                        <form method="POST" action="{{ route('admin.lietotaji.loma', [$l->id, 'admins']) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn-small btn-warn">Padarīt par adminu</button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('admin.lietotaji.loma', [$l->id, 'lietotajs']) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn-small btn-warn">Noņemt adminu</button>
                        </form>
                    @endif
                    @if ($l->id !== auth()->id())
                        <form method="POST" action="{{ route('admin.lietotaji.destroy', $l->id) }}" onsubmit="return confirm('Dzēst lietotāju?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-small btn-danger">Dzēst</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $lietotaji->links() }}
</x-admin-layout>
