<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id', 'therapist_id', 'date', 'time','payment_type',
        'transport_cost', 'extra_cost', 'discount', 'totals'
    ];

    public function customer() :BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function therapist() :BelongsTo
    {
        return $this->belongsTo(Therapist::class);
    }

    public function reservationDetail() :HasMany
    {
        return $this->hasMany(ReservationDetail::class);
    }
}
