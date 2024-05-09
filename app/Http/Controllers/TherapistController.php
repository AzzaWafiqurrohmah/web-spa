<?php

namespace App\Http\Controllers;

use App\Http\Requests\TherapistRequest;
use App\Http\Resources\TherapistResource;
use App\Models\Therapist;
use App\Models\Treatment;
use App\Repository\TherapistRepository;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TherapistController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $months = [];
        for ($i = 0; $i <= 2; $i++)
            $months[] = Carbon::now()->addMonths($i);

        $therapist = Therapist::query();
        if ($date = $request->month)
            $therapist->whereMonth('birth_date', $date);
        return view('pages.therapist.main.index', [
            'months' => $months
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.therapist.main.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TherapistRequest $request)
    {
        TherapistRepository::save($request->validated());
        return to_route('therapists.index')->with('alert_s', "Berhasil menambahkan Terapis");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function datatables()
    {
        $user = Auth::user();
        return datatables(Therapist::query())
            ->addIndexColumn()
            ->addColumn('id', fn($therapist) => format_id('therapist', $user->franchise->raw_id, $therapist->gender, $therapist->id))
            ->addColumn('birth_date', fn($therapist) => format_birthdate($therapist->birth_date))
            ->addColumn('action', fn($therapist) => view('pages.therapist.main.action', compact('therapist')))
            ->toJson();
    }

    public function json()
    {
        $therapists = Therapist::all();
        return $this->success(
            TherapistResource::collection($therapists),
            "Berhasil mengamil seluruh data"
        );
    }

}
