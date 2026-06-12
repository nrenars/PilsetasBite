<x-layout>
    @foreach ($reservations as $reservation)
    <h1>Your Reservations</h1>
        <div class="reservation">
            {{$reservation->masina->modelis->marka}} {{$reservation->masina->modelis->modelis}}
            {{$reservation->created_at}}
            <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">
                    Cancel Reservation
                </button>
            </form>
        </div>
    @endforeach
</x-layout>