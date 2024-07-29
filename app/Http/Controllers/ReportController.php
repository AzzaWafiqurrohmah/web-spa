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
}
