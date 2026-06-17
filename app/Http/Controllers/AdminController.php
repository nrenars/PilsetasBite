<?php

namespace App\Http\Controllers;

use App\Models\Lietotajs;
use App\Models\Masina;
use App\Models\Rezervacija;
use App\Models\Ire;
use App\Models\Atsauksmes;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'lietotaji'   => Lietotajs::count(),
            'masinas'     => Masina::count(),
            'rezervacijas' => Rezervacija::count(),
            'braucieni'   => Ire::count(),
            'verifikacijas' => Lietotajs::where('vaditaja_apliecibas_statuss', 'gaida')->count(),
        ];

        return view('admin.index', compact('stats'));
    }

    public function lietotaji()
    {
        $lietotaji = Lietotajs::latest()->paginate(20);
        return view('admin.lietotaji', compact('lietotaji'));
    }

    public function mainLietotaju(Lietotajs $lietotajs, $loma)
    {
        if (!in_array($loma, ['lietotajs', 'admins'])) {
            abort(400);
        }
        $lietotajs->loma = $loma;
        $lietotajs->save();

        return back()->with('success', 'Loma atjaunināta.');
    }

    public function dziestLietotaju(Lietotajs $lietotajs)
    {
        $lietotajs->delete();
        return back()->with('success', 'Lietotājs dzēsts.');
    }

    public function rezervacijas()
    {
        $rezervacijas = Rezervacija::with(['lietotajs', 'masina'])->latest()->paginate(20);
        return view('admin.rezervacijas', compact('rezervacijas'));
    }

    public function dziestRezervaciju(Rezervacija $rezervacija)
    {
        $rezervacija->delete();
        return back()->with('success', 'Rezervācija dzēsta.');
    }

    public function braucieni()
    {
        $braucieni = Ire::with(['lietotajs', 'masina'])->latest()->paginate(20);
        return view('admin.braucieni', compact('braucieni'));
    }

    public function atsauksmes()
    {
        $atsauksmes = Atsauksmes::with(['lietotajs', 'ire'])->latest()->paginate(20);
        return view('admin.atsauksmes', compact('atsauksmes'));
    }

    public function dziestAtsauksmi(Atsauksmes $atsauksme)
    {
        $atsauksme->delete();
        return back()->with('success', 'Atsauksme dzēsta.');
    }

    public function verifikacija()
    {
        $lietotaji = Lietotajs::where('vaditaja_apliecibas_statuss', 'gaida')->latest()->paginate(20);
        return view('admin.verifikacija', compact('lietotaji'));
    }

    public function apstiprinatApliecibu(Lietotajs $lietotajs)
    {
        $lietotajs->vaditaja_apliecibas_statuss = 'apstiprinata';
        $lietotajs->save();
        return back()->with('success', 'Vadītāja apliecība apstiprināta.');
    }

    public function noraiditApliecibu(Lietotajs $lietotajs)
    {
        $lietotajs->vaditaja_apliecibas_statuss = 'noraidita';
        $lietotajs->save();
        return back()->with('success', 'Vadītāja apliecība noraidīta.');
    }
}
