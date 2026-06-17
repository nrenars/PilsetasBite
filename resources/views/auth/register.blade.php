<x-layout title="Register">
    <div class="auth-page">
        <div class="auth-card">
            <div class="auth-header">
                <span class="page-badge">{{ __('messages.create_account') }}</span>
                <h1>{{ __('messages.register_title') }}</h1>
                <p>{{ __('messages.register_subtitle') }}</p>
            </div>

            <form action="{{ route('register') }}" method="POST" class="auth-form" enctype="multipart/form-data">
                @csrf

                <div class="form-grid">
                    <div class="form-group">
                        <label for="vards">{{ __('messages.first_name') }}</label>
                        <input
                            type="text"
                            id="vards"
                            name="vards"
                            required
                            value="{{ old('vards') }}"
                            placeholder="{{ __('messages.enter_first_name') }}"
                        >
                        @error('vards')
                            <small class="form-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="uzvards">{{ __('messages.last_name') }}</label>
                        <input
                            type="text"
                            id="uzvards"
                            name="uzvards"
                            required
                            value="{{ old('uzvards') }}"
                            placeholder="{{ __('messages.enter_last_name') }}"
                        >
                        @error('uzvards')
                            <small class="form-error">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

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
                    <label for="telefons">{{ __('messages.phone') }}</label>
                    <input
                        type="tel"
                        id="telefons"
                        name="telefons"
                        required
                        value="{{ old('telefons') }}"
                        placeholder="+371..."
                    >
                    @error('telefons')
                        <small class="form-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="parole">{{ __('messages.password') }}</label>
                        <input
                            type="password"
                            id="parole"
                            name="parole"
                            required
                            placeholder="{{ __('messages.enter_password') }}"
                        >
                        @error('parole')
                            <small class="form-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="parole_confirmation">{{ __('messages.confirm_password') }}</label>
                        <input
                            type="password"
                            id="parole_confirmation"
                            name="parole_confirmation"
                            required
                            placeholder="{{ __('messages.confirm_password_ph') }}"
                        >
                        @error('parole_confirmation')
                            <small class="form-error">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="vaditaja_apliecibas_nr">Driver license number</label>
                        <input
                            type="text"
                            id="vaditaja_apliecibas_nr"
                            name="vaditaja_apliecibas_nr"
                            required
                            value="{{ old('vaditaja_apliecibas_nr') }}"
                            placeholder="Enter license number"
                        >
                        @error('vaditaja_apliecibas_nr')
                            <small class="form-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="vaditaja_apliecibas_termins">License expiry date</label>
                        <input
                            type="date"
                            id="vaditaja_apliecibas_termins"
                            name="vaditaja_apliecibas_termins"
                            required
                            value="{{ old('vaditaja_apliecibas_termins') }}"
                        >
                        @error('vaditaja_apliecibas_termins')
                            <small class="form-error">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="vaditaja_apliecibas_attels">Driver license image</label>
                    <input
                        type="file"
                        id="vaditaja_apliecibas_attels"
                        name="vaditaja_apliecibas_attels"
                        accept="image/*"
                        required
                    >
                    @error('vaditaja_apliecibas_attels')
                        <small class="form-error">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="auth-submit">
                    {{ __('messages.register') }}
                </button>
            </form>
        </div>
    </div>
</x-layout>
