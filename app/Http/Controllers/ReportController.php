<?php

namespace App\Http\Controllers;

use App\Models\Franchise;
use App\Models\Therapist;
use App\Repository\ReportRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    private ReportRepository $repo;

    public function __construct()
    {
        $this->repo = new ReportRepository;
    }

    public function income(Request $request)
    {
        $month = $request->m ?? intval(date('m'));
        $year = $request->y ?? intval(date('Y'));
        $therapist = Therapist::find($request->t);
        $franchise = auth()->user()->franchise;

        $reservations = $this->repo->income(
            month: $month,
            year: $year,
            franchiseId: $franchise?->id,
            therapistId: $therapist?->id
        );

        return view('pages.report.income', compact(
            'reservations',
            'month',
            'year',
            'therapist'
        ));
    }

    public function outcome(Request $request)
    {
        $month = $request->m ?? intval(date('m'));
        $year = $request->y ?? intval(date('Y'));
        $franchise = auth()->user()->franchise;

        $data = $this->repo->outcome(
            month: $month,
            year: $year,
            franchiseId: $franchise?->id
        );

        return view('pages.report.outcome', compact(
            'data',
            'month',
            'year',
        ));
    }

    public function presence(Request $request)
    {
        $month = $request->m ?? intval(date('m'));
        $year = $request->y ?? intval(date('Y'));
        $franchise = auth()->user()->franchise;

        $therapists = $this->repo->presence(
            month: $month,
            year: $year,
            franchiseId: $franchise?->id
        );

        return view('pages.report.presence', compact(
            'therapists',
            'month',
            'year',
        ));
    }

    public function incomeTherapist(Request $request){

        $user = Auth::user();
        $month = $request->m ?? intval(date('m'));
        $year = $request->y ?? intval(date('Y'));

        $therapist = $this->repo->outcome(
            $month,
            $year,
            null,
            $user->id
        );

        return view('pages.report.incomeTherapist', compact(
            'therapist',
            'month',
            'year',
//            'therapist'
        ));

//        return view('pages.report.incomeTherapist');
    }
}
