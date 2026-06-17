<x-layout>
    <div class="reservations-page">

        <div class="reservations-header">
            <h1>{{ __('messages.your_reservation') }}</h1>
            <p>{{ __('messages.your_reservation_desc') }}</p>
        </div>

        @forelse ($reservations as $reservation)
            <div class="reservation-card">

                <div class="reservation-card-top">
                    <div>
                        <h2>
                            {{ $reservation->masina->modelis->marka }}
                            {{ $reservation->masina->modelis->modelis }}
                        </h2>
                    </div>

                    <div class="reservation-year">
                        {{ $reservation->masina->gads }}
                    </div>
                </div>

                <div class="reservation-main-info">
                    <div class="registration-box">
                        <span>{{ __('messages.registration_no') }}</span>
                        <strong>{{ $reservation->masina->registracijas_nr }}</strong>
                    </div>

                    <div class="reserved-time">
                        <span>{{ __('messages.reserved_at') }}</span>
                        <strong>{{ $reservation->created_at->format('d.m.Y H:i') }}</strong>
                    </div>
                </div>

                <div class="reservation-details">
                    <div class="detail-item">
                        <span>{{ __('messages.transmission') }}</span>
                        <strong>{{ $reservation->masina->modelis->transmisija }}</strong>
                    </div>

                    <div class="detail-item">
                        <span>{{ __('messages.fuel_type') }}</span>
                        <strong>{{ $reservation->masina->modelis->degvielas_tips }}</strong>
                    </div>

                    <div class="detail-item">
                        <span>{{ __('messages.seats') }}</span>
                        <strong>{{ $reservation->masina->modelis->vietu_skaits }}</strong>
                    </div>
                </div>

                <div class="reservation-actions">
                    <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-cancel" type="submit">
                            {{ __('messages.cancel_reservation') }}
                        </button>
                    </form>

                    <form action="{{ route('ride.begin', $reservation->masina_id) }}" method="POST">
                        @csrf
                        <button class="btn btn-begin" type="submit">
                            {{ __('messages.begin_ride') }}
                        </button>
                    </form>
                </div>

            </div>
        @empty
            <div class="empty-reservation-card">
                <div class="empty-icon">🚘</div>
                <h2>{{ __('messages.no_active_reservation') }}</h2>
                <p>{{ __('messages.no_active_reservation_desc') }}</p>
                <a href="/" class="empty-link">{{ __('messages.find_a_car') }}</a>
            </div>
        @endforelse

    </div>
</x-layout>
