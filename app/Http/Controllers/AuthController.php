<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Lietotajs;

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
            'parole'              => 'required|min:8|confirmed',
        ]);
        $user = Lietotajs::create([
            'vards'        => $validated['vards'],
            'uzvards'      => $validated['uzvards'],
            'pilns_vards'  => $validated['vards'] . ' ' . $validated['uzvards'],
            'epasts'       => $validated['epasts'],
            'telefons'     => $validated['telefons'],
            'paroles_hash' => Hash::make($validated['parole']),
            'loma'         => 'lietotajs',
            'statuss'      => 'aktīvs',
            'izveidots'    => now(),
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
        return view('auth.profile', compact('user'));
    }

    public function update(Request $request){
        
    }
    public function destroy(Request $request)
    {
        $user = Auth::user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('welcome')
            ->with('success', 'Account deleted successfully!');
    }
}
