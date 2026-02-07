<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\Province;
use App\Models\User;
use App\Notifications\EventApproved;
use App\Notifications\EventCreated;
use App\Notifications\NewEvent;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

class EventController extends Controller
{
    public function guest_index(Request $request)
    {
        $event_categories = EventCategory::get();
        $provinces = Province::get();

        $query = Event::query()
            ->with('city')
            ->where('state', '=', 'approved')
            ->whereRaw('date + start_time > ?', [Carbon::now()])
            ->leftJoin('event_volunteer', 'events.id', '=', 'event_volunteer.event_id')
            ->select([
                'events.id',
                'events.name',
                'events.event_category_id',
                'events.city_id',
                'events.date',
                'events.start_time',
                'events.image_url',
                'events.available_slot',
                DB::raw('COUNT(event_volunteer.volunteer_id) as volunteer_count')
            ])
            ->groupBy('events.id', 'events.name', 'events.event_category_id', 'events.city_id', 'events.date', 'events.start_time', 'events.image_url', 'events.available_slot')
            ->havingRaw('COUNT(event_volunteer.volunteer_id) < events.available_slot');
        
        $events = $this->filter($query, $request);

        return view('events.guest_index', compact('event_categories', 'provinces', 'events'));
    }

    public function volunteer_index(Request $request)
    {
        $user = Auth::user();
        $volunteer_id = $user->volunteer->id;

        $event_categories = EventCategory::get();
        $provinces = Province::get();

        $query = Event::query()
            ->with('city')
            ->where('state', '=', 'approved')
            ->whereRaw('date + start_time > ?', [Carbon::now()])
            ->leftJoin('event_volunteer', 'events.id', '=', 'event_volunteer.event_id')
            ->leftJoin('organization_volunteer', function ($join) use ($volunteer_id) {
                $join->on('events.organization_id', '=', 'organization_volunteer.organization_id')
                    ->where('organization_volunteer.volunteer_id', '=', $volunteer_id);
            })
            ->select([
                'events.id',
                'events.name',
                'events.event_category_id',
                'events.city_id',
                'events.date',
                'events.start_time',
                'events.image_url',
                'events.available_slot',
                DB::raw('COUNT(event_volunteer.volunteer_id) as volunteer_count')
            ])
            ->groupBy('events.id', 'events.name', 'events.event_category_id', 'events.city_id', 'events.date', 'events.start_time', 'events.image_url', 'events.available_slot', 'organization_volunteer.organization_id')
            ->orderByRaw('organization_volunteer.organization_id IS NOT NULL DESC')
            ->havingRaw('COUNT(event_volunteer.volunteer_id) < events.available_slot')
            ->whereNotIn('events.id', $user->volunteer->events()->pluck('id'));
        
        $events = $this->filter($query, $request);

        return view('events.volunteer_index', compact('event_categories', 'provinces', 'events'));
    }

