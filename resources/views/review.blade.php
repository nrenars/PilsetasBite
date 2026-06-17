<x-layout>
    <div class="review-page">
        <div class="review-card">

            <div class="review-header">
                <span class="page-badge">Review</span>
                <h1>{{ __('messages.rating') }}</h1>
                <p>Tell us how your ride went. Your feedback helps improve the service.</p>
            </div>

            <form action="{{ route('review.submit', $ride->id) }}" method="POST" class="review-form">
                @csrf

                <div class="form-group">
                    <label for="vertejums">{{ __('messages.rating') }}</label>
                    <select name="vertejums" id="vertejums" required>
                        <option value="">{{ __('messages.select') }}</option>
                        <option value="1">1 - {{ __('messages.poor') }}</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5 - {{ __('messages.excellent') }}</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="komentars">{{ __('messages.comment') }}</label>
                    <textarea
                        name="komentars"
                        id="komentars"
                        rows="7"
                        required
                        placeholder="Write your comment here..."
                    ></textarea>
                </div>

                <div class="review-actions">
                    <a href="/" class="review-secondary">
                        {{ __('messages.no_thanks') }}
                    </a>

                    <button type="submit" class="review-submit">
                        {{ __('messages.submit') }}
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-layout>