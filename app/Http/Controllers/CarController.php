<?php

namespace App\Http\Controllers;

use App\Models\Masina;

class CarController extends Controller
{
    public function index()
    {
        $masinas = Masina::with('lokacija', 'modelis')->get();
        return view('welcome', compact('masinas'));
    }
}
