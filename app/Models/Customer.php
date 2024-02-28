<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    public function franchise() :BelongsTo
    {
        return $this->belongsTo(Franchise::class);
    }

    public function reservations() :HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}
