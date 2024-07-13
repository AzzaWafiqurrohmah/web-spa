<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;
    public $timestamps = false;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'franchise_id', 'fullname', 'phone', 'is_member', 'start_member', 'address',
        'gender', 'birth_date', 'home_pict', 'home_details', 'latitude', 'longitude'
    ];

    public function franchise() :BelongsTo
    {
        return $this->belongsTo(Franchise::class);
    }

    public function reservations() :HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}
