<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\News;
use App\Models\Event;

class NewsController extends Controller
{
    public function guest_index(Request $request)
    {
        
    }

    public function volunteer_index(Request $request)
    {
        $news = News::orderByDesc('created_at')->get();

        return view('news.volunteer_index', compact('news'));
    }

    public function organization_index(Request $request)
    {
        // get events of the authenticated user's organization that have already passed (date < today)
        $user = Auth::user();

        $events = $user->organization->events()
            ->whereDate('date', '<', Carbon::today()->toDateString())
            // ensure we only pick events belonging to this organization
            ->where('events.organization_id', '=', $user->organization->id)->get();

        return view('news.organization_index', compact('events'));
    }

    public function create($event_id)
    {
        $user = Auth::user();
        $event = $user->organization->events()->where('id', $event_id)->first();
        $total_volunteer = $event->volunteers()->count();
        $news = News::where('event_id', $event_id)->first();

        if($news){
            return view('news.create', compact('event', 'total_volunteer', 'news'));
        }

        return view('news.create', compact('event', 'total_volunteer'));
    }

    public function store(Request $request)
    {
        // validate inputs
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'event_id' => 'required|integer|exists:events,id',
            'gambar.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();

        // ensure the event belongs to the authenticated user's organization
        $event = $user->organization->events()->where('id', $validated['event_id'])->first();
        if (!$event) {
            abort(403, 'Unauthorized or invalid event');
        }

        // find existing news for this event (we'll update if exists)
        $existingNews = News::where('event_id', $event->id)->first();

        // store uploaded images (if any) to S3 under a 'news/events' prefix first
        // collect all returned paths and prepare an image_url value (semicolon-separated)
        $image_url_value = '';

        if ($request->hasFile('gambar')) {
            $files = $request->file('gambar');
            $paths = [];

            foreach ($files as $file) {
                if (!$file->isValid()) continue;

                // upload to S3 with 'news/events' prefix
                $path = Storage::disk('s3')->putFile('news/events', $file);
                if (!$path) {
                    // if upload failed for any file, abort with 500
                    abort(500, 'Gagal mengunggah gambar.');
                }

                $paths[] = $path; // e.g. 'news/events/abc.jpg'
            }

            if (count($paths) > 0) {
                $image_url_value = implode(';', $paths);
            }
        } else {
            // no new files uploaded: keep existing paths when updating, or empty for new record
            $image_url_value = $existingNews ? $existingNews->image_url : '';
        }

        if ($existingNews) {
            // update existing
            $existingNews->news_title = $validated['judul'];
            $existingNews->desc = $validated['deskripsi'];
            $existingNews->image_url = $image_url_value;
            $existingNews->save();
            $existingNews;
            $message = 'Berita berhasil diperbarui.';
        } else {
            // create new
            News::create([
                'news_title' => $validated['judul'],
                'event_id' => $event->id,
                'desc' => $validated['deskripsi'],
                'image_url' => $image_url_value,
            ]);
            $event = Event::where('id', $event->id)->first();
            $event->state = 'reviewed';
            $event->save();
            $message = 'Berita berhasil dibuat.';
        }

        return redirect()->route('organization.news.index')->with('success', 'Berita berhasil dibuat.');
    }

    public function guest_show(string $id)
    {
        
    }

    public function volunteer_show(string $id)
    {
        // eager load event -> organization -> user to avoid N+1 and ensure relations are available in the view
        $news = News::with('event.organization.user')->findOrFail($id);

        return view('news.volunteer_show', compact('news'));
    }

}
