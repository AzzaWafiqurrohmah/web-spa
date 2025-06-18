<?php

namespace App\Imports;

use App\Models\Treatment;
use App\Models\Tool;
use App\Models\Material;
use App\Models\TreatmentCategory;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Illuminate\Support\Collection;

class TreatmentImport implements ToCollection, WithUpserts, WithHeadingRow
{
    public $errors = [];

    public function collection(Collection $rows)
    {
        $user = Auth::user();

        foreach ($rows as $index => $row) {
            try {
                if (empty($row['kategori']) || empty($row['nama_treatment'])) {
                    $this->errors[] = "Baris " . ($index + 2) . " dilewati: Kategori atau Nama Treatment kosong.";
                    continue;
                }

                $category = TreatmentCategory::firstOrCreate([
                    'name' => $row['kategori']
                ]);

                $toolIds = collect(explode(',', $row['alat_treatment'] ?? ''))
                    ->filter()
                    ->map(function ($toolName) use ($user) {
                        return Tool::firstOrCreate(
                            ['name' => trim($toolName)], 
                            ['franchise_id' => $user->franchise_id]
                        )->id;
                    });

                $materialIds = collect(explode(',', $row['bahan_treatment'] ?? ''))
                    ->filter()
                    ->map(function ($materialName) use ($user) {
                        return Material::firstOrCreate(
                            ['name' => trim($materialName)] , 
                            ['franchise_id' => $user->franchise_id]
                        )->id;
                    });

                $periodStart = $row['tanggal_mulai'] ?? null;

                if ($periodStart) {
                    try {
                        $periodStart = \Carbon\Carbon::parse($periodStart)->format('Y-m-d');
                    } catch (\Exception $e) {
                        $periodStart = null;
                    }
                }
                    

                $treatment = Treatment::updateOrCreate(
                    [
                        'name' => $row['nama_treatment']
                    ],
                    [
                        'franchise_id' => $user->franchise_id,
                        'treatment_category_id' => $category->id,
                        'duration' => $row['durasi'] ?? 0,
                        'price' => $row['harga_normal'] ?? 0,
                        'member_price' => $row['harga_member'] ?? 0,
                        'discount' => $row['diskon'] ?? 0,
                        'period_start' => $periodStart,
                        'period_end' => null,
                        'pictures' => null,
                    ]
                );
                

                $treatment->tools()->sync($toolIds);
                $treatment->materials()->sync($materialIds);

            } catch (\Throwable $e) {
                $this->errors[] = "Baris " . ($index + 2) . " gagal: " . $e->getMessage();
                dd($this->errors);
            }
        }
    }   

    public function uniqueBy()
    {
        return 'name';
    }
}
