<?php

namespace App\Repository;

use App\Models\Franchise;
use App\Models\Packet;
use App\Models\Reservation;
use App\Models\Therapist;
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

            $total = $reservation->totals - ($reservation->transport_cost + $reservation->extra_cost) + $reservation->discount;

            $reservation->totals = ($total * 70) / 100;

            return $reservation;
        });
    }

    public function outcome(
        ?int $month = null,
        ?int $year = null,
        ?int $franchiseId = null
    ) {
        $therapists = Therapist::query();

        if ($franchiseId)
            $therapists->where('franchise_id', $franchiseId);

        $therapists = $therapists->with([
            'reservation' => function ($query) use ($month, $year) {
                if ($month) $query->whereMonth('date', $month);
                if ($year) $query->whereYear('date', $year);
            },

            'presence' => function ($query) use ($month, $year) {
                if ($month) $query->whereMonth('date', $month);
                if ($year) $query->whereYear('date', $year);
            }
        ])->get();

        return $therapists->map(function ($therapist) {
            $presents = $therapist->presence->filter(
                fn ($prs) => $prs->status == 'full' || $prs->status == 'half'
            )->count();

            $therapist->meal = $presents * 12500;
            $therapist->reservations = $therapist->reservation->map(function ($rsv) {
                $total = $rsv->totals - ($rsv->transport_cost + $rsv->extra_cost) + $rsv->discount;
                $total = ($total * 30) / 100;

                $rsv->totals = $total + ($rsv->transport_cost + $rsv->extra_cost);
                return $rsv;
            });

            return $therapist;
        });
    }

    public function franchiseIncome(
        ?int $month = null,
        ?int $year = null,
    ){
        $franchises = Franchise::query();

        $franchises = $franchises->with([
            'reservation' => function ($query) use ($month, $year) {
                if ($month) $query->whereMonth('date', $month);
                if ($year) $query->whereYear('date', $year);
            }
        ])->get();

        return $franchises->map(function ($franchise) {
            $franchise->reservations = $franchise->reservation->map(function ($rsv) {
                $total = $rsv->totals - ($rsv->transport_cost + $rsv->extra_cost) + $rsv->discount;
                $rsv->totals = ($total * 70) / 100;
                return $rsv;
            });
            return $franchise;
        });

    }

    public function presence(
        ?int $month = null,
        ?int $year = null,
        ?int $franchiseId = null
    ) {
        $therapists = Therapist::query();

        if ($franchiseId)
            $therapists->where('franchise_id', $franchiseId);

        $therapists = $therapists->with(['presence' => function ($query) use ($month, $year) {
            if ($month)
                $query->whereMonth('date', $month);

            if ($year)
                $query->whereYear('date', $year);
        }])->get();

        return $therapists->map(function ($therapist) {
            $therapist->absent = $therapist->presence->where('status', 'absent')->count();
            $therapist->present = $therapist->presence->filter(
                fn ($prs) => $prs->status == 'full' || $prs->status == 'half'
            )->count();

            return $therapist;
        });
    }
}
