<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Presence;
use App\Models\Therapist;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PresenceController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.therapist.presence.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, Presence $presence)
    {
        $presence->status = $request->status;
        $presence->save();

        return $this->success(
            message: 'Berhasil mengubah Presensi'
        );
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
        date_default_timezone_set('Asia/Jakarta');
        $today = Carbon::now();
        $user = Auth::user();
        $therapists = Therapist::with(['presence' => function ($query) use ($today) {
                            $query->whereDate('date', $today);
                        }])
                    ->where('franchise_id', $user->franchise_id)
                    ->get();
        $therapists = $therapists->filter(function ($therapist) {
            return $therapist->presence->isNotEmpty();
        });


        return DataTables::of($therapists)
            ->addIndexColumn()
            ->addColumn('id', fn($therapist) => format_id('therapist', $therapist->franchise->raw_id, $therapist->gender, $therapist->id))
            ->addColumn('presence', function($therapist) {
                $status = $therapist->presence[0]->status;
                $presence = $therapist->presence[0];
                 return view('pages.admin.therapist.presence.presence', compact(['status', 'presence']));
            })
            ->toJson();
    }

    public function presenceDatatables()
    {
        $user = Auth::user();
        $model = Presence::with('therapist')
            ->whereHas('therapist', function ($query) use ($user){
                $query->where('franchise_id', $user->franchise_id);
            });
        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->addColumn('date', fn($presence) => Carbon::parse($presence->date)->format('d/m/Y') )
            ->addColumn('id', fn($presence) => format_id('therapist', $user->franchise->raw_id, $presence->therapist->gender, $presence->therapist_id))
            ->addColumn('name', fn($presence) => $presence->therapist->fullname)
            ->addColumn('presence', function($presence) {
                $status = $presence->status;
                return view('pages.admin.therapist.presence.presence', compact('status', 'presence'));
            })
            ->filterColumn('date', function($query, $keyword) {
                $sql = "DATE_FORMAT(date, '%d/%m/%Y') LIKE ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->orderColumn('date', function ($query, $order) {
                $query->orderBy('date', $order);
            })
            ->toJson();
    }

}
