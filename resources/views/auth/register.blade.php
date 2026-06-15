<x-layout title="Register">
    <div class="auth-page">
        <div class="auth-card">
            <div class="auth-header">
                <span class="page-badge">Create account</span>
                <h1>Register</h1>
                <p>Create your account to reserve and use cars.</p>
            </div>

            <form action="{{ route('register') }}" method="POST" class="auth-form">
                @csrf

                <div class="form-grid">
                    <div class="form-group">
                        <label for="vards">First Name</label>
                        <input
                            type="text"
                            id="vards"
                            name="vards"
                            required
                            value="{{ old('vards') }}"
                            placeholder="Enter first name"
                        >
                        @error('vards')
                            <small class="form-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="uzvards">Last Name</label>
                        <input
                            type="text"
                            id="uzvards"
                            name="uzvards"
                            required
                            value="{{ old('uzvards') }}"
                            placeholder="Enter last name"
                        >
                        @error('uzvards')
                            <small class="form-error">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="epasts">Email address</label>
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
                    <label for="telefons">Phone</label>
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
                        <label for="parole">Password</label>
                        <input
                            type="password"
                            id="parole"
                            name="parole"
                            required
                            placeholder="Password"
                        >
                        @error('parole')
                            <small class="form-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="parole_confirmation">Confirm Password</label>
                        <input
                            type="password"
                            id="parole_confirmation"
                            name="parole_confirmation"
                            required
                            placeholder="Confirm password"
                        >
                        @error('parole_confirmation')
                            <small class="form-error">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="auth-submit">
                    Register
                </button>
            </form>
        </div>
    </div>
</x-layout>