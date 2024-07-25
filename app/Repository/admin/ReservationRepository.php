<?php

namespace App\Repository\admin;

use App\Http\Resources\admin\PacketResource;
use App\Models\Customer;
use App\Models\Packet;
use App\Models\Reservation;
use App\Models\ReservationDetail;
use App\Models\Setting;
use App\Models\Therapist;
use App\Models\Treatment;
use App\Service\ReservationService;
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

        self::createDetails($data['treatments'], $reservation, $customer);

    }

    public static function update(array $data, Reservation $reservation)
    {
        $customer = Customer::find($data['customer_id']);
        $reservation->update($data);

        ReservationDetail::where('reservation_id', $reservation->id)
            ->delete();

        self::createDetails($data['treatments'], $reservation, $customer);
    }

    public static function createDetails(array $data, Reservation $reservation, Customer $customer){
        $treatments = [];
        $packets = [];
        if (isset($data)) {
            foreach ($data as $id) {
                $code = substr($id, 0, 1);

                if($code == "P"){
                    $packets[] = substr($id, 1, 1);
                } else {
                    $treatments[] = substr($id, 1, 1);
                }
            }
        }

        foreach ($treatments as $id)
        {
            $treatment = Treatment::find($id);
            ReservationDetail::create([
                'reservationable_id' => $treatment->id,
                'reservationable_type' => Treatment::class,
                'reservation_id' => $reservation->id,
                'disc_treatment' => $treatment->discount ,
                'disc_member' => self::discMember($customer, $treatment->price, $treatment->member_price)
            ]);
        }

        foreach ($packets as $id)
        {
            $packet = Packet::find($id);
            ReservationDetail::create([
                'reservationable_id' => $packet->id,
                'reservationable_type' => Packet::class,
                'reservation_id' => $reservation->id,
                'disc_treatment' => 0 ,
                'disc_member' => self::discMember($customer, $packet->packet_price, $packet->member_price)
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
        $packetID = [];

        if($reservation){
            foreach ($reservation->reservationDetail as $detail){
                if($detail->reservationable_type === 'App\Models\Packet'){
                    $packetID[] = $detail->reservationable_id;
                }

                if($detail->reservationable_type === 'App\Models\Treatment'){
                    $treatmentID[] = $detail->reservationable_id;
                }
            }
        }

        if(old('treatments')){
            foreach (old('treatments') as $id) {
                $code = substr($id, 0, 1);

                if($code == "P"){
                    $packetID[] = substr($id, 1, 1);
                } else {
                    $treatmentID[] = substr($id, 1, 1);
                }
            }
        }

        $treatmentsModal = [];
        $packetsModal = [];
        foreach ($treatmentID as $id){
            $treatment = Treatment::find($id);
            if ($customer->is_member){
                $treatment->price = $treatment->member_price;
            }
            $treatmentsModal[] = $treatment;
        }
        foreach ($packetID as $id){
            $packet = Packet::find($id);
            if ($customer->is_member){
                $packet->packet_price = $packet->member_price;
            }
            $packetsModal[] = $packet;
        }
        $res['treatmentsModal'] = $treatmentsModal;
        $res['packetModal'] = $packetsModal;

        if(isset($reservation)){
            $service = ReservationService::treatmentCost($customer, $treatmentID, $packetID);
            $totalTreatment = $service['totalTreatment'];

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
            $res['disc_treatment'] = $additional_disc + $service['disc_treatment'];
        }
        return $res;
    }

    public static function show(Reservation $reservation){
        $discount = 0;
        $allReservation = [];
        foreach ( $reservation->reservationDetail as $detail){
            if($detail->reservationable_type === Packet::class ){
                $packet = Packet::find($detail->reservationable_id);
                $data = [];
                $data['name'] = $packet->name;
                $data['price'] = $packet->packet_price;
                $data['disc_member'] = $detail->disc_member;
                $data['disc_treatment'] = $detail->disc_treatment;
                $allReservation[] = $data;
            }
            if($detail->reservationable_type === Treatment::class ){
                $treatment = Treatment::find($detail->reservationable_id);
                $data = [];
                $data['name'] = $treatment->name;
                $data['price'] = $treatment->price;
                $data['disc_member'] = $detail->disc_member;
                $data['disc_treatment'] = $detail->disc_treatment;
                $allReservation[] = $data;
            }
            $discount += ($detail->disc_member + $detail->disc_treatment);
        }
        $disc_reservation = $reservation->discount - $discount;
        $res = [];
        $res['allReservation'] = $allReservation;
        $res['disc_reservation'] = $disc_reservation;
        return $res;
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

    public static function breakTreatment(array $data){
        $res = [];
        $res['treatments'] = [];
        $res['packets'] = [];
        foreach ($data as $id) {
            $code = substr($id, 0, 1);

            if($code == "P"){
                $res['packets'] = substr($id, 1, 1);
            } else {
                $res['treatments'] = substr($id, 1, 1);
            }
        }
        return $res;
    }

}
