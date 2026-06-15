<x-layout title="Login">
    <div class="auth-page">
        <div class="auth-card auth-card-small">
            <div class="auth-header">
                <span class="page-badge">Welcome back</span>
                <h1>Login</h1>
                <p>Log in to reserve cars and manage your rides.</p>
            </div>

            <form action="{{ route('login') }}" method="POST" class="auth-form">
                @csrf

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
                    <label for="parole">Password</label>
                    <input
                        type="password"
                        id="parole"
                        name="parole"
                        required
                        placeholder="Enter your password"
                    >
                    @error('parole')
                        <small class="form-error">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="auth-submit">
                    Login
                </button>
            </form>
        </div>
    </div>
</x-layout>