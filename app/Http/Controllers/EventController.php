<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Province;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    public function guest_index(Request $request)
    {
        return view('events.guest_index');
    }

    public function volunteer_index(Request $request)
    {
        return view('events.volunteer_index');
    }

    public function organization_index(Request $request)
    {
        $user = Auth::user();

        $provinces = Province::get();

        $query = Event::query()
            ->with('city')
            ->leftJoin('event_volunteer', 'events.id', '=', 'event_volunteer.event_id')
            ->select([
                'events.id',
                'events.name',
                'events.city_id',
                'events.date',
                'events.start_time',
                'events.image_url',
                'events.state',
                'events.available_slot',
                DB::raw('COUNT(event_volunteer.volunteer_id) as volunteer_count')
            ])
            ->groupBy('events.id', 'events.name', 'events.city_id', 'events.date', 'events.start_time', 'events.image_url', 'events.available_slot')
            ->where('events.organization_id', '=', $user->organization->id);
        
        $events = $this->filter($query, $request);

        return view('events.organization_index', compact('provinces', 'events'));
    }

    public function admin_index(Request $request)
    {
        return view('events.admin_index');
    }

    private function filter(Builder $query, Request $request)
    {
        $validated = $request->validate([
            'name' => ['nullable', 'string'],
            'date' => ['nullable', 'date'],
            'province_id' => ['nullable', 'exists:provinces,id'],
            'city_id' => ['nullable', 'exists:cities,id'],
            'state' => ['nullable', Rule::in(['pending', 'approved', 'rejected'])],
        ]);

        $query->join('cities', 'events.city_id', '=', 'cities.id');

        if (!empty($validated['name']))
        {
            $query->where('events.name', 'ilike', '%' . $validated['name'] . '%');
        }
        if (!empty($validated['date']))
        {
            $query->where('events.date', '>=', $validated['date']);
        }
        if (!empty($validated['province_id']))
        {
            if (!empty($validated['city_id']))
            {
                $query->where('events.city_id', '=', $validated['city_id']);
            }
            else
            {
                $query->where('cities.province_id', '=', $validated['province_id']);
            }
        }
        if (!empty($validated['state']))
        {   
            $query->where('events.state', '=', $validated['state']);
        }

        $query->orderBy('events.created_at', 'desc');

        return $query->paginate(12)->withQueryString();
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {

    }

    public function guest_show(string $id)
    {
        return view('events.guest_show');
    }

    public function volunteer_show(string $id)
    {
        return view('events.volunteer_show');   
    }

    public function organization_show(string $id)
    {
        return view('events.organization_show');
    }

    public function admin_show(string $id)
    {
        return view('events.admin_show');
    }

    public function edit(string $id)
    {
        return view('events.edit');
    }

    public function update(Request $request, string $id)
    {

    }

    public function organization_destroy(string $id)
    {

    }

    public function admin_destroy(string $id)
    {

    }

    public function approve(Request $request, string $id)
    {

    }

    public function reject(Request $request, string $id)
    {

    }
}
