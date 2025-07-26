<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    protected $fillable = [
        'organization_id',
        'name',
        'date',
        'start_time',
        'end_time',
        'image_url',
        'description',
        'location',
        'city_id',
        'latitude',
        'longitude',
        'available_slot',
        'point',
        'state'
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function volunteers(): BelongsToMany
    {
        return $this->belongsToMany(Volunteer::class)->withPivot('is_present', 'rating')->withTimestamps();
    }
}
