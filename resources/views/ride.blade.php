<x-layout>
    <div class="ride-page">

        <div id="ride-view" class="ride-card">
            <div class="ride-header">
                <span class="page-badge">Active ride</span>
                <h1>Your ride is active</h1>
                <p>Track your ride time, distance and estimated price in real time.</p>
            </div>

            <div class="ride-stats">
                <div class="ride-stat">
                    <span>Time</span>
                    <strong id="timer">00:00:00</strong>
                </div>

                <div class="ride-stat">
                    <span>Distance</span>
                    <strong><span id="distance">0.00</span> km</strong>
                </div>

                <div class="ride-stat">
                    <span>Price</span>
                    <strong><span id="price">0.00</span> €</strong>
                </div>
            </div>

            <div class="gps-status" id="gps-status">
                Waiting for GPS permission...
            </div>

            <div id="ride-map"></div>

            <button id="end-ride-btn" class="ride-end-btn">
                End Ride
            </button>
        </div>

        <div id="ride-summary" class="ride-card ride-summary-card" style="display:none">
            <div class="ride-header">
                <span class="page-badge">Ride summary</span>
                <h1>Ride finished</h1>
                <p>Check your ride summary and continue to payment.</p>
            </div>

            <div class="ride-stats">
                <div class="ride-stat">
                    <span>Time</span>
                    <strong id="summary-time"></strong>
                </div>

                <div class="ride-stat">
                    <span>Distance</span>
                    <strong><span id="summary-distance"></span> km</strong>
                </div>

                <div class="ride-stat">
                    <span>Price bez PVN</span>
                    <strong><span id="summary-price"></span> €</strong>
                </div>
            </div>

            <button id="pay-btn" class="ride-pay-btn">
                Apmaksāt
            </button>

            <div id="payment-success" class="payment-success" style="display:none">
                <h2>✅ Maksājums veikts!</h2>
                <p>Summa bez PVN: <strong><span id="paid-summa-bez-pvn"></span> €</strong></p>
                <p>Summa ar PVN: <strong><span id="paid-summa-ar-pvn"></span> €</strong></p>
                <p>Veids: <strong><span id="paid-veids"></span></strong></p>
                <p>Datums: <strong><span id="paid-datums"></span></strong></p>
            </div>

            <a href="/" class="ride-back-link">Back to map</a>
        </div>

    </div>

    <script>
        const rideId = {{ $ride->id }};
        const csrfToken = "{{ csrf_token() }}";

        let startTime = Date.now();
        let totalDistance = 0;
        let lastPosition = null;
        let watchId = null;

        let rideMap = null;
        let userMarker = null;
        let routePath = null;

        const gpsStatus = document.getElementById('gps-status');

        function formatTime(totalSeconds) {
            const hours = Math.floor(totalSeconds / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            const seconds = Math.floor(totalSeconds % 60);

            return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        }

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

        function getDistance(lat1, lng1, lat2, lng2) {
            const R = 6371;
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLng = (lng2 - lng1) * Math.PI / 180;

            const a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(lat1 * Math.PI / 180) *
                Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLng / 2) *
                Math.sin(dLng / 2);

            return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        }

        function setGpsStatus(message, type = '') {
            gpsStatus.textContent = message;
            gpsStatus.className = 'gps-status';

            if (type) {
                gpsStatus.classList.add(type);
            }
        }

        let rideMapInitialized = false;

        window.initRideMap = function () {
            if (rideMapInitialized) return;
            rideMapInitialized = true;

            const defaultPosition = { lat: 56.9496, lng: 24.1052 };

            rideMap = new google.maps.Map(document.getElementById('ride-map'), {
                center: defaultPosition,
                zoom: 15,
            });

            routePath = new google.maps.Polyline({
                path: [],
                geodesic: true,
                strokeColor: '#44AAC9',
                strokeOpacity: 1.0,
                strokeWeight: 5,
                map: rideMap,
            });

            startGpsTracking();
        };

        function updateMapPosition(lat, lng) {
            if (!rideMap) return;

            const position = { lat, lng };

            if (!userMarker) {
                userMarker = new google.maps.Marker({
                    position,
                    map: rideMap,
                    title: 'Your location',
                });
            } else {
                userMarker.setPosition(position);
            }

            rideMap.panTo(position);

            const path = routePath.getPath();
            path.push(new google.maps.LatLng(lat, lng));
        }

        function startGpsTracking() {
            if (!navigator.geolocation) {
                setGpsStatus('GPS is not supported by this browser.', 'error');
                return;
            }

            setGpsStatus('Please allow GPS/location access...', '');

            watchId = navigator.geolocation.watchPosition(
                (pos) => {
                    const { latitude, longitude, accuracy } = pos.coords;

                    setGpsStatus(`GPS active. Accuracy: ${Math.round(accuracy)}m`, 'success');

                    if (lastPosition) {
                        const segmentDistance = getDistance(
                            lastPosition.lat,
                            lastPosition.lng,
                            latitude,
                            longitude
                        );

                        /*
                            Filtrs pret GPS "lēkāšanu":
                            - mazāk par 5m ignorē
                            - vairāk par 2km starp punktiem ignorē kā kļūdu
                        */
                        if (segmentDistance > 0.005 && segmentDistance < 2) {
                            totalDistance += segmentDistance;
                            document.getElementById('distance').textContent = totalDistance.toFixed(2);
                        }
                    }

                    lastPosition = {
                        lat: latitude,
                        lng: longitude,
                    };

                    updateMapPosition(latitude, longitude);
                },
                (error) => {
                    if (error.code === error.PERMISSION_DENIED) {
                        setGpsStatus('GPS permission denied. Distance cannot be tracked.', 'error');
                    } else if (error.code === error.POSITION_UNAVAILABLE) {
                        setGpsStatus('GPS position unavailable.', 'error');
                    } else if (error.code === error.TIMEOUT) {
                        setGpsStatus('GPS request timed out.', 'error');
                    } else {
                        setGpsStatus('GPS error occurred.', 'error');
                    }
                },
                {
                    enableHighAccuracy: true,
                    maximumAge: 1000,
                    timeout: 10000,
                }
            );
        }

        setInterval(() => {
            const elapsedSeconds = Math.floor((Date.now() - startTime) / 1000);
            document.getElementById('timer').textContent = formatTime(elapsedSeconds);

            const mins = elapsedSeconds / 60;
            const price = (mins * 0.50) + (totalDistance * 0.20);

            document.getElementById('price').textContent = price.toFixed(2);
        }, 1000);

        document.getElementById('end-ride-btn').addEventListener('click', async () => {
            if (watchId !== null) {
                navigator.geolocation.clearWatch(watchId);
            }

            const response = await fetch(`/ride/${rideId}/end`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    distance: totalDistance
                })
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
                window.location.href = data.url;
            } else {
                const error = await response.json();
                alert(error.error || 'Kļūda apmaksas izveidē.');
            }
        });
        document.addEventListener('DOMContentLoaded', () => {
            if (window.google && google.maps && document.getElementById('ride-map')) {
                window.initRideMap();
            }
        });
    </script>
</x-layout>