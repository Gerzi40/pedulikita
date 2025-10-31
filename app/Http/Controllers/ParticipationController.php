<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\VolunteerPointRating;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class ParticipationController extends Controller
{
    public function volunteer_index()
    {
        $events = Auth::user()->volunteer->events;
        return view('participation.volunteer_index', compact('events'));
    }

    public function organization_index(string $event_id)
    {
        $event = Event::findOrFail($event_id);
        return view('participation.organization_index', compact('event'));
    }

    public function store(string $event_id)
    {
        $event = Event::findOrFail($event_id);

        $event_start_time = Carbon::parse("{$event->date} {$event->start_time}");
        if (Carbon::now()->greaterThanOrEqualTo($event_start_time)) {
            return redirect()->back()->with('error', 'Acara telah dimulai');
        }

        if ($event->available_slot <= $event->volunteers->count())
        {
            return redirect()->back()->with('error', 'Jumlah relawan acara sudah sesuai dengan slot tersedia.');
        }
        
        $user = Auth::user();
        $user->volunteer->events()->attach($event_id);
        return redirect()->route('volunteer.participation.index');
    }

    public function organization_edit(string $event_id)
    {
        $event = Event::findOrFail($event_id);
        return view('participation.organization_edit', compact('event'));
    }

    public function update(Request $request, string $event_id)
    {
        $data = $request['data'];

        // creating query
        $volunteer_ids = [];
        $is_present_case = "CASE volunteer_id";
        $rating_case = "CASE volunteer_id";

        foreach ($data as $volunteer_id => $row) {
            $is_present = $row['is_present'] ?? 'NULL';
            $rating = $row['rating'] ?? 'NULL';
            $rating_int = (int) $rating;

            // validating data
            if (($is_present == 'NULL' && $rating != 'NULL') || ($is_present != 'NULL' && $rating == 'NULL'))
            {
                return back()->with('error', 'Kehadiran dan nilai perlu diisi bersamaan.');
            }
            if ($is_present == 'TRUE' && ($rating_int < 1 || $rating_int > 5))
            {
                return back()->with('error', 'Jika hadir, nilai harus antara 1 dan 5.');
            }
            if ($is_present == 'FALSE' && $rating != '0')
            {
                return back()->with('error', 'Jika tidak hadir, nilai harus 0.');
            }

            array_push($volunteer_ids, $volunteer_id);
            $is_present_case .= " WHEN {$volunteer_id} THEN {$is_present}";
            $rating_case .= " WHEN {$volunteer_id} THEN {$rating}";
        }

        $is_present_case .= " END";
        $rating_case .= " END";

        $volunteer_ids = implode(',', $volunteer_ids);

        $query = "
            UPDATE event_volunteer
            SET 
                is_present = $is_present_case,
                rating = $rating_case
            WHERE event_id = $event_id
            AND volunteer_id IN ($volunteer_ids)
        ";

        DB::update($query);

        return redirect()->route('organization.participation.index', ['event_id' => $event_id]);
    }

    public function submit(string $event_id)
    {
        $event = Event::with('volunteers')->findOrFail($event_id);

        $event_end_time = Carbon::parse("{$event->date} {$event->end_time}");
        if (Carbon::now()->lessThanOrEqualTo($event_end_time)) {
            return redirect()->back()->with('error', 'Penilaian relawan hanya dapat dilakukan setelah acara berakhir');
        }

        $volunteers = $event->volunteers->sortBy('volunteer_id');
        $volunteer_ids = $volunteers->pluck('id');

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

        $volunteer_point_ratings = VolunteerPointRating::whereIn('volunteer_id', $volunteer_ids)
            ->where('year', '=', $now->year)
            ->where('month', '=', $now->month)
            ->get();

        // validating & filling data
        $data = [];

        for($i=0; $i<$volunteer_ids->count(); $i++)
        {
            $volunteer_pivot = $volunteers[$i]->pivot;
            $volunteer_point_rating = $volunteer_point_ratings[$i];

            if ($volunteer_pivot->is_present === null || $volunteer_pivot->rating === null)
            {
                return back()->with('error', 'Terdapat relawan yang belum dinilai.');
            }

            $new_rating_total = $volunteer_point_rating->rating_total + $volunteer_pivot->rating;
            $new_rating_count = $volunteer_point_rating->rating_count + 1;
            $new_point_total  = $volunteer_point_rating->point_total;

            if ($volunteer_pivot->is_present) {
                $new_point_total += $event->point * ($volunteer_pivot->rating / 5);
            }

            $data[$volunteer_point_rating->volunteer_id] = [
                'rating_total' => $new_rating_total,
                'rating_count' => $new_rating_count,
                'point_total'  => $new_point_total,
            ];
        }

        // creating query
        $ids = [];

        $rating_total_case = "CASE volunteer_id";
        $rating_count_case = "CASE volunteer_id";
        $point_total_case  = "CASE volunteer_id";

        foreach ($data as $id => $vals) {
            array_push($ids, $id);
            $rating_total_case .= " WHEN $id THEN {$vals['rating_total']}";
            $rating_count_case .= " WHEN $id THEN {$vals['rating_count']}";
            $point_total_case  .= " WHEN $id THEN {$vals['point_total']}";
        }

        $rating_total_case .= " END";
        $rating_count_case .= " END";
        $point_total_case  .= " END";

        $ids = implode(',', $ids);

        $query = "
            UPDATE volunteer_point_ratings
            SET 
                rating_total = $rating_total_case,
                rating_count = $rating_count_case,
                point_total  = $point_total_case
            WHERE volunteer_id IN ($ids)
            AND year = $now->year
            AND month = $now->month
        ";

        DB::beginTransaction();

        try
        {
            DB::update($query);

            $event->state = 'finished';
            $event->save();

            DB::commit();
        }
        catch (Throwable $e)
        {
            DB::rollBack();
            
            throw $e;
        }

        return back();
    }
}
