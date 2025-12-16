<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Volunteer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Throwable;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'lowercase', 'email', 'unique:users,email', 'regex:/^[\w\.\-]+@([\w\-]+\.)+[a-zA-Z]{2,}$/'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            'gender' => ['required', Rule::in(['male', 'female'])],
            'date_of_birth' => ['required', Rule::date()->beforeOrEqual(today())]
        ]);

        DB::beginTransaction();

        try
        {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role' => 'volunteer'
            ]);
            Volunteer::create([
                'gender' => $validated['gender'],
                'date_of_birth' => $validated['date_of_birth'],
                'user_id' => $user->id
            ]);

            DB::commit();

        }
        catch (Throwable $e)
        {
            DB::rollBack();
            
            throw $e;
        }

        event(new Registered($user));

        Auth::login($user);
        
        return redirect()->route('volunteer.events.index');
    }
}
