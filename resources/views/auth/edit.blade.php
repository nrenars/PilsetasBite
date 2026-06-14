<x-layout>
    <h1 class="mb-4">Edit Profile</h1>
    <form method="POST" action="{{ route('auth.update') }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">First Name</label>
            <input type="text" name="vards" class="form-control" value="{{ old('vards', $lietotajs->vards) }}">
            @error('vards')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Last Name</label>
            <input type="text" name="uzvards" class="form-control" value="{{ old('uzvards', $lietotajs->uzvards) }}">
            @error('uzvards')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="epasts" class="form-control" value="{{ old('epasts', $lietotajs->epasts) }}">
            @error('epasts')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Phone Number</label>
            <input type="phone" name="telefons" class="form-control" value="{{ old('telefons', $lietotajs->telefons) }}">
            @error('telefons')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="parole" class="form-control" value="{{ old('parole', $lietotajs->parole) }}">
            @error('parole')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="parole_confirmation" class="form-control" value="{{ old('parole_confirmation', $lietotajs->parole) }}">
            @error('parole_confirmation')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</x-layout>