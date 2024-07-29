<?php

namespace App\Exports\Report;

use App\Repository\ReportRepository;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class IncomeExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithColumnFormatting, WithStyles
{
    private $data;

    public function __construct(
        protected ReportRepository $repo,
        protected $month = null,
        protected $year = null,
        protected $franchiseId = null,
        protected $therapistId = null
    ) {
    }

    public function collection()
    {
        $data = $this->repo->income(
            month: $this->month,
            year: $this->year,
            franchiseId: $this->franchiseId,
            therapistId: $this->therapistId
        );

        $this->data = $data;
        return $data;
    }

    public function map($row): array
    {
        return [
            $row->therapist->fullname,
            $row->customer->fullname,
            Date::dateTimeToExcel($row->date),
            "$row->total_packets paket, $row->total_treatments treatment",
            $row->totals,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    public function headings(): array
    {
        return [
            'Terapis',
            'Customer',
            'Tanggal',
            'Reservasi',
            'Total',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $row = $this->data->count() + 2;

        $sheet->getStyle("A1:E1")->getFont()->setBold(true);

        $sheet->mergeCells("A{$row}:D{$row}");
        $sheet->setCellValue("A{$row}", "Total");
        $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Add Subtotal
        $sheet->setCellValue("E{$row}", $this->data->sum('totals'));
        $sheet->getStyle("E{$row}")->getNumberFormat()
            ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    }
}
