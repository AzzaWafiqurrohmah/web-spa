<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Treatment extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'treatment_category_id', 'franchise_id', 'name', 'duration',
        'pictures', 'period_start', 'period_end', 'price', 'discount'
    ];

    protected $casts = [
        'pictures' => 'array'
    ];

    public function reservationDetail() :HasMany
    {
        return $this->hasMany(ReservationDetail::class);
    }

    public function franchise() :BelongsTo
    {
        return $this->belongsTo(Franchise::class);
    }

    public function treatmentCatagory() :BelongsTo
    {
        return $this->belongsTo(TreatmentCategory::class);
    }

    public function tools(): BelongsToMany
    {
        return $this->belongsToMany(Tool::class);
    }

    public function materials() :BelongsToMany
    {
        return $this->belongsToMany(Material::class);
    }

    public function packets() :BelongsToMany
    {
        return $this->belongsToMany(Packet::class);
    }
}
