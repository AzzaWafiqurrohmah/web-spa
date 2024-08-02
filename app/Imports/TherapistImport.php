<?php

namespace App\Imports;

use App\Models\Therapist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class TherapistImport implements ToModel, WithUpserts, WithHeadingRow
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

        return new Therapist([
            'image' => null,
            'body_weight' => $row['berat_badan'],
            'body_height' => $row['tinggi_badan'],
            'start_working' => $row['mulai_bekerja'],
            'address' => $row['alamat'],
            'phone' => $row['no_hp'],
            'gender' => $row['jenis_kelamin'] == 'perempuan' ? 'female' : 'male',
            'birth_date' => $row['tanggal_lahir'],
            'fullname' => $row['nama_lengkap'],
            'franchise_id' => $user->franchise_id,
            'email' => $row['email'],
            'password' => Hash::make($row['password'])
        ]);
    }

    public function uniqueBy()
    {
        return ['fullname', 'phone'];
    }
}
