<x-layout>
    <div>
        <h1>Profile</h1>
        <p>First name: {{ $user->vards }}</p>
        <p>Last name: {{ $user->uzvards }}</p>
        <p>E-mail: {{ $user->epasts }}</p>
        <p>Phone number: {{ $user->telefons }}</p>
        <p>Account status: {{$user->statuss}}</p>
        <p>Account created at: {{$user->created_at->format('d.m.Y')}}</p>
        <a href="">Edit</a>
        <form action="{{ route('auth.destroy') }}" method="POST">
            @csrf
            @method('DELETE')

            <button type="submit">
                Delete
            </button>
        </form>
    </div>
</x-layout>