<?php

namespace App\Exports;

use App\Models\Treatment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TreatmentExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithColumnFormatting, WithStyles
{
    private $data;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = Treatment::all();
        $this->data = $data;
        return $data;
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    public function headings(): array
    {
        return [
            'Kategori',
            'Nama Treatment',
            'Durasi',
            'Harga Normal',
            'Harga Member',
        ];
    }

    public function map($row): array
    {
        return [
            $row->treatmentCategory->name,
            $row->name,
            $row->duration,
            $row->price,
            $row->member_price,
            $row->discount
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $row = $this->data->count() + 2;

        $sheet->getStyle("A1:F1")->getFont()->setBold(true);
        $sheet->getStyle("D{$row}")->getNumberFormat()
            ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $sheet->getStyle("E{$row}")->getNumberFormat()
            ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    }
}
