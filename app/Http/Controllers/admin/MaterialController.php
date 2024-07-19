<?php

namespace App\Http\Controllers\admin;

use App\Exports\MaterialsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\ImportRequest;
use App\Http\Requests\admin\MaterialRequest;
use App\Http\Resources\admin\MaterialResource;
use App\Imports\MaterialsImport;
use App\Models\Material;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class MaterialController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.treatment.material.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MaterialRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();
        $data['franchise_id'] = $user->franchise_id;

        $material = Material::create($data);
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

    public function import(ImportRequest $request){
        $file = $request->file('fileImport')->storePublicly('tools', 'public');
        Excel::import(new MaterialsImport(), 'public/' . $file);

        return $this->success(
            message: 'Berhasil menambahkan data'
        );
    }

    public function export()
    {
        if(count(Material::all()) < 1){
            return response()->json([
                'data' => 'empty'
            ]);
        }
        return Excel::download(new MaterialsExport(), 'materials.xlsx');
    }

    public function datatables()
    {
        $user = Auth::user();
        $data = Material::where('franchise_id', $user->franchise_id);
        
        return datatables($data)
            ->addIndexColumn()
            ->addColumn('action', fn($material) => view('pages.admin.treatment.material.action', compact('material')))
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
