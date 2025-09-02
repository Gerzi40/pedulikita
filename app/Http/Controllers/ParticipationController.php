<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ParticipationController extends Controller
{
    public function volunteer_index()
    {
        return view('participation.volunteer_index');
    }

    public function organization_index(string $event_id)
    {
        $event = Event::findOrFail($event_id);
        return view('participation.organization_index', compact('event'));
    }

    public function store(string $event_id) {}

    public function update(Request $request, string $event_id, string $volunteer_id)
    {
        $event = Event::findOrFail($event_id);

        $event_end_time = Carbon::parse("{$event->date} {$event->end_time}");
        if (Carbon::now()->lessThanOrEqualTo($event_end_time)) {
            // ubah jadi indo
            return redirect()->back()->with('error', 'Penilaian relawan hanya dapat dilakukan setelah acara berakhir');
        }

        $validator = Validator::make($request->all(), [
            'is_present' => ['required', 'boolean'],
            'rating' => ['required', 'integer']
        ]);

        $validator->after(function ($validator) use ($request) {
            $is_present = filter_var($request->input('is_present'), FILTER_VALIDATE_BOOLEAN);
            $rating = $request->input('rating');

            if ($is_present && ($rating < 1 || $rating > 5)) {
                $validator->errors()->add('rating', 'Nilai harus antara 1 dan 5.');
            }

            if (!$is_present && $rating != 0) {
                $validator->errors()->add('rating', 'Nilai harus 0 jika tidak hadir.');
            }
        });

        $validated = $validator->validate();

        $volunteer = $event->volunteers()
            ->where('volunteers.id', $volunteer_id)
            ->first();

        if ($volunteer) {
            $old_value = $volunteer->pivot;
        }

        $new_value = $validated;

        $rating_delta = 0;
        $count_delta = 0;
        $point_delta = 0;

        if (!is_null($old_value->rating)) {
            $rating_delta -= $old_value->rating;
            $count_delta -= 1;
            if ($old_value->is_present) {
                $point_delta -= $event->point;
            }
        }

        $rating_delta += $new_value['rating'];
        $count_delta += 1;
        if ($new_value['is_present']) {
            $point_delta += $event->point;
        }

        DB::beginTransaction();

        try {
            $event->volunteers()->updateExistingPivot($volunteer_id, [
                'is_present' => $validated['is_present'],
                'rating' => $validated['rating']
            ]);

            $volunteer->rating_total += $rating_delta;
            $volunteer->rating_count += $count_delta;
            $volunteer->point_total += $point_delta;
            $volunteer->save();

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();

            throw $e;
        }

        return back();
    }
}
