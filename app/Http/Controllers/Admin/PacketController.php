<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PacketsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\ImportRequest;
use App\Http\Requests\admin\PacketRequest;
use App\Http\Resources\admin\PacketResource;
use App\Imports\PacketsImport;
use App\Models\Packet;
use App\Repository\admin\PacketRepository;
use App\Service\PacketService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class PacketController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.treatment.packet.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = PacketRepository::form();
        return view('pages.admin.treatment.packet.create', [
            'treatmentsModal' => $data['treatmentsModal'],
            'checkBox' => $data['checkBox']
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PacketRequest $request)
    {
        $packet = Packet::create($request->validated());
        $packet->treatments()->attach($request->treatments);
        return to_route('packets.index')->with('alert_s', 'Berhasil menambahkan Paket');
    }

    /**
     * Display the specified resource.
     */
    public function show(Packet $packet)
    {
        return $this->success(
            PacketResource::make($packet),
            'Berhasil mendapatkan data'
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Packet $packet)
    {
        $data = PacketRepository::form($packet);
        return view('pages.admin.treatment.packet.edit', [
            'treatmentsModal' => $data['treatmentsModal'],
            'totalTreatment' => $data['totalTreatment'],
            'checkBox' => $data['checkBox'],
            'packet' => $packet
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PacketRequest $request, Packet $packet)
    {
        $packet->update($request->validated());
        $packet->treatments()->sync($request->treatments);

        return to_route('packets.index')->with('alert_s', 'Berhasil mengubah Data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Packet $packet)
    {
        $packet->treatments()->detach();
        $packet->delete();

        return $this->success(
            message: "Berhasil menghapus data"
        );
    }

    public function datatables()
    {
        return datatables(Packet::query())
            ->addIndexColumn()
            ->addColumn('price', fn($packet) =>'Rp ' . number_format($packet->packet_price))
            ->addColumn('member_price', fn($packet) => 'Rp ' . number_format($packet->member_price))
            ->addColumn('action', fn($packet) => view('pages.admin.treatment.packet.action', compact('packet')))
            ->toJson();
    }

    public function treatmentTotal(Request $request)
    {
        $treatments = [];
        if (isset($request->treatment)) {
            foreach ($request->treatment as $treatment) {
                $treatments[] = $treatment;
            }
        }
        $treatments = PacketService::treatmentTotal($treatments);
        return response()->json([
            'data' => $treatments
        ]);
    }

    public function packets(Request $request)
    {
        $q =  $request->input('q');
        $packet = Packet::query()
            ->where('name', 'like', '%' . $q . '%')
            ->orWhere('packet_price', 'like', '%' . $q . '%')
            ->orWhere('member_price', 'like', '%' . $q . '%')
            ->get();
        return response()->json([
            'data' => PacketResource::collection($packet)
        ]);
    }

    public function import(ImportRequest $request){
        try {
            $file = $request->file('fileImport')->storePublicly('packets', 'public');
            Excel::import(new PacketsImport, 'public/' . $file);
    
            return $this->success(
                message: 'Berhasil menambahkan data'
            );
    
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Import gagal',
                'errors' => $e->errors()['file'] ?? [],
            ], 422);
    
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat import',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function export()
    {
        if(count(Packet::all()) < 1){
            return response()->json([
                'data' => 'empty'
            ]);
        }
        return Excel::download(new PacketsExport(), 'packets.xlsx');
    }
}
