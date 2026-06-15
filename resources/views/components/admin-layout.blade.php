<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin – PilsetasBite</title>
    @vite(['resources/css/app.css'])
    <style>
        body { font-family: sans-serif; margin: 0; }
        .admin-wrapper { display: flex; min-height: 100vh; }
        .admin-sidebar { width: 220px; background: #1a1a2e; color: #fff; padding: 1.5rem 1rem; flex-shrink: 0; }
        .admin-sidebar h2 { font-size: 1rem; margin-bottom: 1.5rem; color: #aaa; text-transform: uppercase; letter-spacing: 0.05em; }
        .admin-sidebar a { display: block; color: #ddd; text-decoration: none; padding: 0.5rem 0.75rem; border-radius: 6px; margin-bottom: 0.25rem; }
        .admin-sidebar a:hover, .admin-sidebar a.active { background: #16213e; color: #fff; }
        .admin-content { flex: 1; padding: 2rem; background: #f5f5f5; }
        .admin-content h1 { margin-top: 0; }
        .admin-stats { display: flex; gap: 1rem; flex-wrap: wrap; margin-bottom: 2rem; }
        .stat-card { background: #fff; border-radius: 8px; padding: 1.5rem 2rem; box-shadow: 0 1px 4px rgba(0,0,0,.1); display: flex; flex-direction: column; align-items: center; min-width: 120px; }
        .stat-number { font-size: 2rem; font-weight: bold; color: #1a1a2e; }
        .stat-label { color: #666; font-size: 0.85rem; margin-top: 0.25rem; }
        .admin-table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,.1); }
        .admin-table th { background: #1a1a2e; color: #fff; padding: 0.75rem 1rem; text-align: left; font-size: 0.85rem; }
        .admin-table td { padding: 0.65rem 1rem; border-bottom: 1px solid #eee; font-size: 0.9rem; vertical-align: middle; }
        .admin-table tr:last-child td { border-bottom: none; }
        .admin-actions { display: flex; gap: 0.5rem; flex-wrap: wrap; }
        .btn-small { padding: 0.3rem 0.7rem; border: none; border-radius: 4px; cursor: pointer; font-size: 0.8rem; }
        .btn-danger { background: #dc3545; color: #fff; }
        .btn-warn { background: #fd7e14; color: #fff; }
        .alert-success { background: #d4edda; color: #155724; padding: 0.75rem 1rem; border-radius: 6px; margin-bottom: 1rem; }
    </style>
</head>
<body>
<div class="admin-wrapper">
    <aside class="admin-sidebar">
        <h2>Admin panelis</h2>
        <a href="{{ route('admin.index') }}" @class(['active' => request()->routeIs('admin.index')])>Pārskats</a>
        <a href="{{ route('admin.lietotaji') }}" @class(['active' => request()->routeIs('admin.lietotaji')])>Lietotāji</a>
        <a href="{{ route('admin.rezervacijas') }}" @class(['active' => request()->routeIs('admin.rezervacijas')])>Rezervācijas</a>
        <a href="{{ route('admin.braucieni') }}" @class(['active' => request()->routeIs('admin.braucieni')])>Braucieni</a>
        <a href="{{ route('admin.atsauksmes') }}" @class(['active' => request()->routeIs('admin.atsauksmes')])>Atsauksmes</a>
        <hr style="border-color:#333; margin: 1rem 0;">
        <a href="{{ route('welcome') }}">← Uz sākumu</a>
    </aside>
    <main class="admin-content">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        {{ $slot }}
    </main>
</div>
</body>
</html>
