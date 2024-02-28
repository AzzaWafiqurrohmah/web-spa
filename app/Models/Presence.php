<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Presence extends Model
{
    use HasFactory;

    public function therapist() :BelongsTo
    {
        return $this->belongsTo(Therapist::class);
    }
}
