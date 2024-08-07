<?php

namespace App\Http\Controllers;

use App\Exports\Report\IncomeExport;
use App\Exports\Report\OutcomeExport;
use App\Models\Franchise;
use App\Models\Therapist;
use App\Repository\ReportRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
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

    public function incomeExport(Request $request)
    {
        $month = $request->m ?? intval(date('m'));
        $year = $request->y ?? intval(date('Y'));
        $therapist = Therapist::find($request->t);
        $franchise = auth()->user()->franchise;

        return Excel::download(new IncomeExport(
            repo: $this->repo,
            month: $month,
            year: $year,
            franchiseId: $franchise?->id,
            therapistId: $therapist?->id
        ), 'Laporan - Pendapatan.xlsx');
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

    public function outcomeExport(Request $request)
    {
        $month = $request->m ?? intval(date('m'));
        $year = $request->y ?? intval(date('Y'));
        $franchise = auth()->user()->franchise;

        return Excel::download(new OutcomeExport(
            repo: $this->repo,
            month: $month,
            year: $year,
            franchiseId: $franchise?->id,
        ), 'Laporan - Pengeluaran.xlsx');
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

    public function incomeTherapist(Request $request)
    {

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
        ));
    }

    public function incomeOwner(Request $request)
    {
        $month = $request->m ?? intval(date('m'));
        $year = $request->y ?? intval(date('Y'));
        $franchise = Franchise::find($request->t);

        $reservations = $this->repo->income(
            month: $month,
            year: $year,
            franchiseId: $franchise?->id,
            therapistId: null
        );

        return view('pages.report.incomeOwner', compact(
            'reservations',
            'month',
            'year',
            'franchise'
        ));
    }
}
