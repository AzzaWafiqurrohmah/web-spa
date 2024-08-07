<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Packet extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name', 'packet_price', 'member_price'
    ];

    public function treatments(): BelongsToMany
    {
        return $this->belongsToMany(Treatment::class);
    }

    public function reservationDetails()
    {
        return $this->morphMany(ReservationDetail::class, 'reservationable');
    }
}
