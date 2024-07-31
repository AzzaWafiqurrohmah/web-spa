<?php

namespace App\Imports;

use App\Models\Treatment;
use App\Models\TreatmentCategory;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class TreatmentImport implements ToModel, WithUpserts, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (empty($row['kategori']) || empty($row['nama_treatment'])) {
            return null;
        }

        $user = Auth::user();
        $category = TreatmentCategory::where('name', $row['kategori'])->first();
        if($category == null){
            $category = TreatmentCategory::create([
                    'name' => $row['kategori']
                ]);
        }
        return new Treatment([
            'treatment_category_id' => $category->id,
            'franchise_id' => $user->franchise_id,
            'name' => $row['nama_treatment'],
            'duration' => $row['durasi'],
            'pictures' => null,
            'period_start' => null,
            'period_end' => null,
            'price' => $row['harga_normal'],
            'member_price' => $row['harga_member'],
            'discount' => 0
        ]);
    }

    public function uniqueBy()
    {
        return 'name';
    }
}
