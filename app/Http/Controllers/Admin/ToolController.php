<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ToolsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\ImportRequest;
use App\Http\Requests\admin\ToolRequest;
use App\Http\Resources\admin\ToolResource;
use App\Imports\ToolsImport;
use App\Models\Tool;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ToolController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.treatment.tool.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ToolRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();
        $data['franchise_id'] = $user->franchise_id;
        $tool = Tool::create($data);

        return $this->success(
            ToolResource::make($tool),
            'Berhasil menambahkan Alat'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Tool $tool)
    {
        return $this->success(
            ToolResource::make($tool),
            'Berhasil mengambil Data Alat'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ToolRequest $request, Tool $tool)
    {
        $tool->update($request->validated());
        return $this->success(
            ToolResource::make($tool),
            'Berhasil mengubah Data Alat'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tool $tool)
    {
        $tool->delete();
        return $this->success(
            message: 'Berhasil menghapus Data Alat'
        );
    }

    public function import(ImportRequest $request){
        $file = $request->file('fileImport')->storePublicly('tools', 'public');
        Excel::import(new ToolsImport(), 'public/' . $file);

        return $this->success(
            message: 'Berhasil menambahkan data'
        );
    }

    public function export()
    {
        if(count(Tool::all()) < 1){
            return response()->json([
                'data' => 'empty'
            ]);
        }
        return Excel::download(new ToolsExport(), 'tools.xlsx');
    }

    public function datatables()
    {
        $user = Auth::user();
        $data = Tool::where('franchise_id', $user->franchise_id);
        return datatables($data)
            ->addIndexColumn()
            ->addColumn('action', fn($tool) => view('pages.admin.treatment.tool.action', compact('tool')) )
            ->toJson();
    }

    public function json()
    {
        $tool = Tool::all();
        return $this->success(
            ToolResource::collection($tool),
            'Berhasil mengambil semua data'
        );
    }
}
