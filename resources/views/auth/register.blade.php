<x-layout title="Register">
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" name="first_name" class="form-control" required
            value="{{ old('first_name') }}">
            @error('first_name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label for="first_name" class="form-label">Last Name</label>
            <input type="text" name="last_name" class="form-control" required
            value="{{ old('last_name') }}">
            @error('last_name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" required
            value="{{ old('email') }}">
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="phone" name="phone" class="form-control" required
            value="{{ old('phone') }}">
            @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required
            value="{{ old('password') }}">
            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required
            value="{{ old('password_confirmation') }}">
            @error('password_confirmation') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <input type="submit" value="Register">
</x-layout>