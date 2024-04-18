<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Therapist extends Authenticatable
{
    use HasFactory, HasRoles;

    public $timestamps = false;

    protected $fillable = [
        'body_weight',
        'start_working',
        'address',
        'phone',
        'gender',
        'birth_date',
        'fullname',
        'password',
        'franchise_id',
        'email'
    ];

    public function franchise(): BelongsTo
    {
        return $this->belongsTo(Franchise::class);
    }

    public function presence(): HasMany
    {
        return $this->hasMany(Presence::class);
    }

    public function reservation(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}
