<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            if ($user->role == 'volunteer')
            {
                return redirect()->route('volunteer.events.index');
            }
            else if ($user->role == 'organization')
            {
                return redirect()->route('organization.events.index');
            }
            else if ($user->role == 'admin')
            {
                return redirect()->route('admin.events.index');
            }
        }
 
        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan tidak sesuai dengan data kami.',
        ])->onlyInput('email');
    }

    public function destroy(Request $request)
    {
        Auth::logout();
 
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect()->route('guest.index');
    }
}
