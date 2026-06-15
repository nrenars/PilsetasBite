<!DOCTYPE html>
<html>
<head>
    <title>Admin panelis</title>
</head>
<body>

    <h1>Admin panelis</h1>

    <p>Sveiks, {{ auth()->user()->name }}!</p>

    <h2>Pārvaldība</h2>

    <ul>
        <li>Lietotāji</li>
        <li>Rezervācijas</li>
        <li>Braucieni</li>
        <li>Atsauksmes</li>
    </ul>

</body>
</html>