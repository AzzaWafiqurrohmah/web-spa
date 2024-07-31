<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MaterialsExport;
use App\Exports\TreatmentExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\ImportRequest;
use App\Http\Requests\admin\TreatmentRequest;
use App\Http\Resources\admin\TreatmentResource;
use App\Imports\TreatmentImport;
use App\Models\Material;
use App\Models\Tool;
use App\Models\Treatment;
use App\Models\TreatmentCategory;
use App\Repository\admin\TreatmentRepository;
use App\Traits\ApiResponser;
use Maatwebsite\Excel\Facades\Excel;

class TreatmentController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.treatment.main.index');
    }

    public function create()
    {
        $treatmentCategories = TreatmentCategory::all();
        $tools = Tool::all();
        $materials = Material::all();
        return view('pages.admin.treatment.main.create', [
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
        return view('pages.admin.treatment.main.edit', [
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

    public function import(ImportRequest $request){
        $file = $request->file('fileImport')->storePublicly('treatments', 'public');
        Excel::import(new TreatmentImport(), 'public/' . $file);

        return $this->success(
            message: 'Berhasil menambahkan data'
        );
    }

    public function export()
    {
        if(count(Treatment::all()) < 1){
            return response()->json([
                'data' => 'empty'
            ]);
        }
        return Excel::download(new TreatmentExport(), 'treatment.xlsx');
    }

    public function datatables()
    {
        return datatables(Treatment::query())
            ->addIndexColumn()
            ->addColumn('duration', fn($treatment) => $treatment->duration . " menit")
            ->addColumn('price', fn($treatment) => 'Rp ' . number_format($treatment->price))
            ->addColumn('member_price', fn($treatment) => 'Rp ' . number_format($treatment->member_price))
            ->addColumn('action', fn($treatment) => view('pages.admin.treatment.main.action', compact('treatment')))
            ->filterColumn('price', function($query, $keyword) {
                $sql = "price LIKE ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('member_price', function($query, $keyword) {
                $sql = "member_price LIKE ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('duration', function($query, $keyword) {
                $sql = "CONCAT(duration, ' menit' ) LIKE ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->orderColumn('price', function ($query, $order) {
                $query->orderBy('price', $order);
            })
            ->orderColumn('member_price', function ($query, $order) {
                $query->orderBy('member_price', $order);
            })
            ->orderColumn('duration', function ($query, $order) {
                $query->orderBy('duration', $order);
            })
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
