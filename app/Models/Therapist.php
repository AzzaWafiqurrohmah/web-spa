<?php

namespace App\Models;

use Carbon\Carbon;
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
        'body_height',
        'start_working',
        'address',
        'phone',
        'gender',
        'birth_date',
        'fullname',
        'franchise_id',
        'email',
        'password'
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
