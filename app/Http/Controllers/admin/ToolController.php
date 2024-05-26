<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\ToolRequest;
use App\Http\Resources\admin\ToolResource;
use App\Models\Tool;
use App\Traits\ApiResponser;

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
        $tool = Tool::create($request->validated());

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

    public function datatables()
    {
        return datatables(Tool::query())
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
