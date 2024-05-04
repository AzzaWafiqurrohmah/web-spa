<?php

namespace App\Repository;

use App\Models\Treatment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TreatmentRepository
{
    public static function save(array $data, ?Treatment $treatment = null)
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


//        if ($customer && isset($data['home_pict']))
//            Storage::disk('public')->delete($customer->home_pict);

//        if ($customer) {
//            $customer->update($data);
//            return $customer;
//        }

        $treatment =  Treatment::create($data);
        $treatment->tools()->attach($data['tools']);
        $treatment->materials()->attach($data['materials']);
        return $treatment;
    }
}
