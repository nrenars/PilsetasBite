<x-layout title="Login">
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="epasts" class="form-label">{{ __('messages.email') }}</label>
            <input type="email" name="epasts" class="form-control" required
            value="{{ old('epasts') }}">
            @error('epasts') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label for="parole" class="form-label">{{ __('messages.password') }}</label>
            <input type="password" name="parole" class="form-control" required>
            @error('parole') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <input type="submit" value="{{ __('messages.login_btn') }}">
    </form>
</x-layout>
