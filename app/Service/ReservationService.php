<?php

namespace App\Service;

use App\Models\Customer;
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
        $setting = Setting::where('user_id', $user->id)
            ->where('key', 'biaya_transport')->first();

        $coordinate1 = new Coordinate($customer->latitude, $customer->longitude);
        $coordinate2 = new Coordinate($franchise->latitude, $franchise->longitude);

        $calculator = new Vincenty();

        $distance = round($calculator->getDistance($coordinate1, $coordinate2)/1000);

        return ( $setting->value * $distance );
    }

    public static function treatmentCost($data, Customer $customer)
    {
        $user = Auth::user();
        $setting = Setting::where('user_id', $user->id)
            ->where('key', 'diskon_member')->first();

        $treatments = array_map(function($id) use ($customer, $setting){
            $treatment = Treatment::find($id);
            $reservation = [];
            $reservation['duration'] = $treatment->duration;
            $reservation['disc_member'] = 0;
            if($customer->is_member == 1){
                $reservation['disc_member'] =  (($setting->value/100) * $treatment->price);
            }
            $reservation['discount'] = $treatment->discount;
            $reservation['price'] = $treatment->price;
            return $reservation;
        }, $data);

        $totalTreatments = 0;
        $disc = 0;
        $duration = 0;
        for ($i = 0; $i < count($treatments); $i++) {
            $totalTreatments += ($treatments[$i]['price'] - $treatments[$i]['disc_member'] - $treatments[$i]['discount']);
            $disc += ($treatments[$i]['disc_member'] + $treatments[$i]['discount']);
            $duration += $treatments[$i]['duration'];
        }

        $allTreatments = [];
        $allTreatments['totalTreatment'] = $totalTreatments;
        $allTreatments['disc'] = $disc;
        $allTreatments['duration'] = $duration;


        return $allTreatments;
    }

}
