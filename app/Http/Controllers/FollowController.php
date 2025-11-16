<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function volunteer_index()
    {
        return view('follow.volunteer_index');
    }

    public function organization_index()
    {
        $volunteers = Auth::user()->organization->volunteers;
        return view('follow.organization_index', compact('volunteers'));
    }

    public function store(string $organization_id)
    {

        $organization = Organization::findOrFail($organization_id);
        $user = Auth::user();
        $volunteer_id = $user->volunteer->id;

        if ($organization->volunteers()->where('volunteers.id', $volunteer_id)->first())
        {
            return redirect()->back()->with('error', 'Organisasi sudah diikuti');
        }

        $organization->volunteers()->attach($volunteer_id);
        return back();
    }

    public function destroy(string $organization_id)
    {
        $user = Auth::user();
        $user->volunteer->organizations()->detach($organization_id);
        return back();
    }
}
