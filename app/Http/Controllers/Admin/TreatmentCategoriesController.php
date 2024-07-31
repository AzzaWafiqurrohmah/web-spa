<?php

namespace App\Http\Controllers\Admin;

use App\Exports\TreatmentCategoryEksport;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\ImportRequest;
use App\Http\Requests\admin\TreatmentCategoryRequest;
use App\Http\Resources\admin\TreatmentCategoryResource;
use App\Imports\TreatmentCategoryImport;
use App\Models\TreatmentCategory;
use App\Traits\ApiResponser;
use Maatwebsite\Excel\Facades\Excel;

class TreatmentCategoriesController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.treatment.category.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TreatmentCategoryRequest $request)
    {
        $treatmentCategory = TreatmentCategory::create($request->validated());

        return $this->success(
            TreatmentCategoryResource::make($treatmentCategory),
            'Berhasil menambahkan Treatment Kategori'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(TreatmentCategory $treatmentCategory)
    {
        return $this->success(
            TreatmentCategoryResource::make($treatmentCategory),
            'Berhasil mengambil detail Kategori'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TreatmentCategoryRequest $request, TreatmentCategory $treatmentCategory)
    {
        $treatmentCategory->update($request->validated());
        return $this->success(
            TreatmentCategoryResource::make($treatmentCategory),
            'Berhasil mengubah Data Kategori'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TreatmentCategory $treatmentCategory)
    {
        $treatmentCategory->delete();
        return $this->success(
            message: 'Berhasil menghapus data Kategori'
        );
    }

    public function datatables()
    {
        return datatables(TreatmentCategory::query())
            ->addIndexColumn()
            ->addColumn('action', fn($treatmentCategory) => view('pages.admin.treatment.category.action', compact('treatmentCategory')))
            ->toJson();
    }

    public function json()
    {
        $treatmentCategory = TreatmentCategory::all();

        return $this->success(
            TreatmentCategory::collection($treatmentCategory),
            'Berhasil mengambil data'
        );
    }

    public function import(ImportRequest $request){
        $file = $request->file('fileImport')->storePublicly('treatmentCategories', 'public');
        Excel::import(new TreatmentCategoryImport(), 'public/' . $file);

        return $this->success(
            message: 'Berhasil menambahkan data'
        );
    }

    public function export()
    {
        if(count(TreatmentCategory::all()) < 1){
            return response()->json([
                'data' => 'empty'
            ]);
        }
        return Excel::download(new TreatmentCategoryEksport(), 'Kategori treatment.xlsx');
    }
}
