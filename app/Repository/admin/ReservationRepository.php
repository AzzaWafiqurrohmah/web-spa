<?php

namespace App\Repository\admin;

use App\Models\Customer;
use App\Models\Reservation;
use App\Models\ReservationDetail;
use App\Models\Setting;
use App\Models\Treatment;
use Illuminate\Support\Facades\Auth;

class ReservationRepository
{
    public static function save(array $data)
    {
        $user = Auth::user();
        $customer = Customer::find($data['customer_id']);
        $reservation = Reservation::create([
            'franchise_id' => $user->franchise_id,
            'customer_id' => $data['customer_id'],
            'therapist_id' => $data['therapist_id'] ,
            'date' => $data['date'] ,
            'time' => $data['time'] ,
            'payment_type' => $data['payment_type'],
            'transport_cost' => $data['transport_cost'],
            'extra_cost' => $data['extra_cost'],
            'discount' => $data['discount'] ,
            'totals' => $data['total']
        ]);

        foreach ($data['treatments'] as $id)
        {
            $treatment = Treatment::find($id);
            ReservationDetail::create([
                'treatment_id' => $treatment->id ,
                'reservation_id' => $reservation->id ,
                'disc_treatment' => $treatment->discount ,
                'disc_member' => self::discMember($customer, $treatment->price)
            ]);
        }
    }

    public static function discMember(Customer $customer, $price)
    {
        $user = Auth::user();
        $setting = Setting::where('user_id', $user->id)
            ->where('key', 'diskon_member')->first();
        $disc_member = 0;

        if($customer->is_member)
        {
            $disc_member = $price * ($setting->value / 100);
        }
        return $disc_member;
    }
}
