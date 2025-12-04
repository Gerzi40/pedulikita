<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Volunteer;
use App\Models\VolunteerPointRating;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CronController extends Controller
{
    public function block_rejected_organization()
    {
        Organization::where('rejected_at', '<=', Carbon::now()->subMonths(1))->where('state', '=', 'rejected')->update(['state' => 'blocked']);
    }

    public function populate_volunteer_point_rating()
    {
        $now = Carbon::now();

        if ($now->month == 12)
        {
            $year = $now->year + 1;
            $month = 1;
        }
        else
        {
            $year = $now->year;
            $month = $now->month + 1;
        }

        $volunteer_ids = Volunteer::pluck('id');
        $volunteer_point_rating_ids = VolunteerPointRating::where('year', '=', $year)
            ->where('month', '=', $month)
            ->pluck('volunteer_id');

        $insert_volunteer_ids = $volunteer_ids->diff($volunteer_point_rating_ids);

        $insert_data = [];

        foreach ($insert_volunteer_ids as $volunteer_id) {
            $insert_data[] = [
                'volunteer_id' => $volunteer_id,
                'year' => $year,
                'month' => $month,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        VolunteerPointRating::insert($insert_data);
    }
}
