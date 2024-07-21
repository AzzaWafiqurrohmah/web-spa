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

        $condition = false;
        if(isset($packet))
        {
            $data = PacketService::treatmentTotal($treatmentID);
            $res['totalTreatment'] = $data['normalPrice'];

            if($packet->member_price == $data['member_price'] ){
                $condition = true;
            }
        }

        $checkBox = old('checkBox') ? 'checked' : ( $condition ? 'checked' : '' ) ;

        $res['treatmentsModal'] = $treatmentsModal;
        $res['checkBox'] = $checkBox;
        return $res;
    }
}
