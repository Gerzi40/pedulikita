<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParticipationController extends Controller
{
    public function volunteer_index()
    {
        return view('participation.volunteer_index');
    }

    public function organization_index(string $event_id)
    {
        return view('participation.organization_index');
    }

    public function store(string $event_id)
    {

    }

    public function update(Request $request, string $event_id, string $volunteer_id)
    {

    }
}
