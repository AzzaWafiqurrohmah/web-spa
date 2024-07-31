<?php

namespace App\Exports;

use App\Models\Therapist;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TherapistExport implements FromCollection, WithHeadings, WithStyles, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Therapist::all();
    }

    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'No Hp',
            'Jenis Kelamin',
            'Tanggal Lahir',
            'Alamat',
            'Berat Badan',
            'Tinggi Badan',
            'Mulai Bekerja',
            'email',
            'password'
        ];
    }

    public function map($row): array
    {
        return [
            $row->fullname,
            $row->phone,
            $row->gender == 'male' ? 'laki laki' : 'perempuan',
            $row->birth_date,
            $row->address,
            $row->body_weight,
            $row->body_height,
            $row->start_working,
            $row->email,
            '-'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle("A1:J1")->getFont()->setBold(true);
    }
}
