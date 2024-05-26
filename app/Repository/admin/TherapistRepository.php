<?php

namespace App\Repository\admin;

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
        $therapist->assignRole('therapist');
        return $therapist;
    }

    public static function update(Therapist $therapist, array $data)
    {
        if(is_null($data['password'] ?? null)) unset($data['password']);

        if(isset($data['password'])) $data['password'] = Hash::make($data['password']);

        $therapist->update($data);
        return $therapist;
    }
}
