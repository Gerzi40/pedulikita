<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    protected $fillable = [
        'province_id',
        'name'
    ];
    public $timestamps = false;

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
