<x-mail::message>
# Jūsu konts ir nobloķēts

Sveiks, **{{ $lietotajs->pilns_vards }}**!

Jūsu konts **PilsetasBite** platformā ir nobloķēts pārkāpuma dēļ.

## Pārkāpuma informācija

| | |
|---|---|
| **Veids** | {{ $parkapums->tips }} |
| **Apraksts** | {{ $parkapums->apraksts }} |
| **Soda nauda** | {{ number_format($parkapums->summa, 2) }} € |

Lai atbloķētu kontu, lūdzu samaksājiet soda naudu **{{ number_format($parkapums->summa, 2) }} €** un sazinieties ar mums.

<x-mail::button :url="config('app.url')">
Doties uz vietni
</x-mail::button>

Ar cieņu,<br>
**PilsetasBite administrācija**
</x-mail::message>
