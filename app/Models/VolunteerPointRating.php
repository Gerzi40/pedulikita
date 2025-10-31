<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VolunteerPointRating extends Model
{
    protected $fillable = [
        'volunteer_id',
        'year',
        'month',
        'rating_total',
        'rating_count',
        'point_total'
    ];

    public function volunteer(): BelongsTo
    {
        return $this->belongsTo(Volunteer::class);
    }
}
