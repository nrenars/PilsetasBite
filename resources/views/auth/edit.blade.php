<x-layout title="Edit Profile">
    <div class="auth-page">
        <div class="auth-card">
            <div class="auth-header">
                <span class="page-badge">Account settings</span>
                <h1>Edit Profile</h1>
                <p>Update your personal information. Leave password fields empty if you do not want to change it.</p>
            </div>

            <form method="POST" action="{{ route('auth.update') }}" class="auth-form">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="form-group">
                        <label for="vards">First Name</label>
                        <input
                            type="text"
                            id="vards"
                            name="vards"
                            value="{{ old('vards', $lietotajs->vards) }}"
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
                            value="{{ old('uzvards', $lietotajs->uzvards) }}"
                            placeholder="Enter last name"
                        >
                        @error('uzvards')
                            <small class="form-error">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="epasts">Email</label>
                    <input
                        type="email"
                        id="epasts"
                        name="epasts"
                        value="{{ old('epasts', $lietotajs->epasts) }}"
                        placeholder="example@email.com"
                    >
                    @error('epasts')
                        <small class="form-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="telefons">Phone Number</label>
                    <input
                        type="tel"
                        id="telefons"
                        name="telefons"
                        value="{{ old('telefons', $lietotajs->telefons) }}"
                        placeholder="+371..."
                    >
                    @error('telefons')
                        <small class="form-error">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="parole">New Password</label>
                        <input
                            type="password"
                            id="parole"
                            name="parole"
                            placeholder="Leave empty to keep current"
                        >
                        @error('parole')
                            <small class="form-error">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="parole_confirmation">Confirm New Password</label>
                        <input
                            type="password"
                            id="parole_confirmation"
                            name="parole_confirmation"
                            placeholder="Confirm new password"
                        >
                        @error('parole_confirmation')
                            <small class="form-error">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="auth-actions">
                    <a href="{{ route('showProfile') }}" class="auth-secondary">
                        Cancel
                    </a>

                    <button type="submit" class="auth-submit">
                        Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout>