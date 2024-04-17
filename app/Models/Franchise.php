<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Franchise extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name', 'latitude', 'longitude'
    ];

    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function therapist(): HasMany
    {
        return $this->hasMany(Therapist::class);
    }

    public function customer(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    public function treatment(): HasMany
    {
        return $this->hasMany(Treatment::class);
    }
}
