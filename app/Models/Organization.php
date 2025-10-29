<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'organization_category_id',
        'city_id',
        'description',
        'founded_at',
        'instagram',
        'phone',
        'state'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function organization_category(): BelongsTo
    {
        return $this->belongsTo(OrganizationCategory::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function volunteers(): BelongsToMany
    {
        return $this->belongsToMany(Volunteer::class)->withTimestamps();
    }

    public function get_available_events(): Collection
    {
        return $this->events()
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
            ->orderBy('events.created_at', 'desc')
            ->havingRaw('COUNT(event_volunteer.volunteer_id) < events.available_slot')
            ->get();
    }
}
