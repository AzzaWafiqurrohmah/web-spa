<?php

namespace App\Repository\admin;

use App\Models\Customer;
use App\Models\Reservation;
use App\Models\ReservationDetail;
use App\Models\Setting;
use App\Models\Therapist;
use App\Models\Treatment;
use Cassandra\Custom;
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
            'totals' => $data['totals']
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

    public static function update(array $data, Reservation $reservation)
    {
        $customer = Customer::find($data['customer_id']);
        $reservation->update($data);

        ReservationDetail::where('reservation_id', $reservation->id)
            ->delete();

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

    public static function form(?Reservation $reservation = null)
    {
        $user = Auth::user();
        $res = [];

        $data = Setting::where('user_id', $user->id)->get(['key', 'value']);
        $setting = $data->pluck(null, 'key')->map(function ($item) {
            return $item['value'];
        })->toArray();
        $res['setting'] = $setting;

        $customer = Customer::find(old('customer_id') ?? ($reservation?->customer_id ?? '0'));
        $therapist = Therapist::find(old('therapist_id') ?? ( $reservation->therapist_id) ?? '0');
        $res['customer'] = $customer;
        $res['therapist'] = $therapist;

        $treatmentID = [];
        if($reservation || old('treatments')) {
            foreach ( (old('treatments') ?? $reservation?->reservationDetail) as $detail){
                $treatmentID[] = old('treatments') ? $detail : $detail->treatment_id;
            }
        }

        $treatmentsModal = [];
        if(count($treatmentID) != 0){
            foreach ($treatmentID as $id){
                $treatmentsModal[] = Treatment::find($id);
            }
        }
        $res['treatmentsModal'] = $treatmentsModal;

        if(isset($reservation)){
            $totalTreatment = 0;
            foreach ($reservation->reservationDetail as $reservationDetail){
                $totalTreatment += $reservationDetail->treatment->price;
            }

            $disc_member = 0;
            $disc_treatment = 0;
            $totalDisc = $reservation->discount;
            foreach ($reservation->reservationDetail as $detail){
                $disc_member += $detail->disc_member;
                $disc_treatment += $detail->disc_treatment;
            }
            $additional_disc = $totalDisc - $disc_member - $disc_treatment;

            $res['totalTreatment'] = $totalTreatment;
            $res['additional_disc'] = $additional_disc;
        }
        return $res;
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
