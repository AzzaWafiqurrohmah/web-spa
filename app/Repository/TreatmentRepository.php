<?php

namespace App\Repository;

use App\Models\Treatment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TreatmentRepository
{
    public static function save(array $data)
    {
        $period_start = Carbon::parse($data['period_start']);
        $data['period_end'] = $period_start->addMonth()->toDateString();
        $data['franchise_id'] = Auth::user()->franchise_id;

        if (isset($data['pictures'])) {
            $storedPictures = [];
            foreach ($data['pictures'] as $pict) {
                $storedPath = $pict->storePublicly('treatments', 'public');
                $storedPictures[] = $storedPath;
            }
            $data['pictures'] = $storedPictures;
        }

        $treatment =  Treatment::create($data);
        $treatment->tools()->attach($data['tools']);
        $treatment->materials()->attach($data['materials']);
        return $treatment;
    }

    public static function update(array $data, Treatment $treatment)
    {
        $lastPict = $treatment->pictures;
        if(isset($data['deletePict']))
        {
            $lastPict = static::removePict($lastPict, array_flip($data['deletePict']));
        }

        if(isset($data['pictures']))
        {
            $lastPict = static::removePict($lastPict, $data['pictures']);
            $edited = array_merge($lastPict, $data['pictures']);
            $lastPict = array_map(
                function ($pict) {
                    if (is_string($pict)) return $pict;
                    return $pict->storePublicly('treatments', 'public');
                    },
                $edited);
        }

        $data['pictures'] = $lastPict;
        $treatment->tools()->sync($data['tools']);
        $treatment->materials()->sync($data['materials']);
        $treatment->update($data);

    }

    public static function removePict(array $firstArray, array $secondArray) :array
    {
        $deleted = array_intersect_key($firstArray, $secondArray);
        Storage::disk('public')->delete($deleted);
        foreach ($deleted as $key => $value) {
            unset($firstArray[$key]);
        }
        return $firstArray;
    }

}
