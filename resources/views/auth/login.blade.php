<x-layout title="Login">
    <div class="auth-page">
        <div class="auth-card auth-card-small">
            <div class="auth-header">
                <span class="page-badge">{{ __('messages.welcome_back') }}</span>
                <h1>{{ __('messages.login_title') }}</h1>
                <p>{{ __('messages.login_subtitle') }}</p>
            </div>

            <form action="{{ route('login') }}" method="POST" class="auth-form">
                @csrf

                <div class="form-group">
                    <label for="epasts">{{ __('messages.email') }}</label>
                    <input
                        type="email"
                        id="epasts"
                        name="epasts"
                        required
                        value="{{ old('epasts') }}"
                        placeholder="example@email.com"
                    >
                    @error('epasts')
                        <small class="form-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="parole">{{ __('messages.password') }}</label>
                    <input
                        type="password"
                        id="parole"
                        name="parole"
                        required
                        placeholder="{{ __('messages.enter_your_password') }}"
                    >
                    @error('parole')
                        <small class="form-error">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="auth-submit">
                    {{ __('messages.login_btn') }}
                </button>
            </form>
        </div>
    </div>
</x-layout>
