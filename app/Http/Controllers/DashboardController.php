<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Reservation;
use App\Models\Therapist;
use App\Repository\DashboardRepository;
use App\Repository\ReportRepository;
use App\Service\DashboardService;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $data = DashboardService::incomePercentage();
        $customer = Customer::where('franchise_id', $user->franchise_id)->count();
        $therapist = Therapist::where('franchise_id', $user->franchise_id)->count();
        $reservation = Reservation::where('franchise_id', $user->franchise_id)->count();

        $actTherapist = DashboardService::activeTherapist();
        $rsvPercent = DashboardService::reservationPercent();

        return view('pages.dashboard', [
            'incomePercentage' => $data['percentage'],
            'thisMonth' => $data['thisMonth'],
            'condition' => $data['condition'],
            'customer' => $customer,
            'therapist' => $therapist,
            'reservation' => $reservation,
            'rsvCondition' => $rsvPercent['condition'],
            'rsvPercentage' => $rsvPercent['percentage'],
            'actTherapist' => $actTherapist,
        ]);
    }

    public function adminChart()
    {
        $monthlyTotal = DashboardService::adminChart();
        return $this->success(
            $monthlyTotal,
            'Berhasil mendapatkan data'
        );
    }

    public function adminRanking(){
        $data = DashboardService::adminRanking();
        return $this->success(
            $data,
            'Berhasil mendapatkan data'
        );
    }
}
