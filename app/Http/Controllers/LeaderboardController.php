<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function volunteer_index()
    {
        return view('leaderboard.volunteer_index');
    }

    public function organization_index()
    {
        $volunteers = Volunteer::get();
        return view('leaderboard.organization_index', compact('volunteers'));
    }
}
