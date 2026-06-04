<x-layout title="Register">
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="vards" class="form-label">First Name</label>
            <input type="text" name="vards" class="form-control" required
            value="{{ old('vards') }}">
            @error('vards') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label for="uzvards" class="form-label">Last Name</label>
            <input type="text" name="uzvards" class="form-control" required
            value="{{ old('uzvards') }}">
            @error('uzvards') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label for="epasts" class="form-label">Email address</label>
            <input type="email" name="epasts" class="form-control" required
            value="{{ old('epasts') }}">
            @error('epasts') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label for="telefons" class="form-label">Phone</label>
            <input type="phone" name="telefons" class="form-control" required
            value="{{ old('telefons') }}">
            @error('telefons') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label for="parole" class="form-label">Password</label>
            <input type="password" name="parole" class="form-control" required
            value="{{ old('parole') }}">
            @error('parole') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label for="parole_confirmation" class="form-label">Confirm Password</label>
            <input type="password" name="parole_confirmation" class="form-control" required
            value="{{ old('parole_confirmation') }}">
            @error('parole_confirmation') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <input type="submit" value="Register">
</x-layout>