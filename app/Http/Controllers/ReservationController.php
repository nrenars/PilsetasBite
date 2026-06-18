<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rezervacija;
use Illuminate\Support\Facades\Auth;
use App\Models\Masina;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Rezervacija::find(Auth::user()->id);
        return view('layout', compact('reservations'));
    }

    public function store(Request $request, Masina $masina)
    {
        $user = auth()->user();

        if (!$user || trim((string) $user->vaditaja_apliecibas_statuss) !== 'deriga') {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => __('messages.driver_license_not_verified')
                ], 403);
            }

            return redirect()
                ->back()
                ->with('error', __('messages.driver_license_not_verified'));
        }

        $hasActiveReservation = Rezervacija::where('lietotajs_id', $user->id)
            ->where('statuss', 'aktīva')
            ->where('deriguma_beigas', '>', now())
            ->exists();

        if ($hasActiveReservation) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => __('messages.already_active_reservation')
                ], 409);
            }

            return redirect()
                ->back()
                ->with('error', __('messages.already_active_reservation'));
        }

        if ($masina->statuss !== 'pieejama') {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => __('messages.car_not_available')
                ], 409);
            }

            return redirect()
                ->back()
                ->with('error', __('messages.car_not_available'));
        }

        $reservation = Rezervacija::create([
            'datums' => now(),
            'deriguma_beigas' => now()->addHours(4),
            'statuss' => 'aktīva',
            'lietotajs_id' => $user->id,
            'masina_id' => $masina->id,
        ]);

        $masina->statuss = 'rezervēta';
        $masina->save();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('messages.reservation_successful')
            ]);
        }

        return redirect()
            ->route('welcome')
            ->with('success', __('messages.reservation_successful'));
    }

    public function show()
    {
        $reservations = Rezervacija::where('lietotajs_id', Auth::user()->id)->get();
        return view('reservations', compact('reservations'));
    }

    public function destroy(string $id)
    {
        $reservation = Rezervacija::where('id', $id)
            ->where('lietotajs_id', Auth::user()->id)
            ->firstOrFail();

        $reservation->masina->statuss = 'pieejama';
        $reservation->masina->save();

        $reservation->delete();

        return redirect()
            ->route('welcome')
            ->with('success', __('messages.reservation_cancelled_successfully'));
    }
}