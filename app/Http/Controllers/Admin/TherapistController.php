<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\TherapistRequest;
use App\Http\Resources\admin\TherapistResource;
use App\Models\Therapist;
use App\Repository\admin\TherapistRepository;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function search(Request $request){
        date_default_timezone_set('Asia/Jakarta');
        $now = Carbon::now();
        $q =  $request->input('q');
        $date = $request->input('date');
        if($date == '0'){
            $date = $now->format('Y-m-d');
        }
        $time = Carbon::parse($request->input('time'))->format('H:i:s');
        if($request->input('time') == '0'){
            $time = $now->format('H:i:s');
        }
        $duration = $request->input('duration');
        $endTime = Carbon::parse($time)->addMinutes($duration)->format('H:i:s');

        $therapist = Therapist::whereNotIn('id', function ($query) use ($q, $date, $time, $endTime) {
            $query->select('reservations.therapist_id')
                ->distinct()
                ->from('reservations')
                ->joinSub(function ($query) {
                    $query->selectRaw('reservation_id, SUM(duration * 60) AS total_duration')
                        ->from('reservation_details')
                        ->join('treatments', function ($join) {
                            $join->on('reservation_details.reservationable_id', '=', 'treatments.id')
                                ->where('reservation_details.reservationable_type', 'App\Models\Treatment');
                        })
                        ->groupBy('reservation_id')
                        ->unionAll(function ($query) {
                            $query->selectRaw('reservation_id, SUM(treatments.duration * 60) AS total_duration')
                                ->from('reservation_details')
                                ->join('packets', 'reservation_details.reservationable_id', '=', 'packets.id')
                                ->join('packet_treatment', 'packets.id', '=', 'packet_treatment.packet_id')
                                ->join('treatments', 'packet_treatment.treatment_id', '=', 'treatments.id')
                                ->where('reservation_details.reservationable_type', 'App\Models\Packet')
                                ->groupBy('reservation_id');
                        });
                }, 'details', function ($join) {
                    $join->on('reservations.id', '=', 'details.reservation_id');
                })
                ->where('reservations.date', $date)
                ->where(function ($query) use ($time, $endTime) {
                    $query->where(function ($query) use ($time){
                        $query->where('reservations.time', '<=', $time)
                            ->whereRaw("ADDTIME(reservations.time, SEC_TO_TIME(details.total_duration)) >= '" . $time . "'");
                    })
                        ->orWhere(function ($query) use ($endTime, $time) {
                            $query->where('reservations.time', '>=', $time)
                                ->where('reservations.time', '<=', $endTime);
                        });
                });
        })->where(function ($query) use ($q) {
            $query->where('fullname', 'like', '%' . $q . '%')
                ->orWhere('phone', 'like', '%' . $q . '%');
        })->get();
        return response()->json([
            'data' => TherapistResource::collection($therapist)
        ]);
    }

    public function available(Request $request)
    {
        $date = $request->input('date');
        $time = $request->input('time');
        $duration = $request->input('duration');
        $endTime = Carbon::parse($time)->addMinutes($duration)->format('H:i:s');

        $therapistID = Therapist::whereNotIn('id', function ($query) use ($date, $time, $endTime) {
            $query->select('reservations.therapist_id')
                ->distinct()
                ->from('reservations')
                ->joinSub(function ($query) {
                    $query->selectRaw('reservation_id, SUM(duration * 60) AS total_duration')
                        ->from('reservation_details')
                        ->join('treatments', function ($join) {
                            $join->on('reservation_details.reservationable_id', '=', 'treatments.id')
                                ->where('reservation_details.reservationable_type', 'App\Models\Treatment');
                        })
                        ->groupBy('reservation_id')
                        ->unionAll(function ($query) {
                            $query->selectRaw('reservation_id, SUM(treatments.duration * 60) AS total_duration')
                                ->from('reservation_details')
                                ->join('packets', 'reservation_details.reservationable_id', '=', 'packets.id')
                                ->join('packet_treatment', 'packets.id', '=', 'packet_treatment.packet_id')
                                ->join('treatments', 'packet_treatment.treatment_id', '=', 'treatments.id')
                                ->where('reservation_details.reservationable_type', 'App\Models\Packet')
                                ->groupBy('reservation_id');
                        });
                }, 'details', function ($join) {
                    $join->on('reservations.id', '=', 'details.reservation_id');
                })
                ->where('reservations.date', $date)
                ->where(function ($query) use ($time, $endTime) {
                    $query->where(function ($query) use ($time){
                        $query->where('reservations.time', '<=', $time)
                            ->whereRaw("ADDTIME(reservations.time, SEC_TO_TIME(details.total_duration)) >= '" . $time . "'");
                    })
                        ->orWhere(function ($query) use ($endTime, $time) {
                            $query->where('reservations.time', '>=', $time)
                                ->where('reservations.time', '<=', $endTime);
                        });
                });
        })->pluck('id')->toArray();

        $message = 'Maaf Terapis sedang sibuk, Silahkan pilih terapis yang lain';
        if(in_array($request->input('id'), $therapistID )){
            $message = 'success';
        }
        return $this->success(
            message: $message
        );
    }

}
