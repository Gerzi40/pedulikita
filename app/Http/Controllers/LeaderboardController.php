<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;
use App\Models\VolunteerPointRating;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class LeaderboardController extends Controller
{
    public function volunteer_index()
    {
        $this->create_missing_volunteer_point_rating();

        $now = Carbon::now();

        $volunteers = VolunteerPointRating::
            select(
                'users.name',
                'users.profile_picture_url',
                DB::raw('SUM(volunteer_point_ratings.rating_total) as rating_total'),
                DB::raw('SUM(volunteer_point_ratings.rating_count) as rating_count'),
                DB::raw('SUM(volunteer_point_ratings.point_total) as point_total')
            )
            ->join('volunteers', 'volunteer_point_ratings.volunteer_id', '=', 'volunteers.id')
            ->join('users', 'volunteers.user_id', '=', 'users.id')
            ->groupBy('users.name', 'users.profile_picture_url')
            ->orderByDesc('point_total')
            ->get();

        return view('leaderboard.volunteer_index', compact('volunteers'));
    }

    public function organization_index()
    {
        $this->create_missing_volunteer_point_rating();

        $now = Carbon::now();

        $volunteers = VolunteerPointRating::
            select(
                'users.name',
                'users.profile_picture_url',
                DB::raw('SUM(volunteer_point_ratings.rating_total) as rating_total'),
                DB::raw('SUM(volunteer_point_ratings.rating_count) as rating_count'),
                DB::raw('SUM(volunteer_point_ratings.point_total) as point_total')
            )
            ->join('volunteers', 'volunteer_point_ratings.volunteer_id', '=', 'volunteers.id')
            ->join('users', 'volunteers.user_id', '=', 'users.id')
            ->groupBy('users.name', 'users.profile_picture_url')
            ->orderByDesc('point_total')
            ->get();

        return view('leaderboard.organization_index', compact('volunteers'));
    }

    private function create_missing_volunteer_point_rating()
    {
        $volunteer_ids = Volunteer::pluck('id');

        $now = Carbon::now();

        $volunteer_point_rating_ids = VolunteerPointRating::whereIn('volunteer_id', $volunteer_ids)
            ->where('year', '=', $now->year)
            ->where('month', '=', $now->month)
            ->pluck('volunteer_id');

        $missing_volunteer_ids = $volunteer_ids->diff($volunteer_point_rating_ids);
        
        if ($missing_volunteer_ids->isNotEmpty())
        {
            $insert_data = [];

            foreach ($missing_volunteer_ids as $volunteer_id) {
                $insert_data[] = [
                    'volunteer_id' => $volunteer_id,
                    'year' => $now->year,
                    'month' => $now->month,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            VolunteerPointRating::insert($insert_data);
        }
    }

    public function yearly_leaderboard()
    {
        $now = Carbon::now();

        $volunteers = VolunteerPointRating::
            select(
                'users.name',
                'users.profile_picture_url',
                DB::raw('SUM(volunteer_point_ratings.rating_total) as rating_total'),
                DB::raw('SUM(volunteer_point_ratings.rating_count) as rating_count'),
                DB::raw('SUM(volunteer_point_ratings.point_total) as point_total')
            )
            ->join('volunteers', 'volunteer_point_ratings.volunteer_id', '=', 'volunteers.id')
            ->join('users', 'volunteers.user_id', '=', 'users.id')
            ->where('year', '=', $now->year)
            ->groupBy('users.name', 'users.profile_picture_url')
            ->orderByDesc('point_total')
            ->get();

        return $volunteers;
    }

    public function monthly_leaderboard()
    {
        $now = Carbon::now();

        $volunteers = VolunteerPointRating::
            select(
                'users.name',
                'users.profile_picture_url',
                DB::raw('SUM(volunteer_point_ratings.rating_total) as rating_total'),
                DB::raw('SUM(volunteer_point_ratings.rating_count) as rating_count'),
                DB::raw('SUM(volunteer_point_ratings.point_total) as point_total')
            )
            ->join('volunteers', 'volunteer_point_ratings.volunteer_id', '=', 'volunteers.id')
            ->join('users', 'volunteers.user_id', '=', 'users.id')
            ->where('year', '=', $now->year)
            ->where('month', '=', $now->month)
            ->groupBy('users.name', 'users.profile_picture_url')
            ->orderByDesc('point_total')
            ->get();

        return $volunteers;
    }
}
