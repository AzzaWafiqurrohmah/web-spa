<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CustomerExport implements FromCollection, WithHeadings, WithStyles, WithMapping, ShouldAutoSize
{
    private $data;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = Customer::all();
        $this->data = $data;
        return $data;
    }

    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'No Hp',
            'Jenis Kelamin',
            'Tanggal Lahir',
            'Status Member',
            'Awal Member',
            'Detail Rumah',
            'Alamat'
        ];
    }

    public function map($row): array
    {
        return [
            $row->fullname,
            $row->phone,
            $row->gender == 'male' ? 'laki laki' : 'perempuan',
            $row->birth_date,
            $row->is_member ? 'aktif' : 'tidak',
            $row->start_member ?? 0,
            $row->home_details,
            $row->address
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $row = $this->data->count() + 2;

        $sheet->getStyle("A1:F1")->getFont()->setBold(true);
    }
}
