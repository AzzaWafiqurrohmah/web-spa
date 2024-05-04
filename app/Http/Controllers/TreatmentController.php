<?php

namespace App\Http\Controllers;

use App\Http\Requests\TreatmentRequest;
use App\Http\Resources\TreatmentResource;
use App\Models\Material;
use App\Models\Tool;
use App\Models\Treatment;
use App\Models\TreatmentCategory;
use App\Repository\TreatmentRepository;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

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
        TreatmentRepository::save($request->all());
        return to_route('treatments.index')->with('alert_s', "Berhasil menambahkan data Treatment");
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
