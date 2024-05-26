<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\TherapistRequest;
use App\Http\Resources\admin\TherapistResource;
use App\Models\Therapist;
use App\Repository\admin\TherapistRepository;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('pages.admin.therapist.main.index', [
            'months' => $months
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.therapist.main.create');
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
    public function edit(Therapist $therapist)
    {
        return view('pages.admin.therapist.main.edit', [
            'therapist' => $therapist
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TherapistRequest $request, Therapist $therapist)
    {
//        dd($request->all());
        TherapistRepository::update($therapist, $request->validated());
        return to_route('therapists.index')->with('alert_s', "Berhasil mengubah data Terapis");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Therapist $therapist)
    {
        $therapist->delete();
        return $this->success(
            message: "Berhasil menghapus data Terapis"
        );
    }

    public function datatables()
    {
        $user = Auth::user();
        return datatables(Therapist::query())
            ->addIndexColumn()
            ->addColumn('id', fn($therapist) => format_id('therapist', $user->franchise->raw_id, $therapist->gender, $therapist->id))
            ->addColumn('birth_date', fn($therapist) => format_date($therapist->birth_date))
            ->addColumn('action', fn($therapist) => view('pages.admin.therapist.main.action', compact('therapist')))
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
