<?php

namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VolunteerController extends Controller
{
    public function show()
    {
        return view('profile.volunteer_show');
    }

    public function edit()
    {
        return view('profile.volunteer_edit');
    }

    public function update(Request $request)
    {

    }
}
