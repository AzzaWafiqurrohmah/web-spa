<?php

namespace App\Imports;

use App\Models\Tool;
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
        return new Tool([
            'name' => $row['nama_alat']
        ]);
    }

    public function uniqueBy()
    {
        return 'name';
    }
}
