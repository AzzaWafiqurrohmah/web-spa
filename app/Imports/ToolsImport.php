<?php

namespace App\Imports;

use App\Models\Tool;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Mockery\Exception;

class ToolsImport implements ToModel, WithUpserts, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user = Auth::user();
        return new Tool([
            'franchise_id' => $user->franchise_id,
            'name' => $row['nama_alat']
        ]);
    }

    public function uniqueBy()
    {
        return 'name';
    }
}
