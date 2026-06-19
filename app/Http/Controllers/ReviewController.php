<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Atsauksmes;
use App\Models\Ire;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function get(Request $request, Ire $ride)
    {
        if ($ride->lietotajs_id !== Auth::id()) {
            abort(403);
        }

        return view('review', compact('ride'));
    }

    public function submit(Request $request, Ire $ride)
    {
        if ($ride->lietotajs_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'vertejums' => 'required|integer|min:1|max:5',
            'komentars' => 'required|string|max:1000',
        ]);

        Atsauksmes::create([
            'vertejums'    => $request->vertejums,
            'komentars'    => $request->komentars,
            'lietotajs_id' => Auth::id(),
            'ire_id'       => $ride->id,
            'izveidots'    => now(),
        ]);

        return redirect()->route('welcome')->with('success', __('messages.review_posted_successfully'));
    }
}