<?php

namespace App\Repository;

use App\Models\Packet;
use App\Models\Reservation;
use App\Models\Treatment;
use Carbon\Carbon;

class DashboardRepository
{
    public static function monthlyIncome(
        ?int $franchise_id
    ){
        $reservations = Reservation::with(
            'franchise',
            'customer',
            'therapist',
            'reservationDetail.reservationable'
        )->orderBy('date', 'desc');

        if($franchise_id)
            $reservations->where('franchise_id', $franchise_id);

        $processedReservations = $reservations->get()->map(function ($reservation) {
            $packets = $reservation->reservationDetail->filter(
                fn ($detail) => $detail->reservationable_type == Packet::class,
            );

            $treatments = $reservation->reservationDetail->filter(
                fn ($detail) => $detail->reservationable_type == Treatment::class,
            );

            $reservation->total_packets = $packets->count();
            $reservation->total_treatments = $treatments->count();
            $reservation->month = Carbon::parse($reservation->date)->format('m');

            $total = $reservation->totals - ($reservation->transport_cost + $reservation->extra_cost) + $reservation->discount;

            $reservation->totals = ($total * 70) / 100;

            return $reservation;
        });

        return $processedReservations->groupBy('month')->map(function ($items) {
            return $items->sum('totals');
        });
    }
}
