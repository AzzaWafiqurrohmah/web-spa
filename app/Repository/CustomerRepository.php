<?php

namespace App\Repository;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CustomerRepository
{
    public static function save(array $data, ?Customer $customer = null)
    {
        $data['franchise_id'] = Auth::user()->franchise_id;
        $data['raw_id'] = '35.74';
        $data['birth_date'] = Carbon::createFromFormat('d/m/Y', $data['birth_date'])->format('Y-m-d');

        $now = Carbon::now();
        if(isset($data['member'])){
            $data['member_id'] = $now->format('dmy');
            $data['start_member'] = $now;
        }

        if (isset($data['home_pict']))
            $data['home_pict'] = $data['home_pict']->storePublicly('customers', 'public');

        if ($customer && isset($data['home_pict']))
            Storage::disk('public')->delete($customer->home_pict);

        if ($customer) {
            $customer->update($data);
            return $customer;
        }

        return Customer::create($data);
    }
}
