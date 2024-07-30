<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\CustomerRequest;
use App\Http\Resources\admin\CustomerResource;
use App\Models\Customer;
use App\Repository\admin\CustomerRepository;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $months = [];
        for ($i = 0; $i <= 2; $i++)
            $months[] = Carbon::now()->addMonths($i);

        $customer = Customer::query()->where('franchise_id', $user->franchise_id);
        if ($date = $request->month)
            $customer->whereMonth('birth_date', $date);

        return view('pages.admin.customer.index', [
            'date' => $request->month,
            'months' => $months
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerRequest $request)
    {
        CustomerRepository::save($request->all());

        return to_route('customers.index')
            ->with('alert_s', 'Berhasil menambahkan Pelanggan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return $this->success(
            CustomerResource::make($customer),
            'Berhasil mengambil detail Kategori'
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('pages.admin.customer.edit', [
            'customer' => $customer
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $request, Customer $customer)
    {
        CustomerRepository::save($request->all(), $customer);
        return to_route('customers.index')
            ->with('alert_s', 'Berhasil mengubah Data Pelanggan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        Storage::disk('public')->delete($customer->home_pict);
        $customer->delete();

        return $this->success(
            message: 'Berhasil menghapus Data Pelanggan'
        );
    }

    public function member(string $id)
    {
        $now = Carbon::now();
        $customer = Customer::find($id);
        $customer->update([
            'is_member' => 1,
            'start_member' => $now
        ]);

        return $this->success(
            message: "Berhasil menambahkan member"
        );
    }

    public function birthdate(string $month)
    {
        $user = Auth::user();
        $customers = Customer::whereMonth('birth_date', $month)->where('franchise_id', $user->franchise_id);

        $user = Auth::user();
        return datatables($customers)
            ->addIndexColumn()
            ->addColumn('id', fn($customer) => format_id('customer' ,$user->franchise->raw_id, $customer->gender, $customer->id))
            ->addColumn('birth_date', fn($customer) => format_date($customer->birth_date))
            ->addColumn('member', fn($customer) => view('pages.admin.customer.member', compact('customer')))
            ->addColumn('action', fn($customer) => view('pages.admin.customer.action', compact('customer')))
            ->filterColumn('birth_date', function($query, $keyword) {
                $sql = "DATE_FORMAT(birth_date, '%d %M %Y') LIKE ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->orderColumn('birth_date', function ($query, $order) {
                $query->orderBy('birth_date', $order);
            })
            ->toJson();

    }

    public function datatables()
    {
        $user = Auth::user();
        return datatables(Customer::query()->where('franchise_id', $user->franchise_id))
            ->addIndexColumn()
            ->addColumn('id', fn($customer) => format_id('customer' ,$user->franchise->raw_id, $customer->gender, $customer->id))
            ->addColumn('birth_date', fn($customer) => format_date($customer->birth_date))
            ->addColumn('member', fn($customer) => view('pages.admin.customer.member', compact('customer')))
            ->addColumn('action', fn($customer) => view('pages.admin.customer.action', compact('customer')))
            ->filterColumn('birth_date', function($query, $keyword) {
                $sql = "DATE_FORMAT(birth_date, '%d %M %Y') LIKE ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->orderColumn('birth_date', function ($query, $order) {
                $query->orderBy('birth_date', $order);
            })
            ->toJson();
    }

    public function json()
    {
        $user = Auth::user();
        $customers = Customer::all()->where('franchise_id', $user->franchise_id);

        return $this->success(
            CustomerResource::collection($customers),
            'Berhasil mengambil data'
        );
    }

}
