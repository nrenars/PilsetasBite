<?php

namespace App\Http\Controllers;

use App\Mail\LietotajsNoblokets;
use App\Models\Atsauksmes;
use App\Models\Ire;
use App\Models\Lietotajs;
use App\Models\Masina;
use App\Models\Parkapums;
use App\Models\Rezervacija;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'lietotaji'    => Lietotajs::count(),
            'masinas'      => Masina::count(),
            'rezervacijas' => Rezervacija::count(),
            'braucieni'    => Ire::count(),
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

    public function parkapumi()
    {
        $parkapumi  = Parkapums::with(['lietotajs', 'ire'])->latest()->paginate(20);
        $lietotaji  = Lietotajs::orderBy('pilns_vards')->get();
        $braucieni  = Ire::with('lietotajs')->latest()->get();

        return view('admin.parkapumi', compact('parkapumi', 'lietotaji', 'braucieni'));
    }

    public function nobloket(Request $request)
    {
        $request->validate([
            'lietotajs_id' => 'required|exists:lietotajs,id',
            'tips'         => 'required|string|max:50',
            'apraksts'     => 'required|string|max:500',
            'summa'        => 'required|numeric|min:0',
            'ire_id'       => 'required|exists:ires,id',
        ]);

        $lietotajs = Lietotajs::findOrFail($request->lietotajs_id);

        $parkapums = Parkapums::create([
            'lietotajs_id' => $lietotajs->id,
            'ire_id'       => $request->ire_id,
            'tips'         => $request->tips,
            'apraksts'     => $request->apraksts,
            'summa'        => $request->summa,
            'statuss'      => 'nesamaksats',
        ]);

        $lietotajs->statuss = 'bloķēts';
        $lietotajs->save();

        Mail::to($lietotajs->epasts)->send(new LietotajsNoblokets($lietotajs, $parkapums));

        return back()->with('success', "Lietotājs {$lietotajs->pilns_vards} nobloķēts un e-pasts nosūtīts.");
    }

    public function atzimetSamaksatu(Parkapums $parkapums)
    {
        $parkapums->statuss = 'samaksats';
        $parkapums->save();

        return back()->with('success', 'Pārkāpums atzīmēts kā samaksāts.');
    }

    public function atbloket(Lietotajs $lietotajs)
    {
        $lietotajs->statuss = 'aktīvs';
        $lietotajs->save();

        return back()->with('success', "Lietotājs {$lietotajs->pilns_vards} atbloķēts.");
    }
}
