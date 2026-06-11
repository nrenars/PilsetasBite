<x-layout>
    <h1>Profils</h1>

    <p>Vārds: {{ $user->vards }}</p>
    <p>Uzvārds: {{ $user->uzvards }}</p>
    <p>E-pasts: {{ $user->epasts }}</p>
    <p>Telefons: {{ $user->telefons }}</p>
    <p>Konta statuss: {{$user->statuss}}</p>
</x-layout>