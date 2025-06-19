<?php

namespace App\Exports;

use App\Models\Packet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PacketsExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithColumnFormatting, WithStyles
{
    private $data;

    public function collection()
    {
        $this->data = Packet::with('treatments')->get();
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'Nama Paket',
            'Treatments',
            'Harga Normal',
            'Harga Member',
        ];
    }

    public function map($packet): array
    {
        $treatmentNames = $packet->treatments->pluck('name')->implode(', ');
        $totalPrice = $packet->treatments->sum('price');

        return [
            $packet->name,
            $treatmentNames,
            $packet->packet_price,
            $packet->member_price,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $this->data->count() + 1;

        $sheet->getStyle("A1:D1")->getFont()->setBold(true);

        $sheet->getStyle("C2:C{$lastRow}")
              ->getNumberFormat()
              ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $sheet->getStyle("D2:D{$lastRow}")
              ->getNumberFormat()
              ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    }
}
