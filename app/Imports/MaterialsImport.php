<?php

namespace App\Imports;

use App\Models\Material;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class MaterialsImport implements ToModel, WithUpserts, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user = Auth::user();
        return new Material([
            'franchise_id' => $user->franchise_id,
            'name' => $row['nama_bahan']
        ]);
    }

    public function uniqueBy()
    {
        return 'name';
    }

}
