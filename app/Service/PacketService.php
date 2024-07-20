<?php

namespace App\Service;

use App\Models\Treatment;

class PacketService
{
    public static function treatmentTotal($data)
    {
        $totalTreatments = 0;
        $memberPrice = 0;
        foreach ($data as $id)
        {
            $treatment = Treatment::find($id);
            $totalTreatments += $treatment->price;
            $memberPrice += $treatment->member_price;
        }

        $res = [];
        $res['normalPrice'] = $totalTreatments;
        $res['member_price'] = $memberPrice;

        return $res;
    }
}
