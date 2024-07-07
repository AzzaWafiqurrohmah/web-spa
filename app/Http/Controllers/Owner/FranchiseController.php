<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\owner\FranchiseRequest;
use App\Http\Resources\owner\FranchiseResource;
use App\Models\Franchise;
use App\Models\Region;
use App\Repository\FranchiseRepository;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class FranchiseController extends Controller
{
    use ApiResponser;

    private FranchiseRepository $repo;

    public function __construct()
    {
        $this->repo = new FranchiseRepository;
    }
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
        $provinces = Region::whereNull('parent')->orderBy('name')->get();
        $regency = (old('regency')) ?
            Region::where('code', old('regency'))->first() :
            null;

        return view(
            'pages.owner.franchise.create',
            compact('provinces', 'regency')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FranchiseRequest $request)
    {
        $this->repo->store($request->validated());
        return to_route('franchises.index')->with('swal_s', 'Berhasil menambahkan franchise');
    }

    /**
     * Display the specified resource.
     */
    public function show(Franchise $franchise)
    {
        return $this->success(
            FranchiseResource::make($franchise),
            'Berhasil mengambil data'
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Franchise $franchise)
    {
        $provinces = Region::whereNull('parent')->orderBy('name')->get();
        $regency = Region::where('code', old('regency', $franchise->raw_id))->first();

        return view(
            'pages.owner.franchise.edit',
            compact('franchise', 'provinces', 'regency')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FranchiseRequest $request, Franchise $franchise)
    {
        $this->repo->update($franchise, $request->validated());
        return to_route('franchises.index')->with('swal_s', 'Berhasil mengubah franchise');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Franchise $franchise)
    {
        $franchise->delete();
        return to_route('franchises.index')->with('swal_s', 'Berhasil menghapus franchise');
    }

    public function datatables()
    {
        return datatables(Franchise::query())
            ->addIndexColumn()
            ->addColumn('action', fn ($franchise) => view('pages.owner.franchise.action', compact('franchise')))
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
