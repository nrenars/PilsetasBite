<x-admin-layout>
    <h1>Admin panelis</h1>

    <div class="admin-stats">
        <div class="stat-card">
            <span class="stat-number">{{ $stats['lietotaji'] }}</span>
            <span class="stat-label">Lietotāji</span>
        </div>
        <div class="stat-card">
            <span class="stat-number">{{ $stats['masinas'] }}</span>
            <span class="stat-label">Mašīnas</span>
        </div>
        <div class="stat-card">
            <span class="stat-number">{{ $stats['rezervacijas'] }}</span>
            <span class="stat-label">Rezervācijas</span>
        </div>
        <div class="stat-card">
            <span class="stat-number">{{ $stats['braucieni'] }}</span>
            <span class="stat-label">Braucieni</span>
        </div>
        <div class="stat-card">
            <span class="stat-number">{{ $stats['verifikacijas'] }}</span>
            <span class="stat-label">Verifikacijas</span>
        </div>
        
    </div>
</x-admin-layout>
