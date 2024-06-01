<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\admin\CustomerResource;
use App\Http\Resources\admin\TreatmentResource;
use App\Models\Customer;
use App\Models\Reservation;
use App\Models\Treatment;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ReservationController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.reservation.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.reservation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        return $this->success(
            'Berhasil mengambil data'
        );
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
        $model = Reservation::with(['customer', 'therapist']);
        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->addColumn('id', fn ($reservation) => format_reservation($reservation->date) . $reservation->id)
            ->addColumn('date', fn ($reservation) => format_date($reservation->date))
            ->addColumn('totals', fn ($reservation) => "Rp " . $reservation->totals)
            ->addColumn('customer', fn($reservation) => $reservation->customer->fullname)
            ->addColumn('therapist', fn($reservation) => $reservation->therapist->fullname )
            ->addColumn('action', fn ($reservation) => view('pages.admin.reservation.action', compact('reservation')))
            ->filterColumn('totals', function($query, $keyword) {
                $sql = "totals  like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->orderColumn('totals', function ($query, $order) {
                $query->orderBy('totals', $order);
            })
            ->filterColumn('id', function($query, $keyword) {
                $sql = "CONCAT(DATE_FORMAT(date, '%d%m%Y'), id) LIKE ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('date', function($query, $keyword) {
                $sql = "DATE_FORMAT(date, '%d %M %Y') LIKE ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->orderColumn('date', function ($query, $order) {
                $query->orderBy('date', $order);
            })
            ->toJson();
    }

    public function treatments(Request $request)
    {
        $q =  $request->input('q');
        $treatment = Treatment::query()
            ->where('name', 'like', '%' . $q . '%')
            ->orWhere('price', 'like', '%' . $q . '%')
            ->get();
        return response()->json([
            'data' => TreatmentResource::collection($treatment)
        ]);
    }

    public function customers(Request $request)
    {
        $q =  $request->input('q');
        $customer = Customer::query()
            ->where('fullname', 'like', '%' . $q . '%')
            ->orWhere('phone', 'like', '%' . $q . '%')
            ->get();
        return response()->json([
            'data' => CustomerResource::collection($customer)
        ]);
    }
}
