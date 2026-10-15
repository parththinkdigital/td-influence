<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Industry extends Model
{
    protected $fillable = ['name', 'slug', 'status'];

    public function brandProfiles(): HasMany
    {
        return $this->hasMany(BrandProfile::class);
    }
}
