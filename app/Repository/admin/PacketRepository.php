<?php

namespace App\Repository\admin;

use App\Models\Packet;
use App\Models\Treatment;
use App\Service\PacketService;

class PacketRepository
{
    public static function form(?Packet $packet = null){
        $res = [];
        $treatmentID = [];
        if($packet || old('treatments')) {
            foreach ( (old('treatments') ?? $packet?->treatments) as $detail){
                $treatmentID[] = old('treatments') ? $detail : $detail->id;
            }
        }

        $treatmentsModal = [];
        if(count($treatmentID) != 0){
            foreach ($treatmentID as $id){
                $treatmentsModal[] = Treatment::find($id);
            }
        }

        if(isset($packet))
        {
            $res['totalTreatment'] = PacketService::treatmentTotal($treatmentID);
        }

        $res['treatmentsModal'] = $treatmentsModal;
        return $res;
    }
}
