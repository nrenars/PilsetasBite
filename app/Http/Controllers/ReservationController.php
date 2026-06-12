<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rezervacija;
use Illuminate\Support\Facades\Auth;
use App\Models\Masina;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Rezervacija::find(Auth::user()->id);
        return view('layout', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Masina $masina)
    {
        $reservation = Rezervacija::create([
            'datums' => now(),
            'deriguma_beigas' => now()->addHours(4),
            'statuss' => 'aktīva',
            'lietotajs_id' => Auth::user()->id,
            'masina_id' => $masina->id,
        ]);
        $reserved_car = Masina::find($masina->id);
        $reserved_car->statuss = 'rezervēta';
        $reserved_car->save();

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('welcome')->with('success', 'Reservation succcessful!');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $reservations = Rezervacija::where('lietotajs_id', Auth::user()->id)->get();
        return view('reservations', compact('reservations'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reservation = Rezervacija::where('id', $id)->where('lietotajs_id', Auth::user()->id)->firstOrFail();
        $reservation->masina->statuss = 'pieejama';
        $reservation->masina->save(); 
        $reservation->delete();
        return redirect()->route('welcome')->with('success', "Reservation canceled successfully!");
    }
}
