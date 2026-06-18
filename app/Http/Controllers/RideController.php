<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ire;
use Illuminate\Support\Facades\Auth;
use App\Models\Masina;

class RideController extends Controller
{
    public function begin(Request $request, $id)
    {
        $user = auth()->user();

        if (!$user || trim((string) $user->vaditaja_apliecibas_statuss) !== 'deriga') {
            return response()->json([
                'message' => 'Driver license is not verified.'
            ], 403);
        }

        $masina = Masina::findOrFail($id);

        $ride = Ire::create([
            'sakuma_laiks' => now(),
            'beigu_laiks' => now(),
            'nobrauktais_attalums' => 0,
            'statuss' => 'aktīva',
            'cena' => 0,
            'lietotajs_id' => Auth::id(),
            'masina_id' => $masina->id,
            'lokacija_id' => $masina->lokacija_id
        ]);

        $masina->statuss = 'lietošanā';
        $masina->save();

        return view('ride', compact('ride'));
    }

    public function end(Request $request, $id)
    {
        $ride = Ire::where('id', $id)->where('lietotajs_id', Auth::id())->firstOrFail();

        $ride->beigu_laiks = now();
        $ride->statuss = 'pabeigta';
        $ride->nobrauktais_attalums = $request->distance;

        $sakumaLaiks = $ride->sakuma_laiks instanceof \Carbon\Carbon
            ? $ride->sakuma_laiks
            : \Carbon\Carbon::parse($ride->sakuma_laiks);

        $seconds = $sakumaLaiks->diffInSeconds(now());
        $minutes = $seconds / 60;
        $price = ($minutes * 0.50) + ($request->distance * 0.20);
        $ride->cena = $price;

        $masina = Masina::find($ride->masina_id);
        if ($masina) {
            $masina->statuss = 'pieejama';
            $masina->save();
        }

        $ride->save();

        return response()->json([
            'success' => true,
            'cena' => round($price, 2),
            'distance' => round($request->distance, 2),
            'seconds' => $seconds,
        ]);
    }
}