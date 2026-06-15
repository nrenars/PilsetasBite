<x-layout>
    @foreach ($reservations as $reservation)
        <h1>{{ __('messages.your_reservations') }}</h1>
            <div class="reservation">
                {{$reservation->masina->modelis->marka}} {{$reservation->masina->modelis->modelis}}
                {{$reservation->created_at}}
                <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">
                        {{ __('messages.cancel_reservation') }}
                    </button>
                </form>
                <form action="{{ route('ride.begin', $reservation->masina_id) }}" method="POST">
                    @csrf
                    <button type="submit">{{ __('messages.begin_ride') }}</button>
                </form>
            </div>
    @endforeach
</x-layout>
