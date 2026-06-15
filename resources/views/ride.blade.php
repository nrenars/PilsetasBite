<x-layout>

    <div id="ride-view">
        <p>Time: <span id="timer">00:00:00</span></p>
        <p>Distance: <span id="distance">0.00</span> km</p>
        <p>Price: <span id="price">0.00</span> €</p>
        
        <button id="end-ride-btn">End Ride</button>
    </div>

    <div id="ride-summary" style="display:none">
        <p>Time: <span id="summary-time"></span></p>
        <p>Distance: <span id="summary-distance"></span> km</p>
        <p>Price (bez PVN): <span id="summary-price"></span> €</p>

        <button id="pay-btn">Apmaksāt</button>

        <div id="payment-success" style="display:none">
            <p>✅ Maksājums veikts!</p>
            <p>Summa bez PVN: <span id="paid-summa-bez-pvn"></span> €</p>
            <p>Summa ar PVN: <span id="paid-summa-ar-pvn"></span> €</p>
            <p>Veids: <span id="paid-veids"></span></p>
            <p>Datums: <span id="paid-datums"></span></p>
        </div>

        <a href="/">Back</a>
    </div>

    <script>
        const rideId = {{ $ride->id }};
        const csrfToken = "{{ csrf_token() }}";
        
        let startTime = Date.now();
        let totalDistance = 0;
        let lastPosition = null;

        // Funkcija laika formatēšanai HH:MM:SS
        function formatTime(totalSeconds) {
            const hours = Math.floor(totalSeconds / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            const seconds = Math.floor(totalSeconds % 60);
            return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        }

        // Funkcija laika formatēšanai "Xh Ymin Zs" formātā
        function formatTimeReadable(totalSeconds) {
            const hours = Math.floor(totalSeconds / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            const seconds = Math.floor(totalSeconds % 60);

            let parts = [];
            if (hours > 0) parts.push(`${hours}h`);
            if (minutes > 0) parts.push(`${minutes}min`);
            parts.push(`${seconds}s`);

            return parts.join(' ');
        }

        // Taimeris
        setInterval(() => {
            const elapsedSeconds = Math.floor((Date.now() - startTime) / 1000);
            document.getElementById('timer').textContent = formatTime(elapsedSeconds);

            // Aptuvenā cena reāllaikā
            const mins = elapsedSeconds / 60;
            const price = (mins * 0.50) + (totalDistance * 0.20);
            document.getElementById('price').textContent = price.toFixed(2);
        }, 1000);

        // GPS distance aprēķins
        function getDistance(lat1, lng1, lat2, lng2) {
            const R = 6371; // Zemes rādiuss km
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLng = (lng2 - lng1) * Math.PI / 180;
            const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                      Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                      Math.sin(dLng/2) * Math.sin(dLng/2);
            return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        }

        // Seko GPS pozīcijai
        if (navigator.geolocation) {
            navigator.geolocation.watchPosition((pos) => {
                const { latitude, longitude } = pos.coords;
                
                if (lastPosition) {
                    totalDistance += getDistance(
                        lastPosition.lat, lastPosition.lng,
                        latitude, longitude
                    );
                    document.getElementById('distance').textContent = totalDistance.toFixed(2);
                }
                
                lastPosition = { lat: latitude, lng: longitude };
            });
        }

        // Beigt braucienu
        document.getElementById('end-ride-btn').addEventListener('click', async () => {
            const response = await fetch(`/ride/${rideId}/end`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ distance: totalDistance })
            });

            if (response.ok) {
                const data = await response.json();
                document.getElementById('ride-view').style.display = 'none';
                document.getElementById('ride-summary').style.display = 'block';
                document.getElementById('summary-time').textContent = formatTimeReadable(data.seconds);
                document.getElementById('summary-distance').textContent = data.distance.toFixed(2);
                document.getElementById('summary-price').textContent = data.cena.toFixed(2);
            }
        });

        document.getElementById('pay-btn').addEventListener('click', async () => {
        const response = await fetch(`/ride/${rideId}/pay`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        });

        if (response.ok) {
            const data = await response.json();
            // Pāradresācija uz Stripe Checkout lapu
            window.location.href = data.url;
        } else {
            const error = await response.json();
            alert(error.error || 'Kļūda apmaksas izveidē.');
        }
    });
    </script>
</x-layout>