<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TreatmentRequest;
use App\Http\Resources\TreatmentResource;
use App\Models\Material;
use App\Models\Tool;
use App\Models\Treatment;
use App\Models\TreatmentCategory;
use App\Repository\TreatmentRepository;
use App\Traits\ApiResponser;

class TreatmentController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.treatment.main.index');
    }

    public function create()
    {
        $treatmentCategories = TreatmentCategory::all();
        $tools = Tool::all();
        $materials = Material::all();
        return view('pages.treatment.main.create', [
            'treatmentCategories' => $treatmentCategories,
            'tools' => $tools,
            'materials' => $materials
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TreatmentRequest $request)
    {
//        dd($request->all());
        TreatmentRepository::save($request->all());
        return to_route('treatments.index')->with('alert_s', "Berhasil menambahkan data Treatment");
    }

    /**
     * Display the specified resource.
     */
    public function show(Treatment $treatment)
    {
        return $this->success(
            TreatmentResource::make($treatment),
            "Berhasil mengambil data"
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Treatment $treatment)
    {
        $treatmentCategories = TreatmentCategory::all();
        $tools = Tool::all();
        $materials = Material::all();
        return view('pages.treatment.main.edit', [
            'treatmentCategories' => $treatmentCategories,
            'tools' => $tools,
            'materials' => $materials,
            'treatment' => $treatment
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TreatmentRequest $request, Treatment $treatment)
    {
        TreatmentRepository::update($request->all(), $treatment);
        return to_route('treatments.index')->with('alert_s', "Berhasil mengubah data");
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Treatment $treatment)
    {
        TreatmentRepository::destroy($treatment);
        return $this->success(
            message: "Berhasil menghapus data"
        );
    }

    public function datatables()
    {
        return datatables(Treatment::query())
            ->addIndexColumn()
            ->addColumn('action', fn($treatment) => view('pages.treatment.main.action', compact('treatment')))
            ->toJson();
    }

    public function json()
    {
        $treatments = Treatment::all();
        return $this->success(
            TreatmentResource::collection($treatments),
            'Berhasil mengambil seluruh data'
        );
    }
}
