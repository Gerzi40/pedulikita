<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Event;
use App\Models\Province;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
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

        if (!empty($validated['name'])) {
            $query->where('events.name', 'ilike', '%' . $validated['name'] . '%');
        }
        if (!empty($validated['date'])) {
            $query->where('events.date', '>=', $validated['date']);
        }
        if (!empty($validated['province_id'])) {
            if (!empty($validated['city_id'])) {
                $query->where('events.city_id', '=', $validated['city_id']);
            } else {
                $query->where('cities.province_id', '=', $validated['province_id']);
            }
        }
        if (!empty($validated['state'])) {
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
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'available_slot' => ['required', 'integer'],
            'date' => ['required', Rule::date()->after(today()->addDays(7))],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'description' => ['required', 'string'],
            'location' => ['required', 'string'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'city' => ['required', 'string'],
            'image' => ['required', 'image']
        ]);

        $user = Auth::user();

        $city = City::where('name', '=', $validated['city'])->firstOrFail();

        $path = Storage::disk('s3')->putFile('events', $request->file('image'));
        if (!$path) {
            abort(500);
        }

        $event = Event::create([
            ...Arr::only($validated, [
                'name',
                'available_slot',
                'date',
                'start_time',
                'end_time',
                'description',
                'location',
                'latitude',
                'longitude',
                'city',
                'province'
            ]),
            'organization_id' => $user->organization->id,
            'city_id' => $city->id,
            'image_url' => $path,
        ]);

        // Belom bisa kirim notif

        // try
        // {
        //     $admins = User::where('role', '=', 'admin')->get();

        //     Notification::send($admins, new EventCreated($user->name, $event->name, $event->id));
        // }
        // catch (Throwable $e)
        // {
        //     Log::error($e->getMessage());
        // }

        return redirect()->route('organization.events.show', ['id' => $event->id]);
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
        $event = Event::findOrFail($id);
        return view('events.organization_show', compact('event'));
    }

    public function admin_show(string $id)
    {
        return view('events.admin_show');
    }

    public function edit(string $id)
    {
        $event = Event::findOrFail($id);
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, string $id)
    {
        $event = Event::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'available_slot' => ['required', 'integer'],
            'date' => ['required', Rule::date()->after(today()->addDays(7))],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'description' => ['required', 'string'],
            'location' => ['required', 'string'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'city' => ['nullable', 'string'],
            'image' => ['nullable', 'image'],
        ]);

        $validator->after(function ($validator) use ($request, $event) {
            if ($request->input('location') !== $event->location) {
                if (!$request->filled('latitude') || !$request->filled('longitude') || !$request->filled('city')) {
                    $validator->errors()->add('location', 'Pilih lokasi yang sesuai.');
                }
            }
        });

        $validated = $validator->validate();

        $eventData = Arr::only($validated, ['available_slot', 'date', 'start_time', 'end_time', 'description']);

        if ($event->location != $validated['location']) {
            $city = City::where('name', '=', $validated['city'])->firstOrFail();

            $eventData['location'] = $validated['location'];
            $eventData['latitude'] = $validated['latitude'];
            $eventData['longitude'] = $validated['longitude'];
            $eventData['city_id'] = $city->id;
        }

        if (!empty($validated['image'])) {
            $path = Storage::disk('s3')->putFile('events', $request->file('image'));
            if (!$path) {
                abort(500);
            }
            $eventData['image_url'] = $path;
        }

        $event->update($eventData);

        return redirect()->route('organization.events.show', ['id' => $event->id]);
    }

    public function organization_destroy(string $id)
    {
        Event::where('id', $id)->delete();
        return redirect()->route('organization.events.index');
    }

    public function admin_destroy(string $id) {}

    public function approve(Request $request, string $id) {}

    public function reject(Request $request, string $id) {}
}
