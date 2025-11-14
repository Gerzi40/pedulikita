<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class News extends Model
{
    //
    protected $fillable = [
        'news_title',
        'event_id',
        'image_url',
        'desc'
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
