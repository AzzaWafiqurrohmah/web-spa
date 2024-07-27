<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Franchise;
use App\Models\Reservation;
use App\Models\Therapist;
use App\Service\DashboardService;
use App\Traits\ApiResponser;
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
        $data = DashboardService::incomePercentage($user->franchise_id);
        $dataOwner = DashboardService::incomePercentage(null);
        $dataTherapist = DashboardService::outcomePercentage();

        $customer = Customer::where('franchise_id', $user->franchise_id)->count();
        $therapist = Therapist::where('franchise_id', $user->franchise_id)->count();
        $therapistOwner = Therapist::all()->count();
        $reservation = Reservation::where('franchise_id', $user->franchise_id)->count();
        $reservationOwner = Reservation::all()->count();
        $rsvTherapist = Reservation::where('therapist_id', $user->id)->count();
        $franchise = Franchise::all()->count();

        $actTherapist = DashboardService::activeTherapist();
        $actFranchise = DashboardService::activeFranchise();
        $rsvPercent = DashboardService::reservationPercent($user->franchise_id);
        $rsvOwnerPercent = DashboardService::reservationPercent(null);
        $rsvTherapistPercent = DashboardService::reservationPercent(null, $user->id);
        $presence = DashboardService::presence();

        $role = 'admin';
        if($user->hasRole('therapist'))
            $role = 'therapist';

        return view('pages.dashboard', [
            'incomePercentage' => $data['percentage'],
            'thisMonth' => $data['thisMonth'],
            'condition' => $data['condition'],
            'incomeOwner' => $dataOwner['percentage'],
            'thisMonthOwner' => $data['thisMonth'],
            'conditionOwner' => $dataOwner['condition'],
            'outcome' => $dataTherapist['percentage'],
            'thisMonthTherapist' => $dataTherapist['thisMonth'],
            'conditionTherapist' => $dataTherapist['condition'],
            'customer' => $customer,
            'therapist' => $therapist,
            'therapistOwner' => $therapistOwner,
            'reservation' => $reservation,
            'rsvOwner' => $reservationOwner,
            'rsvCondition' => $rsvPercent['condition'],
            'rsvPercentage' => $rsvPercent['percentage'],
            'rsvOwnerCond' => $rsvOwnerPercent['condition'],
            'rsvOwnerPercentage' => $rsvOwnerPercent['percentage'],
            'actTherapist' => $actTherapist,
            'actFranchise' => $actFranchise,
            'franchise' => $franchise,
            'role' => $role,
            'presence' => $presence,
            'rsvTherapist' => $rsvTherapist,
            'rsvTherapistPercent' => $rsvTherapistPercent['percentage'],
            'rsvTherapistCond' => $rsvTherapistPercent['condition']
        ]);
    }

    public function adminChart()
    {
        $user = Auth::user();
        $monthlyTotal = [];

        if($user->hasRole('admin')){
            $monthlyTotal = DashboardService::chartDashboard($user->franchise_id);
        } else if($user->hasRole('owner')){
            $monthlyTotal = DashboardService::chartDashboard(null);
        } else {
            $monthlyTotal = DashboardService::therapistChart();
        }
        return $this->success(
            $monthlyTotal,
            'Berhasil mendapatkan data'
        );
    }

    public function adminRanking(){
        $data = [];
        $user = Auth::user();
        if($user->hasRole('admin')){
            $data = DashboardService::adminRanking($user->franchise_id);
        } else{
            $data = DashboardService::adminRanking(null);
        }
        return $this->success(
            $data,
            'Berhasil mendapatkan data'
        );
    }
}
