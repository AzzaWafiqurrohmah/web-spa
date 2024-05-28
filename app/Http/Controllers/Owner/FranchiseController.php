<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Resources\owner\FranchiseResource;
use App\Models\Franchise;
use App\Repository\owner\FranchiseRepository;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class FranchiseController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.owner.franchise.index');
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $cities = FranchiseRepository::getCity();

        return view('pages.owner.franchise.create', [
            'cities' => $cities
        ]);
    }

    public function latLng(string $city)
    {
        return response()->json(
            FranchiseRepository::getLatLng($city)
        );
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
        return datatables(Franchise::query())
            ->addIndexColumn()
            ->addColumn('action', fn($franchise) => view('pages.owner.franchise.action', compact('franchise')))
            ->toJson();
    }

    public function json()
    {
        $franchises = Franchise::all();
        return $this->success(
            FranchiseResource::collection($franchises),
            'Berhasil mengambil seluruh data'
        );
    }
}
