<?php

namespace App\Imports;

use App\Models\TreatmentCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class TreatmentCategoryImport implements ToModel, WithUpserts, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (empty($row['nama_kategori'])) {
            return null;
        }
        return new TreatmentCategory([
            'name' => $row['nama_kategori']
        ]);
    }

    public function uniqueBy()
    {
        return 'name';
    }
}
