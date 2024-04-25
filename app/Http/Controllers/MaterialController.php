<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaterialRequest;
use App\Http\Resources\MaterialResource;
use App\Models\Material;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.treatment.material.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MaterialRequest $request)
    {
        $material = Material::create($request->validated());
        return $this->success(
            MaterialResource::make($material),
            'Berhasil menambahkan Data Bahan'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Material $material)
    {
        return $this->success(
            MaterialResource::make($material),
            'Berhasil mengambil Data Bahan'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MaterialRequest $request, Material $material)
    {
        $material->update($request->validated());
        return $this->success(
            MaterialResource::make($material),
            'Berhasil mengubah Data Bahan'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        $material->delete();
        return $this->success(
            message: 'Berhasil menghapus Data Bahan'
        );
    }

    public function datatables()
    {
        return datatables(Material::query())
            ->addIndexColumn()
            ->addColumn('action', fn($material) => view('pages.treatment.material.action', compact('material')))
            ->toJson();
    }

    public function json()
    {
        $material = Material::all();
        return $this->success(
            MaterialResource::collection($material),
            'Berhasil mengambil seluruh data'
        );
    }

}
