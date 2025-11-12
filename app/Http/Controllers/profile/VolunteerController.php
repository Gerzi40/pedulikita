<?php

namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Throwable;

class VolunteerController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $events = Auth::user()->volunteer->events;
        return view('profile.volunteer_show', compact('user', 'events'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.volunteer_edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'lowercase', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            'gender' => ['required', Rule::in(['male', 'female'])],
            'date_of_birth' => ['required', Rule::date()->beforeOrEqual(today())],
            'profile_picture' => ['nullable', 'image']
        ]);

        if (!empty($validated['profile_picture']))
        {
            $path = Storage::disk('s3')->putFile('profiles/volunteers', $request->file('profile_picture'));
            if(!$path)
            {
                abort(500);
            }
        }

        DB::beginTransaction();

        try
        {
            $user->volunteer->update(Arr::only($validated, ['gender', 'date_of_birth']));
            
            $userData = Arr::only($validated, ['name', 'email']);
            if (!empty($validated['password']))
            {
                $userData['password'] = $validated['password'];
            }
            if (!empty($validated['profile_picture']))
            {
                $userData['profile_picture_url'] = $path;
            }
            $user->update($userData);

            DB::commit();

            return redirect()->route('volunteer.profile.show');
        }
        catch (Throwable $e)
        {
            DB::rollBack();

            throw $e;
        }
    }
}
