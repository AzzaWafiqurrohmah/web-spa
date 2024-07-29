<?php

namespace App\Service;

use App\Models\Reservation;
use App\Models\User;
use App\Repository\ReportRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardService
{
    public static function incomePercentage(?int $franchise_id){
        $now = Carbon::now();
        $reportRepository = new ReportRepository();
        $thisMonth = $reportRepository->income(
            $now->format('m'),
            $now->format('Y'),
            $franchise_id,
            null
        )->sum('totals');
        $lastMonth = $reportRepository->income(
            $now->subMonths(1)->format('m'),
            $now->format('Y'),
            $franchise_id,
            null
        )->sum('totals');

        return self::percentage($thisMonth, $lastMonth);
    }

    public static function outcomePercentage(){
        $user = Auth::user();
        $now = Carbon::now();
        $reportRepo = new ReportRepository();
        $thisMonth = $reportRepo->outcome(
            $now->format('m'),
            $now->format('Y'),
            null,
            $user->id
        );
        if($thisMonth->isEmpty()){
            $thisMonth = 0;
        } else {
            $thisMonth = $thisMonth[0]->reservations->sum('totals');
        }

        $lastMonth = $reportRepo->outcome(
            $now->subMonths(1)->format('m'),
            $now->format('Y'),
            null,
            $user->id
        );
        if($lastMonth->isEmpty()){
            $lastMonth = 0;
        } else {
            $lastMonth = $lastMonth[0]->reservations->sum('totals');
        }

        return self::percentage($thisMonth, $lastMonth);
    }

    public static function chartDashboard(?int $franchise_id){
        $reportRepository = new ReportRepository();
        $monthlyTotal = [];
        $now = Carbon::now();
        for ($i = 5; $i >= 0; $i--) {
            $currentMonth = $now->copy()->subMonths($i);
            $reservations = $reportRepository->income(
                $currentMonth->format('m'),
                $currentMonth->format('Y'),
                $franchise_id,
                null
            );
            $res = [];
            $res['month'] = $currentMonth->format('M');
            $res['total'] = $reservations->sum('totals');
            $monthlyTotal[] = $res;
        }

        return $monthlyTotal;
    }

    public static function therapistChart(){
        $reportRepo = new ReportRepository();
        $monthlyTotal = [];
        $now = Carbon::now();
        $user = Auth::user();

        for ($i = 5; $i >= 0; $i--) {
            $currentMonth = $now->copy()->subMonths($i);
            $therapist = $reportRepo->outcome(
                $currentMonth->format('m'),
                $currentMonth->format('Y'),
                null,
                $user->id
            );
            $res = [];
            $res['month'] = $currentMonth->format('M');
            $res['total'] = $therapist[0]->reservations->sum('totals');
            $monthlyTotal[] = $res;
        }
        return $monthlyTotal;
    }

    public static function presence(){
        $user = Auth::user();
        $now = Carbon::now();
        $reportRepo = new ReportRepository();
        $presence = $reportRepo->presence(
            $now->format('m'),
            $now->format('Y'),
            null,
            $user->id
        );

        $percentage = 0;
        if($presence->isNotEmpty()){
            $totalPresence = $presence[0]->present;
            $totalDays = $now->daysInMonth;
            $percentage = ($totalPresence / $totalDays) * 100;
        }
        return (number_format($percentage, 2) . ' %');
    }

    public static function reservationPercent(
        ?int $franchise_id,
        ?int $therapistId = null
    ){
        $user = Auth::user();
        $now = Carbon::now();

        $thisMonth = Reservation::query()
            ->whereMonth('date', $now->format('m'));
        $lastMonth = Reservation::query()
            ->whereMonth('date', $now->subMonths(1)->format('m'));

        if($franchise_id){
            $thisMonth->where('franchise_id', $franchise_id);
            $lastMonth->where('franchise_id', $franchise_id);
        }

        if($therapistId){
            $thisMonth->where('therapist_id', $therapistId);
            $lastMonth->where('therapist_id', $therapistId);
        }

        $first = $thisMonth->count();
        $last = $lastMonth->count();

        return self::percentage($first, $last);
    }

    public static function activeTherapist(){
        $user = Auth::user();
        $now = Carbon::now();
        $reportRepo = new ReportRepository();
        $therapists = $reportRepo->outcome(
            $now->format('m'),
            $now->format('Y'),
            $user->franchise_id
        );

        $sortedTherapist = $therapists->map(function ($therapist){
            $therapist->totalRsv = $therapist->reservations->sum('totals');
            return $therapist;
        })
            ->filter(function ($therapist){
                return $therapist->totalRsv > 0;
            })
            ->sortByDesc('totalRsv')
            ->take(5);

        return $sortedTherapist;
    }

    public static function activeFranchise(){
        $user = Auth::user();
        $now = Carbon::now();
        $reportRepo = new ReportRepository();
        $franchises = $reportRepo->franchiseIncome(
            $now->format('m'),
            $now->format('Y')
        );

        $sortedFranchise = $franchises->map(function ($franchise){
            $franchise->totalRsv = $franchise->reservations->sum('totals');
            return $franchise;
        })
            ->filter(function ($franchise){
                return $franchise->totalRsv > 0;
            })
            ->sortByDesc('totalRsv')
            ->take(5);
        return $sortedFranchise;
    }

    public static function adminRanking(?int $franchise_id){
        $user = Auth::user();
        $now = Carbon::now();

        $firstWeek = [];
        $secondWeek = [];
        $month = [];

        for ($i = 5; $i >= 0; $i--) {
            $startMonth = $now->copy()->subMonths($i)->startOfMonth();
            $firstHalf = $startMonth->copy()->addDays(14);
            $secondHalf = $startMonth->copy()->addDays(15);
            $endMonth = $startMonth->copy()->endOfMonth();

            $first = Reservation::query()
                ->whereBetween('date', [$startMonth, $firstHalf]);
            $second = Reservation::query()
                ->whereBetween('date', [$secondHalf, $endMonth]);

            if($franchise_id){
                $first->where('franchise_id', $franchise_id);
                $second->where('franchise_id', $franchise_id);
            }

            $firstWeek[] = $first->count();
            $secondWeek[] = $second->count();
            $month[] = $now->copy()->subMonths($i)->format('M');
        }
        $res = [];
        $res['first'] = $firstWeek;
        $res['second'] = $secondWeek;
        $res['month'] = $month;
        return $res;
    }

    public static function percentage($firstVal, $secondVal){
        $condition = 'plus';
        $percentage = 0;
        if($firstVal > 0 && $secondVal > 0){
            $percentage = ($firstVal - $secondVal) / $secondVal * 100;
        } else if($secondVal <= 0){
            $percentage = 100;
        }

        if($percentage < 0) {
            $condition = 'minus';
            $percentage *= -1 ;
        }

        $res = [];
        $res['thisMonth'] = 'Rp ' . number_format($firstVal);
        $res['condition'] = $condition;
        $res['percentage'] = (number_format($percentage, 2) . ' %');
        return $res;
    }
}