    public function organization_index(Request $request)
    {
        $user = Auth::user();

        $event_categories = EventCategory::get();
        $provinces = Province::get();

        $query = Event::query()
            ->with('city')
            ->leftJoin('event_volunteer', 'events.id', '=', 'event_volunteer.event_id')
            ->select([
                'events.id',
                'events.name',
                'events.event_category_id',
                'events.city_id',
                'events.date',
                'events.start_time',
                'events.image_url',
                'events.state',
                'events.available_slot',
                DB::raw('COUNT(event_volunteer.volunteer_id) as volunteer_count')
            ])
            ->groupBy('events.id', 'events.name', 'events.event_category_id', 'events.city_id', 'events.date', 'events.start_time', 'events.image_url', 'events.available_slot')
            ->where('events.organization_id', '=', $user->organization->id);
        
        $events = $this->filter($query, $request);

        // [
        //     {
        //         'id': 1,
        //         'name': 'Category1',
        //         'events_count': 1
        //     },
        //     ...
        // ]
        $event_counts = Cache::remember('event_counts', Carbon::now()->addHours(1), function () {
            return EventCategory::withCount('events')->orderBy('id')->get();
        });

        // [
        //     {
        //         'month_num': '01',
        //         'month_name': 'Jan',
        //         'name': 'Category1',
        //         'events_count': 1
        //     },
        //     ...
        // ]
        $event_counts_by_month = Cache::remember('by_month_event_counts', Carbon::now()->addHours(1), function () {
            return DB::table('events')
                ->selectRaw("
                    TO_CHAR(events.date, 'MM') AS month_num,
                    TO_CHAR(events.date, 'Mon') AS month_name,
                    event_categories.name as name,
                    COUNT(events.id) as events_count
                ")
                ->join('event_categories', 'events.event_category_id', '=', 'event_categories.id')
                ->where('events.date', '>=', Carbon::now()->subMonths(5)->startOfMonth())
                ->where('events.date', '<=', Carbon::now()->endOfMonth())
                ->groupBy('month_num', 'month_name', 'event_categories.id')
                ->orderBy('event_categories.id')
                ->orderBy('month_num')
                ->get();
        });

        // [
        //     {
        //         'name': 'Category1',
        //         'volunteers_count': 1
        //     },
        //     ...
        // ]
        $volunteer_counts = Cache::remember('volunteer_counts', Carbon::now()->addHours(1), function () {
            return DB::table('event_categories')
                ->selectRaw('event_categories.name, COUNT(event_volunteer.volunteer_id) AS volunteers_count')
                ->join('events', 'event_categories.id', '=', 'events.event_category_id')
                ->join('event_volunteer', 'events.id', '=', 'event_volunteer.event_id')
                ->groupBy('event_categories.id')
                ->orderBy('event_categories.id')
                ->get();
        });

        return view('events.organization_index', compact('event_categories', 'provinces', 'events', 'event_counts', 'event_counts_by_month', 'volunteer_counts'));
    }

    public function admin_index(Request $request)
    {
        $event_categories = EventCategory::get();
        $provinces = Province::get();

        $query = Event::query()
            ->with('city')
            ->whereIn('state', ['pending', 'approved', 'finished', 'reviewed'])
            ->leftJoin('event_volunteer', 'events.id', '=', 'event_volunteer.event_id')
            ->select([
                'events.id',
                'events.name',
                'events.event_category_id',
                'events.city_id',
                'events.date',
                'events.start_time',
                'events.image_url',
                'events.available_slot',
                'events.point',
                'events.state',
                'events.description',
                DB::raw('COUNT(event_volunteer.volunteer_id) as volunteer_count')
            ])
            ->groupBy('events.id', 'events.name', 'events.event_category_id', 'events.city_id', 'events.date', 'events.start_time', 'events.image_url', 'events.available_slot', 'events.point', 'events.state', 'events.description');
        
        $events = $this->filter($query, $request);

        return view('events.admin_index', compact('event_categories', 'provinces', 'events'));
    }

    private function filter(Builder $query, Request $request)
    {
        $validated = $request->validate([
            'name' => ['nullable', 'string'],
            'event_category_id' => ['nullable', 'exists:event_categories,id'],
            'date' => ['nullable', 'date'],
            'province_id' => ['nullable', 'exists:provinces,id'],
            'city_id' => ['nullable', 'exists:cities,id'],
            'state' => ['nullable', Rule::in(['draft', 'pending', 'approved', 'finished', 'reviewed'])],
        ]);

        $query->join('cities', 'events.city_id', '=', 'cities.id');

        if (!empty($validated['name'])) {
            $query->where('events.name', 'ilike', '%' . $validated['name'] . '%');
        }
        if (!empty($validated['event_category_id'])) {
            $query->where('events.event_category_id', '=', $validated['event_category_id']);
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
        $event_categories = EventCategory::get();
        return view('events.create', compact('event_categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'event_category_id' => ['required', 'exists:event_categories,id'],
            'available_slot' => ['required', 'integer'],
            'date' => ['required', Rule::date()->after(today()->addDays(7))],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => [
                            'required',
                            'date_format:H:i',
                            'after:start_time',
                            function ($attribute, $value, $fail) use ($request) {
                                $start = Carbon::createFromFormat('H:i', $request->start_time);
                                $end   = Carbon::createFromFormat('H:i', $value);

                                // Handle next-day end time
                                if ($end->lte($start)) {
                                    $end->addDay();
                                }

                                if ($start->diffInMinutes($end) < 30) {
                                    $fail('Durasi acara minimal 30 menit.');
                                }
                            }
                        ],
            'description' => ['required', 'string'],
            'location' => ['required', 'string'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'city' => ['required', 'string'],
            'image' => ['required', 'image', 'mimes:jpg,png,jpeg', 'max:2048']
        ]);

        $user = Auth::user();

        $city = City::where('name', '=', $validated['city'])->first();
        if (!$city)
        {
            return back()->withInput()->with('error', 'Kota tidak ditemukan pada sistem');
        }

        $path = Storage::disk('s3')->putFile('events', $request->file('image'));
        if (!$path) {
            abort(500);
        }

        $event = Event::create([
            ...Arr::only($validated, [
                'name',
                'event_category_id',
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

        return redirect()->route('organization.events.show', ['id' => $event->id])->with('success', 'Acara baru berhasil dibuat dan menunggu pemberian poin oleh admin.');
    }

    public function guest_show(string $id)
    {
        $event = Event::findOrFail($id);
        return view('events.guest_show', compact('event'));
    }

    public function volunteer_show(string $id)
    {
        $event = Event::findOrFail($id);
        return view('events.volunteer_show', compact('event'));
    }

    public function organization_show(string $id)
    {
        $event = Event::findOrFail($id);
        return view('events.organization_show', compact('event'));
    }

    public function admin_show(string $id)
    {
        $event = Event::findOrFail($id);
        return view('events.admin_show', compact('event'));
    }

    public function edit(string $id)
    {
        $event = Event::findOrFail($id);

        if ($event->state != 'draft')
        {
            return redirect()->route('organization.events.show', ['id' => $event->id]);
        }

        $event_categories = EventCategory::get();
        return view('events.edit', compact('event', 'event_categories'));
    }

    public function update(Request $request, string $id)
    {
        $event = Event::findOrFail($id);

        if ($event->state != 'draft')
        {
            return redirect()->route('organization.events.show', ['id' => $event->id]);
        }

        $validator = Validator::make($request->all(), [
            'event_category_id' => ['required', 'exists:event_categories,id'],
            'available_slot' => ['required', 'integer'],
            'date' => ['required', Rule::date()->after(today()->addDays(7))],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => [
                            'required',
                            'date_format:H:i',
                            'after:start_time',
                            function ($attribute, $value, $fail) use ($request) {
                                $start = Carbon::createFromFormat('H:i', $request->start_time);
                                $end   = Carbon::createFromFormat('H:i', $value);

                                // Handle next-day end time
                                if ($end->lte($start)) {
                                    $end->addDay();
                                }

                                if ($start->diffInMinutes($end) < 30) {
                                    $fail('Durasi acara minimal 30 menit.');
                                }
                            }
                        ],
            'description' => ['required', 'string'],
            'location' => ['required', 'string'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'city' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:2048'],
        ]);

        $validator->after(function ($validator) use ($request, $event) {
            if ($request->input('location') !== $event->location) {
                if (!$request->filled('latitude') || !$request->filled('longitude') || !$request->filled('city')) {
                    $validator->errors()->add('location', 'Pilih lokasi yang sesuai.');
                }
            }
        });

        $validated = $validator->validate();

        $eventData = Arr::only($validated, ['event_category_id', 'available_slot', 'date', 'start_time', 'end_time', 'description']);

        if ($event->location != $validated['location']) {
            $city = City::where('name', '=', $validated['city'])->first();
            if (!$city)
            {
                return back()->withInput()->with('error', 'Kota tidak ditemukan pada sistem');
            }

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

        return redirect()->route('organization.events.show', ['id' => $event->id])->with('success', 'Acara berhasil diubah dan menunggu pemberian poin oleh admin.');
    }

    public function organization_destroy(string $id)
    {
        $event = Event::findOrFail($id);

        if ($event->state != 'draft')
        {
            return redirect()->route('organization.events.show', ['id' => $event->id]);
        }

        $event->delete();

        return redirect()->route('organization.events.index');
    }

    public function admin_destroy(string $id)
    {
        $event = Event::findOrFail($id);

        if ($event->state != 'draft')
        {
            return redirect()->route('admin.events.show', ['id' => $event->id]);
        }

        $event->delete();

        return redirect()->route('admin.events.index');
    }

    public function approve(Request $request, string $id) {
        $validated = $request->validate([
            'point' => ['required', 'integer', 'between:1,10']
        ]);

        $event = Event::findOrFail($id);
        
        if ($event->state != 'pending')
        {
            return redirect()->route('admin.events.show', ['id' => $event->id]);
        }

        $event->state = 'approved';
        $event->point = $validated['point'];
        $event->save();

        try
        {
            $event->organization->user->notify(new EventApproved($event->name, $validated['point'], $event->id));

            $users = $event->organization->volunteers->pluck('user');
            Notification::send($users, new NewEvent($event->organization->user->name, $event->id));
        }
        catch (Throwable $e)
        {
            Log::error($e->getMessage());
        }

        return back()->with('success', 'Poin berhasil diberikan & acara disetujui.');
    }

    public function confirm($id)
    {
        $event = Event::findOrFail($id);

        if ($event->state != 'draft')
        {
            return redirect()->route('organization.events.show', ['id' => $event->id]);
        }

        $event->state = 'pending';
        $event->save();

        try
        {
            $admins = User::where('role', '=', 'admin')->get();

            Notification::send($admins, new EventCreated($event->organization->user->name, $event->name, $event->id));
        }
        catch (Throwable $e)
        {
            Log::error($e->getMessage());
        }

        return back()->with('success', 'Acara berhasil dikonfirmasi.');
    }
}
