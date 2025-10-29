<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventCategory extends Model
{
    protected $fillable = [
        'name'
    ];
    public $timestamps = false;

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
