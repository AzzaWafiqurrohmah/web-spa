<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Repository\CustomerRepository;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.customer.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.customer.create');
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('pages.customer.edit', [
            'customer' => $customer
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $request, Customer $customer)
    {
//        dd($request);
        CustomerRepository::save($request->all(), $customer);
        return to_route('customers.index')
            ->with('alert_s', 'Berhasil mengubah Data Pelanggan');
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
        return datatables(Customer::query())
            ->addIndexColumn()
            ->addColumn('id', fn($customer) => format_id('customer' ,$customer->raw_id, $customer->gender, $customer->id))
            ->addColumn('member', fn($customer) => view('pages.customer.member', compact('customer')))
            ->addColumn('action', fn($customer) => view('pages.customer.action', compact('customer')))
            ->toJson();
    }

    public function json()
    {
        $customers = Customer::all();

        return $this->success(
            CustomerResource::collection($customers),
            'Berhasil mengambil data'
        );
    }

}
