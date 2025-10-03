<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    public function show()
    {
        return view('auth.verify-email');
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

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

    public function send(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        
        return back()->with('status', 'Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.');
    }
}
