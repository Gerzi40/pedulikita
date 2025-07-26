<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    protected $fillable = [
        'user_id',
        'organization_category_id',
        'city_id',
        'description',
        'founded_at',
        'instagram',
        'phone'
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
}
