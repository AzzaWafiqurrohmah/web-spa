<?php

namespace App\Repository\Therapist;

use App\Models\Therapist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileRepository
{
    public static function save(array $data)
    {
        $user = Auth::user();

        if ($user->image != null && isset($data['image']))
            Storage::disk('public')->delete($user->image);

        if(isset($data['image'])){
            $data['image'] = $data['image']->storePublicly('profile', 'public');
        }

        return $user->update($data);
    }

    public static function updatePassword(array $data)
    {
        $user = Auth::user();
        $data['password'] = Hash::make($data['password']);
        $user->update($data);
    }

}
