<x-layout>
    <div class="reservations-page">

        <div class="reservations-header">
            <span class="page-badge">Reservation</span>
            <h1>Your Reservation</h1>
            <p>Here you can view your active reservation, cancel it, or begin your ride.</p>
        </div>

        @forelse ($reservations as $reservation)
            <div class="reservation-card">

                <div class="reservation-card-top">
                    <div>
                        <h2>
                            {{ $reservation->masina->modelis->marka }}
                            {{ $reservation->masina->modelis->modelis }}
                        </h2>

                        <span class="reservation-status">
                            Active Reservation
                        </span>
                    </div>

                    <div class="reservation-year">
                        {{ $reservation->masina->gads }}
                    </div>
                </div>

                <div class="reservation-main-info">
                    <div class="registration-box">
                        <span>Registration No.</span>
                        <strong>{{ $reservation->masina->registracijas_nr }}</strong>
                    </div>

                    <div class="reserved-time">
                        <span>Reserved at</span>
                        <strong>{{ $reservation->created_at->format('d.m.Y H:i') }}</strong>
                    </div>
                </div>

                <div class="reservation-details">
                    <div class="detail-item">
                        <span>Transmission</span>
                        <strong>{{ $reservation->masina->modelis->transmisija }}</strong>
                    </div>

                    <div class="detail-item">
                        <span>Fuel type</span>
                        <strong>{{ $reservation->masina->modelis->degvielas_tips }}</strong>
                    </div>

                    <div class="detail-item">
                        <span>Seats</span>
                        <strong>{{ $reservation->masina->modelis->vietu_skaits }}</strong>
                    </div>
                </div>

                <div class="reservation-actions">
                    <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-cancel" type="submit">
                            Cancel Reservation
                        </button>
                    </form>

                    <form action="{{ route('ride.begin', $reservation->masina_id) }}" method="POST">
                        @csrf
                        <button class="btn btn-begin" type="submit">
                            Begin Ride
                        </button>
                    </form>
                </div>

            </div>
        @empty
            <div class="empty-reservation-card">
                <div class="empty-icon">🚘</div>
                <h2>No active reservation</h2>
                <p>You currently do not have an active car reservation.</p>
                <a href="/" class="empty-link">Find a car</a>
            </div>
        @endforelse

    </div>
</x-layout>