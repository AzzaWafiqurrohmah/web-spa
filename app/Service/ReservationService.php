<?php

namespace App\Service;

use App\Models\Customer;
use App\Models\Packet;
use App\Models\Setting;
use App\Models\Treatment;
use Illuminate\Support\Facades\Auth;
use Location\Coordinate;
use Location\Distance\Vincenty;

class ReservationService
{
    public static function transport_cost(Customer $customer)
    {
        $user = Auth::user();
        $franchise = $user->franchise;
        $transport_cost = 0;
        $setting = Setting::where('user_id', $user->id)
            ->where('key', 'biaya_transport')->first();

        if($customer->latitude !== null && $customer->longitude !== null){
            $coordinate1 = new Coordinate($customer->latitude, $customer->longitude);
            $coordinate2 = new Coordinate($franchise->latitude, $franchise->longitude);

            $calculator = new Vincenty();

            $distance = round($calculator->getDistance($coordinate1, $coordinate2)/1000);
            $transport_cost = $setting->value * $distance;
        }


        return ( $transport_cost );
    }

    public static function treatmentCost( Customer $customer, ?array $dataTreatment, ?array $dataPacket )
    {

        $total = [
            'duration' => 0,
            'price' => 0,
            'member_price' => 0,
            'discount' => 0,
            'disc_treatment' => 0,
        ];

        if(!empty($dataTreatment)){
            foreach ($dataTreatment as $id){
                $treatment = Treatment::find($id);
                $total['duration'] += $treatment->duration;
                $total['price'] += $treatment->price;
                $total['member_price'] += $treatment->member_price;
                $total['discount'] += self::discMember($customer, $treatment->price, $treatment->member_price);
                $total['disc_treatment'] += $treatment->discount;
            }
        }

        if(!empty($dataPacket)){
            foreach ($dataPacket as $id){
                $packet = Packet::find($id);

                foreach ($packet->treatments as $treatment){
                    $total['duration'] += $treatment->duration;
                }

                $total['price'] += $packet->packet_price;
                $total['member_price'] += $packet->member_price;
                $total['discount'] += self::discMember($customer, $packet->packet_price, $packet->member_price);
                $total['disc_treatment'] += 0;
            }
        }

        $total['totalTreatment'] = $total['price'];
        if($customer->is_member == 1){
            $total['totalTreatment'] = $total['member_price'];
        }

        return $total;
    }

    public static function discMember(Customer $customer, $price, $member_price )
    {
        $disc_member = 0;
        if($customer->is_member)
        {
            $disc_member = $price - $member_price;
        }
        return $disc_member;
    }

}
