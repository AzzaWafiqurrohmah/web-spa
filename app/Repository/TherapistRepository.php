<?php

namespace App\Repository;

use App\Models\Therapist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TherapistRepository
{
    public static function save(array $data) :Therapist
    {
        $user = Auth::user();
        $data['franchise_id'] = $user->franchise_id;
        $data['password'] = Hash::make($data['password']);

        $therapist = Therapist::create($data);
        return $therapist;
    }
}
