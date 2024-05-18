<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class reservationController extends Controller
{
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
            ->addColumn('id', fn($reservation) => Carbon::now()->format('dmY') . $reservation->id)
            ->addColumn('date', fn($reservation) => format_date($reservation->date))
            ->addColumn('totals', fn($reservation) => "Rp " . $reservation->totals)
            ->addColumn('customer_name', fn($reservation) => $reservation->customer->fullname)
            ->addColumn('action', fn($reservation) => view('pages.reservation.action', compact('reservation')))
            ->toJson();
    }


}
