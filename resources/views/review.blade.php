<x-layout>
    <form action="{{ route('review.submit', $ride->id) }}" method="POST">
        @csrf

        <label for="vertejums">{{ __('messages.rating') }}:</label>
        <select name="vertejums" id="vertejums" required>
            <option value="">{{ __('messages.select') }}</option>
            <option value="1">1 - {{ __('messages.poor') }}</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5 - {{ __('messages.excellent') }}</option>
        </select>

        <br><br>

        <label for="komentars">{{ __('messages.comment') }}:</label>
        <textarea name="komentars" id="komentars" cols="30" rows="10" required></textarea>

        <br>

        <button type="submit">{{ __('messages.submit') }}</button>
    </form>

    <a href="/">{{ __('messages.no_thanks') }}</a>
</x-layout>
