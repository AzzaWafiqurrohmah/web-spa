<?php

namespace App\Repository\Therapist;

use App\Models\Therapist;
use Illuminate\Support\Facades\Storage;

class ProfileRepository
{
    public static function save(array $data, Therapist $therapist)
    {
        if ($therapist->image != null && isset($data['image']))
            Storage::disk('public')->delete($therapist->image);

        if (isset($data['image']))
            $data['image'] = $data['image']->storePublicly('therapist', 'public');

        return $therapist->update($data);
    }
}
