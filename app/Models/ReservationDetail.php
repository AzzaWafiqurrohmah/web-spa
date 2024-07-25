<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReservationDetail extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'reservationable_id', 'reservationable_type', 'reservation_id', 'disc_treatment', 'disc_member'
    ];
    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }

    public function reservationable()
    {
        return $this->morphTo();
    }
}
