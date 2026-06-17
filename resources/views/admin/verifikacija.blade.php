<x-admin-layout>
    <h1>Vadītāja apliecību verifikācija</h1>

    @if($lietotaji->count() === 0)
        <div class="stat-card" style="align-items: flex-start; margin-bottom: 1rem;">
            <div class="stat-number" style="font-size: 1.2rem;">Nav gaidošu verifikāciju</div>
            <div class="stat-label">
                Šobrīd nav lietotāju, kuri gaida vadītāja apliecības pārbaudi.
            </div>
        </div>
    @else
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Lietotājs</th>
                    <th>E-pasts</th>
                    <th>Telefons</th>
                    <th>Apliecības nr.</th>
                    <th>Derīga līdz</th>
                    <th>Statuss</th>
                    <th>Attēls</th>
                    <th>Darbības</th>
                </tr>
            </thead>

            <tbody>
                @foreach($lietotaji as $lietotajs)
                    <tr>
                        <td>{{ $lietotajs->id }}</td>

                        <td>
                            {{ $lietotajs->pilns_vards ?? ($lietotajs->vards . ' ' . $lietotajs->uzvards) }}
                        </td>

                        <td>{{ $lietotajs->epasts }}</td>

                        <td>{{ $lietotajs->telefons }}</td>

                        <td>
                            {{ $lietotajs->vaditaja_apliecibas_nr ?? '—' }}
                        </td>

                        <td>
                            {{ $lietotajs->vaditaja_apliecibas_termins ?? '—' }}
                        </td>

                        <td>
                            {{ $lietotajs->vaditaja_apliecibas_statuss ?? '—' }}
                        </td>

                        <td>
                            @if($lietotajs->vaditaja_apliecibas_attels)
                                <a
                                    href="{{ asset('storage/' . $lietotajs->vaditaja_apliecibas_attels) }}"
                                    target="_blank"
                                >
                                    Skatīt
                                </a>
                            @else
                                —
                            @endif
                        </td>

                        <td>
                            <div class="admin-actions">
                                <form
                                    method="POST"
                                    action="{{ route('admin.verifikacija.apstiprinat', $lietotajs->id) }}"
                                    onsubmit="return confirm('Apstiprināt vadītāja apliecību?')"
                                >
                                    @csrf
                                    @method('PUT')

                                    <button type="submit" class="btn-small" style="background:#22c55e; color:#fff;">
                                        Apstiprināt
                                    </button>
                                </form>

                                <form
                                    method="POST"
                                    action="{{ route('admin.verifikacija.noraidit', $lietotajs->id) }}"
                                    onsubmit="return confirm('Noraidīt vadītāja apliecību?')"
                                >
                                    @csrf
                                    @method('PUT')

                                    <button type="submit" class="btn-small btn-danger">
                                        Noraidīt
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $lietotaji->links() }}
    @endif
</x-admin-layout>