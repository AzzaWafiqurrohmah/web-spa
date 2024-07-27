<?php

namespace App\Service;

use App\Models\Reservation;
use App\Repository\ReportRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardService
{
    public static function incomePercentage(){
        $user = Auth::user();
        $now = Carbon::now();
        $reportRepository = new ReportRepository();
        $thisMonth = $reportRepository->income(
            $now->format('m'),
            $now->format('Y'),
            $user->franchise_id,
            null
        )->sum('totals');
        $lastMonth = $reportRepository->income(
            $now->subMonths(1)->format('m'),
            $now->format('Y'),
            $user->franchise_id,
            null
        )->sum('totals');

        return self::percentage($thisMonth, $lastMonth);
    }

    public static function adminChart(){
        $reportRepository = new ReportRepository();
        $user = Auth::user();
        $monthlyTotal = [];
        $now = Carbon::now();
        for ($i = 5; $i >= 0; $i--) {
            $currentMonth = $now->copy()->subMonths($i);
            $reservations = $reportRepository->income(
                $currentMonth->format('m'),
                $currentMonth->format('Y'),
                $user->franchise_id,
                null
            );
            $res = [];
            $res['month'] = $currentMonth->format('M');
            $res['total'] = $reservations->sum('totals');
            $monthlyTotal[] = $res;
        }

        return $monthlyTotal;
    }

    public static function reservationPercent(){
        $user = Auth::user();
        $now = Carbon::now();

        $thisMonth = Reservation::query()
            ->whereMonth('date', $now->format('m'))
            ->where('franchise_id', $user->franchise_id)
            ->count();
        $lastMonth = Reservation::query()
            ->whereMonth('date', $now->subMonths(1)->format('m'))
            ->where('franchise_id', $user->franchise_id)
            ->count();

        return self::percentage($thisMonth, $lastMonth);
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

    public static function adminRanking(){
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
                ->where('franchise_id', $user->franchise_id)
                ->whereBetween('date', [$startMonth, $firstHalf])
                ->count();
            $second = Reservation::query()
                ->where('franchise_id', $user->franchise_id)
                ->whereBetween('date', [$secondHalf, $endMonth])
                ->count();

            $firstWeek[] = $first;
            $secondWeek[] = $second;
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
        if($firstVal > 0){
            $percentage = ($firstVal - $secondVal) / $secondVal * 100;
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
