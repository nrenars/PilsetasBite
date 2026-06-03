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
            'epasts'                 => 'required|email|unique:users,email',
            'telefons'                 => 'required|email|unique:users,email',
            'parole'              => 'required|min:8|confirmed',
        ]);
        $user = Lietotajs::create([
            'vards'     => $validated['vards'],
            'uzvards'     => $validated['uzvards'],
            'epasts'    => $validated['epasts'],
            'parole' => Hash::make($validated['parole']),
        ]);

        Auth::login($user);

        return redirect()->route('event.index')->with('success', "Registration sucessful");   
    }
    public function login(Request $request){
        $validated = $request->validate([
            'epasts'    => 'required|email',        
            'parole' => 'required',              
        ]);

        if (Auth::attempt(['epasts' => $validated['epasts'], 'parole' => $validated['parole']])) {
            $request->session()->regenerate();
            return redirect()->route('event.index')->with('success', 'Login successful');
        }

        return back()->withErrors(['email' => 'Incorrect email or password']);
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('event.index');
    }
}
