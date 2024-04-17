<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, HasRoles;

    public $timestamps = false;
    protected $fillable = [
        'name', 'email', 'password', 'franchise_id'
    ];

    public function franchise(): BelongsTo
    {
        return $this->belongsTo(Franchise::class);
    }
}
