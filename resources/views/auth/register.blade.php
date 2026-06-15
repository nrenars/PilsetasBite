<x-layout title="Register">
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="vards" class="form-label">{{ __('messages.first_name') }}</label>
            <input type="text" name="vards" class="form-control" required
            value="{{ old('vards') }}">
            @error('vards') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label for="uzvards" class="form-label">{{ __('messages.last_name') }}</label>
            <input type="text" name="uzvards" class="form-control" required
            value="{{ old('uzvards') }}">
            @error('uzvards') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label for="epasts" class="form-label">{{ __('messages.email') }}</label>
            <input type="email" name="epasts" class="form-control" required
            value="{{ old('epasts') }}">
            @error('epasts') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label for="telefons" class="form-label">{{ __('messages.phone') }}</label>
            <input type="phone" name="telefons" class="form-control" required
            value="{{ old('telefons') }}">
            @error('telefons') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label for="parole" class="form-label">{{ __('messages.password') }}</label>
            <input type="password" name="parole" class="form-control" required
            value="{{ old('parole') }}">
            @error('parole') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label for="parole_confirmation" class="form-label">{{ __('messages.confirm_password') }}</label>
            <input type="password" name="parole_confirmation" class="form-control" required
            value="{{ old('parole_confirmation') }}">
            @error('parole_confirmation') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <input type="submit" value="{{ __('messages.register') }}">
    </form>
</x-layout>
