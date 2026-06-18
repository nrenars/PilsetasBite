<x-layout>
    <div class="ride-page">

        <div id="ride-view" class="ride-card">
            <div class="ride-header">
                <span class="page-badge">{{ __('messages.active_ride') }}</span>
                <h1>{{ __('messages.your_ride_is_active') }}</h1>
                <p>{{ __('messages.ride_tracking_description') }}</p>
            </div>

            <div class="ride-stats">
                <div class="ride-stat">
                    <span>{{ __('messages.time') }}</span>
                    <strong id="timer">00:00:00</strong>
                </div>

                <div class="ride-stat">
                    <span>{{ __('messages.distance') }}</span>
                    <strong><span id="distance">0.00</span> km</strong>
                </div>

                <div class="ride-stat">
                    <span>{{ __('messages.price') }}</span>
                    <strong><span id="price">0.00</span> €</strong>
                </div>
            </div>

            <div class="gps-status" id="gps-status">
                {{ __('messages.waiting_gps_permission') }}
            </div>

            <div id="ride-map"></div>

            <button id="end-ride-btn" class="ride-end-btn">
                {{ __('messages.end_ride') }}
            </button>
        </div>

        <div id="ride-summary" class="ride-card ride-summary-card" style="display:none">
            <div class="ride-header">
                <span class="page-badge">{{ __('messages.ride_summary') }}</span>
                <h1>{{ __('messages.ride_finished') }}</h1>
                <p>{{ __('messages.ride_summary_description') }}</p>
            </div>

            <div class="ride-stats">
                <div class="ride-stat">
                    <span>{{ __('messages.time') }}</span>
                    <strong id="summary-time"></strong>
                </div>

                <div class="ride-stat">
                    <span>{{ __('messages.distance') }}</span>
                    <strong><span id="summary-distance"></span> km</strong>
                </div>

                <div class="ride-stat">
                    <span>{{ __('messages.amount_no_vat') }}</span>
                    <strong><span id="summary-price"></span> €</strong>
                </div>
            </div>

            <button id="pay-btn" class="ride-pay-btn">
                {{ __('messages.pay') }}
            </button>

            <div id="payment-success" class="payment-success" style="display:none">
                <h2>✅ {{ __('messages.payment_success') }}</h2>
                <p>{{ __('messages.amount_no_vat') }}: <strong><span id="paid-summa-bez-pvn"></span> €</strong></p>
                <p>{{ __('messages.amount_with_vat') }}: <strong><span id="paid-summa-ar-pvn"></span> €</strong></p>
                <p>{{ __('messages.method') }}: <strong><span id="paid-veids"></span></strong></p>
                <p>{{ __('messages.date') }}: <strong><span id="paid-datums"></span></strong></p>
            </div>

            <a href="/" class="ride-back-link">{{ __('messages.back_to_map') }}</a>
        </div>

    </div>

    <script>
        const rideId = {{ $ride->id }};
        const csrfToken = "{{ csrf_token() }}";

        const rideI18n = {
            waitingGpsPermission: @json(__('messages.waiting_gps_permission')),
            gpsNotSupported: @json(__('messages.gps_not_supported')),
            allowGpsAccess: @json(__('messages.allow_gps_access')),
            gpsActiveAccuracy: @json(__('messages.gps_active_accuracy')),
            gpsPermissionDenied: @json(__('messages.gps_permission_denied')),
            gpsPositionUnavailable: @json(__('messages.gps_position_unavailable')),
            gpsRequestTimedOut: @json(__('messages.gps_request_timed_out')),
            gpsErrorOccurred: @json(__('messages.gps_error_occurred')),
            yourLocation: @json(__('messages.your_location')),
            paymentCreationError: @json(__('messages.payment_creation_error')),
            hourShort: @json(__('messages.hour_short')),
            minuteShort: @json(__('messages.minute_short')),
            secondShort: @json(__('messages.second_short')),
        };

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

            if (hours > 0) parts.push(`${hours}${rideI18n.hourShort}`);
            if (minutes > 0) parts.push(`${minutes}${rideI18n.minuteShort}`);
            parts.push(`${seconds}${rideI18n.secondShort}`);

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
                    title: rideI18n.yourLocation,
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
                setGpsStatus(rideI18n.gpsNotSupported, 'error');
                return;
            }

            setGpsStatus(rideI18n.allowGpsAccess, '');

            watchId = navigator.geolocation.watchPosition(
                (pos) => {
                    const { latitude, longitude, accuracy } = pos.coords;

                    setGpsStatus(
                        rideI18n.gpsActiveAccuracy.replace(':accuracy', Math.round(accuracy)),
                        'success'
                    );

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
                        setGpsStatus(rideI18n.gpsPermissionDenied, 'error');
                    } else if (error.code === error.POSITION_UNAVAILABLE) {
                        setGpsStatus(rideI18n.gpsPositionUnavailable, 'error');
                    } else if (error.code === error.TIMEOUT) {
                        setGpsStatus(rideI18n.gpsRequestTimedOut, 'error');
                    } else {
                        setGpsStatus(rideI18n.gpsErrorOccurred, 'error');
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
                alert(error.error || rideI18n.paymentCreationError);
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            if (window.google && google.maps && document.getElementById('ride-map')) {
                window.initRideMap();
            }
        });
    </script>
</x-layout>