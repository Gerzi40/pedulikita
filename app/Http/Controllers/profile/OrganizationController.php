<?php

namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\OrganizationCategory;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Throwable;

class OrganizationController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $events = Event::where('organization_id', '=', $user->organization->id)->get();
        $volunteers = Auth::user()->organization->volunteers;
        return view('profile.organization_show', compact('user', 'events', 'volunteers'));
    }

    public function edit()
    {
        $user = Auth::user();
        $organization_categories = OrganizationCategory::get();
        $provinces = Province::get();
        return view('profile.organization_edit', compact('user', 'organization_categories', 'provinces'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'lowercase', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            'profile_picture' => ['nullable', 'image'],
            'organization_category_id' => ['required', 'exists:organization_categories,id'],
            'province_id' => ['required', 'exists:provinces,id'],
            'city_id' => [
                'required', 
                Rule::exists('cities', 'id')->where(function ($query) use ($request) {
                    $query->where('province_id', $request->province_id);
                })
            ],
            'description' => ['required', 'string'],
            'founded_at' => ['required', Rule::date()->beforeOrEqual(today())],
            'instagram' => ['required', 'string'],
            'phone' => ['required', 'digits_between:8,15']
        ]);

        if (!empty($validated['profile_picture']))
        {
            $path = Storage::disk('s3')->putFile('profiles/organizations', $request->file('profile_picture'));
            if(!$path)
            {
                abort(500);
            }
        }

        DB::beginTransaction();

        try
        {
            $user->organization->update(Arr::only($validated, ['organization_category_id', 'province_id', 'city_id', 'description', 'founded_at', 'instagram', 'phone']));
            
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

            return redirect()->route('organization.profile.show');
        }
        catch (Throwable $e)
        {
            DB::rollBack();

            throw $e;
        }
    }
}
