<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Lietotajs;
use App\Models\Masina;
use App\Models\Modelis;
use App\Models\Lokacija;
use App\Models\Rezervacija;
use App\Models\Ire;
use App\Models\Atsauksmes;
use App\Models\Maksajums;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'lietotaji'     => Lietotajs::count(),
            'masinas'       => Masina::count(),
            'rezervacijas'  => Rezervacija::count(),
            'braucieni'     => Ire::count(),
            'verifikacijas' => Lietotajs::where('vaditaja_apliecibas_statuss', 'gaida')->count(),
        ];

        return view('admin.index', compact('stats'));
    }

    public function lietotaji()
    {
        $lietotaji = Lietotajs::latest()->paginate(20);
        return view('admin.lietotaji', compact('lietotaji'));
    }

    public function masinas()
    {
        $masinas = Masina::with(['modelis', 'lokacija'])->latest()->paginate(20);
        return view('admin.masinas', compact('masinas'));
    }

    public function izveidotMasinu()
    {
        $modeli = Modelis::orderBy('marka')->orderBy('modelis')->get();
        $lokacijas = Lokacija::orderBy('id')->get();
        return view('admin.masinas-create', compact('modeli', 'lokacijas'));
    }

    public function saglabatMasinu(Request $request)
    {
        $validated = $request->validate([
            'modelis_id' => [
                'required',
                Rule::exists((new Modelis)->getTable(), 'id'),
            ],
            'lokacija_id' => [
                'required',
                Rule::exists((new Lokacija)->getTable(), 'id'),
            ],
            'gads' => [
                'required',
                'integer',
                'min:1980',
                'max:' . now()->year,
            ],
            'registracijas_nr' => [
                'required',
                'string',
                'max:20',
                Rule::unique('masinas', 'registracijas_nr'),
            ],
            'statuss' => [
                'required',
                Rule::in(['pieejama', 'rezervēta', 'lietošanā', 'neaktīva']),
            ],
            'degvielas_limenis' => [
                'nullable',
                'integer',
                'min:0',
                'max:100',
            ],
            'baterijas_limenis' => [
                'nullable',
                'integer',
                'min:0',
                'max:100',
            ],
            'tehniskas_apskates_termins' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
        ]);

        $masina = new Masina();
        $masina->modelis_id = $validated['modelis_id'];
        $masina->lokacija_id = $validated['lokacija_id'];
        $masina->gads = $validated['gads'];
        $masina->registracijas_nr = $validated['registracijas_nr'];
        $masina->tehniskas_apskates_termins = $validated['tehniskas_apskates_termins'];
        $masina->statuss = $validated['statuss'];
        $masina->degvielas_limenis = $validated['degvielas_limenis'] ?? null;
        $masina->baterijas_limenis = $validated['baterijas_limenis'] ?? null;
        $masina->save();

        return redirect()->route('admin.masinas')->with('success', 'Mašīna veiksmīgi pievienota.');
    }

    public function redigetMasinu(Masina $masina)
    {
        $modeli = Modelis::orderBy('marka')->orderBy('modelis')->get();
        $lokacijas = Lokacija::orderBy('id')->get();
        return view('admin.masinas-edit', compact('masina', 'modeli', 'lokacijas'));
    }

    public function atjauninatMasinu(Request $request, Masina $masina)
    {
        $validated = $request->validate([
            'modelis_id' => [
                'required',
                Rule::exists((new Modelis)->getTable(), 'id'),
            ],

            'lokacija_id' => [
                'required',
                Rule::exists((new Lokacija)->getTable(), 'id'),
            ],

            'gads' => [
                'required',
                'integer',
                'min:1980',
                'max:' . now()->year,
            ],

            'registracijas_nr' => [
                'required',
                'string',
                'max:20',
                Rule::unique('masinas', 'registracijas_nr')->ignore($masina->id, 'id'),
            ],

            'tehniskas_apskates_termins' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            'statuss' => [
                'required',
                Rule::in(['pieejama', 'rezervēta', 'lietošanā', 'neaktīva']),
            ],

            'degvielas_limenis' => [
                'nullable',
                'integer',
                'min:0',
                'max:100',
            ],

            'baterijas_limenis' => [
                'nullable',
                'integer',
                'min:0',
                'max:100',
            ],
        ]);

        $masina->modelis_id = $validated['modelis_id'];
        $masina->lokacija_id = $validated['lokacija_id'];
        $masina->gads = $validated['gads'];
        $masina->registracijas_nr = $validated['registracijas_nr'];
        $masina->tehniskas_apskates_termins = $validated['tehniskas_apskates_termins'];
        $masina->statuss = $validated['statuss'];
        $masina->degvielas_limenis = $validated['degvielas_limenis'] ?? null;
        $masina->baterijas_limenis = $validated['baterijas_limenis'] ?? null;

        $masina->save();

        return redirect()->route('admin.masinas')->with('success', 'Mašīna veiksmīgi atjaunināta.');
    }

    public function deaktivizetMasinu(Masina $masina)
    {
        if (in_array($masina->statuss, ['rezervēta', 'lietošanā'])) {
            return back()->with('error', 'Nevar deaktivizēt mašīnu, kas ir rezervēta vai tiek lietota.');
        }

        $masina->statuss = 'neaktīva';
        $masina->save();

        return back()->with('success', 'Mašīna deaktivizēta.');
    }

    public function aktivizetMasinu(Masina $masina)
    {
        $masina->statuss = 'pieejama';
        $masina->save();

        return back()->with('success', 'Mašīna aktivizēta.');
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
        $lietotajs->vaditaja_apliecibas_statuss = 'deriga';
        $lietotajs->save();

        return back()->with('success', 'Vadītāja apliecība apstiprināta.');
    }

    public function noraiditApliecibu(Lietotajs $lietotajs)
    {
        $lietotajs->vaditaja_apliecibas_statuss = 'noraidita';
        $lietotajs->save();

        return back()->with('success', 'Vadītāja apliecība noraidīta.');
    }
    public function maksajumi()
    {
        $maksajumi = Maksajums::latest()->paginate(20);
        return view('admin.maksajumi', compact('maksajumi'));
    }
}