<x-admin-layout>
    <h1>Mašīnas</h1>

    <p>
        <a href="{{ route('admin.masinas.create') }}" class="btn-small btn-warn" style="text-decoration: none;">
            Pievienot mašīnu
        </a>
    </p>

    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Reģ. Nr.</th>
                <th>Tehn. apsk. term.</th>
                <th>Marka</th>
                <th>Modelis</th>
                <th>Gads</th>
                <th>Transmisija</th>
                <th>Degvielas tips</th>
                <th>Vietu skaits</th>
                <th>Lokācijas ID</th>
                <th>Platums</th>
                <th>Garums</th>
                <th>Statuss</th>
                <th>Degviela</th>
                <th>Baterija</th>
                <th>Darbības</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($masinas as $m)
                <tr>
                    <td>{{ $m->id }}</td>

                    <td>{{ $m->registracijas_nr }}</td>

                    <td>{{ $m->tehniskas_apskates_termins }}</td>

                    <td>{{ $m->modelis->marka ?? '-' }}</td>

                    <td>{{ $m->modelis->modelis ?? '-' }}</td>

                    <td>{{ $m->gads }}</td>

                    <td>{{ $m->modelis->transmisija ?? '-' }}</td>

                    <td>{{ $m->modelis->degvielas_tips ?? '-' }}</td>

                    <td>{{ $m->modelis->vietu_skaits ?? '-' }}</td>

                    <td>{{ $m->lokacija_id ?? '-' }}</td>

                    <td>{{ $m->lokacija->platuma_gradi ?? '-' }}</td>

                    <td>{{ $m->lokacija->garuma_gradi ?? '-' }}</td>

                    <td>{{ $m->statuss }}</td>

                    <td>
                        @if($m->degvielas_limenis !== null)
                            {{ $m->degvielas_limenis }}%
                        @else
                            -
                        @endif
                    </td>

                    <td>
                        @if($m->baterijas_limenis !== null)
                            {{ $m->baterijas_limenis }}%
                        @else
                            -
                        @endif
                    </td>

                    <td class="admin-actions">
                        <a href="{{ route('admin.masinas.edit', $m->id) }}" class="btn-small btn-warn" style="text-decoration: none;">
                            Rediģēt
                        </a>

                        @if($m->statuss === 'neaktīva')
                            <form method="POST" action="{{ route('admin.masinas.activate', $m->id) }}">
                                @csrf
                                @method('PATCH')

                                <button type="submit" class="btn-small btn-warn">
                                    Aktivizēt
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.masinas.deactivate', $m->id) }}" onsubmit="return confirm('Deaktivizēt mašīnu?')">
                                @csrf
                                @method('PATCH')

                                <button type="submit" class="btn-small btn-danger">
                                    Deaktivizēt
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $masinas->links() }}
</x-admin-layout>