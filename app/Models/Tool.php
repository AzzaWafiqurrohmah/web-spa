<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tool extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'franchise_id', 'name'
    ];
    public function treatment() :BelongsToMany
    {
        return $this->belongsToMany(Treatment::class);
    }

    public function franchise(): BelongsTo
    {
        return  $this->belongsTo(Franchise::class);
    }
}
