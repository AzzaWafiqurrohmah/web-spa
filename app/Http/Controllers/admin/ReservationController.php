<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\ReservationRequest;
use App\Http\Resources\admin\CustomerResource;
use App\Http\Resources\admin\TreatmentResource;
use App\Models\Customer;
use App\Models\Packet;
use App\Models\Reservation;
use App\Models\ReservationDetail;
use App\Models\Setting;
use App\Models\Therapist;
use App\Models\Treatment;
use App\Repository\admin\ReservationRepository;
use App\Service\ReservationService;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ReservationController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        return view('pages.admin.reservation.index', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = ReservationRepository::form();
        return view('pages.admin.reservation.create', [
            'setting' => $data['setting'],
            'customer' => $data['customer'],
            'therapist' => $data['therapist'],
            'treatmentsModal' => $data['treatmentsModal'],
            'packetsModal' => $data['packetModal']
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReservationRequest $request)
    {
//        dd($request->all());
        ReservationRepository::save($request->all());
        return to_route('reservations.index')->with('alert_s', 'Berhasil menambahkan Reservasi baru');
    }

    /**
     *
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        $data = ReservationRepository::show($reservation);
        $allReservation = $data['allReservation'];
        $disc_reservation = $data['disc_reservation'];
        return view('pages.admin.reservation.show', compact('reservation', 'allReservation', 'disc_reservation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        $data = ReservationRepository::form($reservation);
        return view('pages.admin.reservation.edit', [
            'setting' => $data['setting'],
            'reservation' => $reservation,
            'totalTreatments' => $data['totalTreatment'],
            'additional_disc' => $data['additional_disc'],
            'disc_treatment' => $data['disc_treatment'],
            'customer' => $data['customer'],
            'therapist' => $data['therapist'],
            'treatmentsModal' => $data['treatmentsModal'],
            'packetsModal' => $data['packetModal']
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReservationRequest $request, Reservation $reservation)
    {
        ReservationRepository::update($request->all(), $reservation);
        return to_route('reservations.index')->with('alert_s', 'Berhasil mengubah data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        //
    }

    public function cancelRsv(Reservation $reservation){
        $reservation->update(['status' => 'cancelled']);
        return $this->success(
            message: 'Berhasil membatalkan reservasi'
        );
    }

    public function datatables()
    {
        $user = Auth::user();
        $model = Reservation::with(['customer', 'therapist']);

        if($user->hasRole('admin')){
            $model = Reservation::with(['customer', 'therapist'])
                ->where('franchise_id', $user->franchise_id);
        }
        if( $user->hasRole('therapist')){
            $model = Reservation::with(['customer', 'therapist'])
                ->where('therapist_id', $user->id);
        }

        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->addColumn('id', fn ($reservation) => $reservation->date->format('dmY') . $reservation->id)
            ->addColumn('date', fn ($reservation) => $reservation->date->format('d F Y'))
            ->addColumn('totals', fn ($reservation) => "Rp " . number_format($reservation->totals))
            ->addColumn('customer', fn ($reservation) => $reservation->customer->fullname)
            ->addColumn('therapist', fn ($reservation) => $reservation->therapist->fullname)
            ->addColumn('status', fn($reservation) => view('pages.admin.reservation.status', compact('reservation')))
            ->addColumn('action', fn ($reservation) => view('pages.admin.reservation.action', compact('reservation')))
            ->filterColumn('totals', function ($query, $keyword) {
                $sql = "totals  like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->orderColumn('totals', function ($query, $order) {
                $query->orderBy('totals', $order);
            })
            ->filterColumn('id', function ($query, $keyword) {
                $sql = "CONCAT(DATE_FORMAT(date, '%d%m%Y'), id) LIKE ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('date', function ($query, $keyword) {
                $sql = "DATE_FORMAT(date, '%d %M %Y') LIKE ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->orderColumn('date', function ($query, $order) {
                $query->orderBy('date', $order);
            })
            ->toJson();
    }

    public function treatments(Request $request)
    {
        $q =  $request->input('q');
        $treatment = Treatment::query()
            ->where('name', 'like', '%' . $q . '%')
            ->orWhere('price', 'like', '%' . $q . '%')
            ->get();
        return response()->json([
            'data' => TreatmentResource::collection($treatment)
        ]);
    }

    public function customers(Request $request)
    {
        $q =  $request->input('q');
        $customer = Customer::query()
            ->where('fullname', 'like', '%' . $q . '%')
            ->orWhere('phone', 'like', '%' . $q . '%')
            ->get();
        return response()->json([
            'data' => CustomerResource::collection($customer)
        ]);
    }

    public function treatmentTotal(Request $request)
    {
        $customer = Customer::find($request->cust);
        $treatments = [];
        $packets = [];
        if (isset($request->treatment)) {
            foreach ($request->treatment as $id) {
                $code = substr($id, 0, 1);

                if($code == "P"){
                    $packets[] = substr($id, 1, 1);
                } else {
                    $treatments[] = substr($id, 1, 1);
                }
            }
        }
        $treatments = ReservationService::treatmentCost($customer, $treatments, $packets);
        return response()->json([
            'data' => $treatments
        ]);
    }
}
