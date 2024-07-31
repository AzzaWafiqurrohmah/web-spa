<?php

namespace App\Imports;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class CustomersImport implements ToModel, WithHeadingRow, WithUpserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (empty($row['nama_lengkap']) || empty($row['no_hp'])) {
            return null;
        }

        $user = Auth::user();

        return new Customer([
            'franchise_id' => $user->franchise_id,
            'fullname' => $row['nama_lengkap'],
            'phone' => $row['no_hp'],
            'is_member' => $row['status_member'] == 'aktif' ? 1 : 0,
            'start_member' => $row['awal_member'] ?? null,
            'address' => $row['alamat'],
            'gender' => $row['jenis_kelamin'] == 'perempuan' ? 'female' : 'male',
            'birth_date' => $row['tanggal_lahir'],
            'home_pict' => null,
            'home_details' => $row['detail_rumah'],
            'latitude' => null,
            'longitude' => null
        ]);
    }

    public function uniqueBy()
    {
        return ['fullname', 'phone'];
    }
}
