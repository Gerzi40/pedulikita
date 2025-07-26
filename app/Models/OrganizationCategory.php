<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrganizationCategory extends Model
{
    protected $fillable = [
        'name'
    ];
    public $timestamps = false;

    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class);
    }
}
