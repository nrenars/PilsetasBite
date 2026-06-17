<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Lietotajs;
use App\Models\Ire;

class AuthController extends Controller
{
    public function showRegister(){
        return view('auth.register');
    }
    public function showLogin(){
        return view('auth.login');
    }
    public function register(Request $request){
        $validated = $request->validate([
            'vards'            => 'required|string|max:255',
            'uzvards'            => 'required|string|max:255',
            'epasts'                 => 'required|email|unique:lietotajs,epasts',
            'telefons' => 'required|unique:lietotajs,telefons|regex:/^\+?[0-9]{8,15}$/',
            'vaditaja_apliecibas_nr' => 'required|string|max:255',
            'vaditaja_apliecibas_termins' => 'required|date|after:today',
            'vaditaja_apliecibas_attels' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'parole'              => 'required|min:8|confirmed',
        ]);
        $path = $request->file('vaditaja_apliecibas_attels')->store('driver_licenses', 'public');
        $user = Lietotajs::create([
            'vards'                       => $validated['vards'],
            'uzvards'                     => $validated['uzvards'],
            'pilns_vards'                 => $validated['vards'] . ' ' . $validated['uzvards'],
            'epasts'                      => $validated['epasts'],
            'telefons'                    => $validated['telefons'],
            'paroles_hash'                => Hash::make($validated['parole']),
            'loma'                        => 'lietotajs',
            'statuss'                     => 'aktīvs',
            'izveidots'                   => now(),
            'vaditaja_apliecibas_nr' => $request->vaditaja_apliecibas_nr,
            'vaditaja_apliecibas_termins' => $request->vaditaja_apliecibas_termins,
            'vaditaja_apliecibas_attels' => $path,
            'vaditaja_apliecibas_statuss' => 'gaida'
        ]);

        Auth::login($user);

        return redirect()->route('welcome')->with('success', "Registration sucessful");   
    }
    public function login(Request $request){
        $validated = $request->validate([
            'epasts'    => 'required|email',        
            'parole' => 'required',              
        ]);

        $user = \App\Models\Lietotajs::where('epasts', $validated['epasts'])->first();

        if ($user && Hash::check($validated['parole'], $user->paroles_hash)) {
            Auth::login($user);
            $request->session()->regenerate();
            return redirect('/')->with('success', 'Login successful');
        }
        

        return back()->withErrors(['epasts' => 'Incorrect email or password']);
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome') ->with('success', 'You have logged out!');;
    }

    public function showProfile(Request $request){
        $user = Auth::user(); 
        $rides = Auth::user()->ire()->with('maksajums')->latest()->get();
        return view('auth.profile', compact('user', 'rides'));
    }
    public function edit(Request $request){
        $lietotajs = Auth::user();
        return view('auth.edit', compact('lietotajs'));
    }

    public function update(Request $request){
        $user = Auth::user();
        
        $request->validate([
            'vards'    => 'required|string|max:255',
            'uzvards'  => 'required|string|max:255',
            'epasts'   => 'required|email|unique:lietotajs,epasts,'. $user->id,
            'telefons' => 'required|regex:/^\+?[0-9]{8,15}$/|unique:lietotajs,telefons,' . $user->id,
            'parole'   => 'nullable|min:8|confirmed',
        ]);

        $user->vards       = $request->vards;
        $user->uzvards     = $request->uzvards;
        $user->pilns_vards = $request->vards . ' ' . $request->uzvards;
        $user->epasts      = $request->epasts;
        $user->telefons    = $request->telefons;

        if ($request->filled('parole')) {
            $user->paroles_hash = Hash::make($request->parole);
        }

        $user->save();

        return redirect()->route('showProfile')->with('success', 'Profile updated successfully!');
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('welcome')->with('success', 'Account deleted successfully!');
    }
}
