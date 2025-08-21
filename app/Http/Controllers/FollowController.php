<?php

namespace App\Http\Controllers;

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

        
    }

    public function destroy(string $organization_id)
    {
        
    }
}
