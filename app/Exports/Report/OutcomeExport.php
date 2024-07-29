<?php

namespace App\Exports\Report;

use App\Repository\ReportRepository;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OutcomeExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithColumnFormatting, WithStyles
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
        $data = $this->repo->outcome(
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
            $row->fullname,
            $row->reservations->count() . "kali",
            $row->reservations->sum('totals'),
            $row->meal,
            $row->meal + $row->reservations->sum('totals')
        ];
    }

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    public function headings(): array
    {
        return [
            'Terapis',
            'Total Reservasi',
            'Total',
            'Uang Makan',
            'Subtotal',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $row = $this->data->count() + 2;
        $grandTotals = $this->data->reduce(function ($carry, $row) {
            return $row->meal + $row->reservations->sum('totals');
        }, 0);

        $sheet->getStyle("A1:E1")->getFont()->setBold(true);

        $sheet->mergeCells("A{$row}:D{$row}");
        $sheet->setCellValue("A{$row}", "Grand Total");
        $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Add Grand Total
        $sheet->setCellValue("E{$row}", $grandTotals);
        $sheet->getStyle("E{$row}")->getNumberFormat()
            ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    }
}
