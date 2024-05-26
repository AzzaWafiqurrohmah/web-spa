<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\TreatmentResource;
use App\Models\Customer;
use App\Models\Reservation;
use App\Models\Treatment;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.reservation.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.reservation.create');
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
        return datatables(Reservation::query())
            ->addIndexColumn()
            ->addColumn('id', fn ($reservation) => Carbon::now()->format('dmY') . $reservation->id)
            ->addColumn('date', fn ($reservation) => format_date($reservation->date))
            ->addColumn('totals', fn ($reservation) => "Rp " . $reservation->totals)
            ->addColumn('customer_name', fn ($reservation) => $reservation->customer->fullname)
            ->addColumn('action', fn ($reservation) => view('pages.reservation.action', compact('reservation')))
            ->toJson();
    }

//    public function treatments(){
//        $treatments = Treatment::all();
//        return $this->success(
//            TreatmentResource::collection($treatments),
//            'Berhasil mengambil data Treatment'
//        );
//    }

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
