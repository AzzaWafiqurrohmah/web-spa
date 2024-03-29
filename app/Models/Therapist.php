<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Therapist extends Model
{
    use HasFactory;
    protected $fillable = [
        'franchise_id', 'raw_id', 'fullname', 'birth_date', 'gender',
        'phone', 'address', 'body_height', 'body_weight', 'start_working'
    ];

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
