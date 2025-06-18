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
        $data = Treatment::with(['tools', 'materials', 'treatmentCategory'])->get();
        $this->data = $data;
        return $data;
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'G' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1
        ];
    }

    public function headings(): array
    {
        return [
            'Kategori',
            'Nama Treatment',
            'Tanggal Mulai',
            'Durasi',
            'Harga Normal',
            'Harga Member',
            'Diskon',
            'Alat Treatment',
            'Bahan Treatment',
        ];
        
    }

    public function map($row): array
    {
        return [
            $row->treatmentCategory->name,
            $row->name,
            $row->period_start,
            $row->duration,
            $row->price,
            $row->member_price,
            $row->discount,
            $row->tools->pluck('name')->implode(', '),
            $row->materials->pluck('name')->implode(', '),
        ];
    }


    public function styles(Worksheet $sheet)
    {
        $row = $this->data->count() + 2;

        $sheet->getStyle("A1:I1")->getFont()->setBold(true);
        $sheet->getStyle("D{$row}")->getNumberFormat()
            ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $sheet->getStyle("E{$row}")->getNumberFormat()
            ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    }
}
