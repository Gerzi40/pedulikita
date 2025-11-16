<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // $events = Event::where('state', '=', 'approved')
        //         ->latest('created_at') // Urutkan berdasarkan created_at terbaru (DESC)
        //         ->take(3)            // Ambil hanya 3 record
        //         ->get();             // Jalankan query dan ambil hasilnya

        $organizations = Organization::withCount('volunteers')
            ->orderBy('volunteers_count', 'desc')
            ->take('5')
            ->get();

        $events = Event::with('city')
            ->where('state', '=', 'approved')
            ->whereRaw('date + start_time > ?', [Carbon::now()])
            ->leftJoin('event_volunteer', 'events.id', '=', 'event_volunteer.event_id')
            ->select([
                'events.id',
                'events.name',
                'events.event_category_id',
                'events.location',
                'events.city_id',
                'events.date',
                'events.start_time',
                'events.image_url',
                'events.available_slot',
                DB::raw('COUNT(event_volunteer.volunteer_id) as volunteer_count')
            ])
            ->groupBy('events.id', 'events.name', 'events.event_category_id', 'events.location', 'events.city_id', 'events.date', 'events.start_time', 'events.image_url', 'events.available_slot')
            ->havingRaw('COUNT(event_volunteer.volunteer_id) < events.available_slot')
            ->orderBy('date')
            ->take(3)
            ->get();

        return view('home.index', compact('organizations', 'events'));
    }
}
