<?php

namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function show()
    {
        return view('profile.organization_show');
    }

    public function edit()
    {
        return view('profile.organization_edit');
    }

    public function update(Request $request)
    {

    }
}
