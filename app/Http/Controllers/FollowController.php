<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function volunteer_index()
    {
        return view('follow.volunteer_index');
    }

    public function organization_index()
    {
        return view('follow.organization_index');
    }

    public function store(string $organization_id)
    {

        
    }

    public function destroy(string $organization_id)
    {
        
    }
}
