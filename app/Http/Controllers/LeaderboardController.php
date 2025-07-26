<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function volunteer_index()
    {
        return view('leaderboard.volunteer_index');
    }

    public function organization_index()
    {
        return view('leaderboard.organization_index');
    }
}
