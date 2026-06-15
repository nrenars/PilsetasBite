<x-layout>
    <form action="{{ route('review.submit', $ride->id) }}" method="POST">
        @csrf

        <label for="vertejums">Rating:</label>
        <select name="vertejums" id="vertejums" required>
            <option value="">-- Select --</option>
            <option value="1">1 - Poor</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5 - Excellent</option>
        </select>

        <br><br>

        <label for="komentars">Comment:</label>
        <textarea name="komentars" id="komentars" cols="30" rows="10" required></textarea>

        <br>

        <button type="submit">Submit</button>
    </form>

    <a href="/">No thanks</a>
</x-layout>