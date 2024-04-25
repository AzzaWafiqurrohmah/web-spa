<?php

namespace App\Http\Controllers;

use App\Http\Requests\TreatmentCategoryRequest;
use App\Http\Resources\TreatmentCategoryResource;
use App\Models\TreatmentCategory;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TreatmentCategoriesController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.treatment.category.index');
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
            ->addColumn('action', fn($treatmentCategory) => view('pages.treatment.category.action', compact('treatmentCategory')))
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
}
