<?php

namespace App\Repository;

use App\Models\Packet;
use App\Models\Reservation;
use App\Models\Treatment;

class ReportRepository
{
    public function income(
        ?int $month = null,
        ?int $year = null,
        ?int $franchiseId = null,
        ?int $therapistId = null
    ) {
        $reservations = Reservation::with(
            'franchise',
            'customer',
            'therapist',
            'reservationDetail.reservationable'
        );

        if ($therapistId)
            $reservations->where('therapist_id', $therapistId);

        if ($franchiseId)
            $reservations->where('franchise_id', $franchiseId);

        if ($month)
            $reservations->whereMonth('date', $month);

        if ($year)
            $reservations->whereYear('date', $year);

        return $reservations->get()->map(function ($reservation) {
            $packets = $reservation->reservationDetail->filter(
                fn ($detail) => $detail->reservationable_type == Packet::class,
            );

            $treatments = $reservation->reservationDetail->filter(
                fn ($detail) => $detail->reservationable_type == Treatment::class,
            );

            $reservation->total_packets = $packets->count();
            $reservation->total_treatments = $treatments->count();

            return $reservation;
        });
    }
}
