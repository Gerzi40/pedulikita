<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Volunteer extends Model
{
    protected $fillable = [
        'user_id',
        'gender',
        'date_of_birth',
        'rating_total',
        'rating_count',
        'point_total'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class)->withPivot('is_present', 'rating')->withTimestamps();
    }

    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class)->withTimestamps();
    }
}
