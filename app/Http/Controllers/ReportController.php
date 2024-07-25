<?php

namespace App\Http\Controllers;

use App\Models\Therapist;
use App\Repository\ReportRepository;
use Illuminate\Http\Request;

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

        $reservations = $this->repo->income($month, $year, therapistId: $therapist?->id);

        return view('pages.report.income', compact(
            'reservations',
            'month',
            'year',
            'therapist'
        ));
    }

    public function outcome()
    {
    }

    public function presence()
    {
    }
}
