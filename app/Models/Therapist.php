<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Therapist extends Model
{
    use HasFactory;

    public function franchise() :BelongsTo
    {
        return $this->belongsTo(Franchise::class);
    }

    public function presence() :HasMany
    {
        return $this->hasMany(Presence::class);
    }

    public function reservation() :HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}
