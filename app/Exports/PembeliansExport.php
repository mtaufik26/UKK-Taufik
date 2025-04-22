<?php

namespace App\Exports;

use App\Models\Pembelians;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PembeliansExport implements FromCollection, WithHeadings, WithColumnFormatting, WithStyles, WithTitle, ShouldAutoSize, WithEvents
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function title(): string
    {
        return 'Laporan Penjualan';
    }

    public function collection()
    {
        $query = Pembelians::with('details.product')
            ->select('id', 'invoice_number', 'customer_name', 'grand_total', 'tanggal', 'dibuat_oleh')
            ->orderBy('tanggal', 'desc');
            
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('tanggal', [$this->startDate, $this->endDate]);
        }

        $pembelians = $query->get();
        $exportData = collect();

        foreach ($pembelians as $pembelian) {
            $exportData->push([
                'No. Invoice' => $pembelian->invoice_number,
                'Nama Pelanggan' => $pembelian->customer_name,
                'Tanggal' => $pembelian->tanggal,
                'Total Pembelian' => $pembelian->grand_total,
                'Dibuat Oleh' => $pembelian->dibuat_oleh,
            ]);
        }

        return $exportData;
    }

    public function headings(): array
    {
        return [
            'No. Invoice',
            'Nama Pelanggan',
            'Tanggal',
            'Total Pembelian',
            'Dibuat Oleh'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Header style
        $sheet->getStyle('A1:E1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => Color::COLOR_WHITE],
                'size' => 12,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => '2C3E50'],
            ],
        ]);

        // Update data range for new column count
        $dataRange = 'A2:E' . $sheet->getHighestRow();
        $sheet->getStyle($dataRange)->applyFromArray([
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '95A5A6'],
                ],
            ],
        ]);

        // Set minimum row height for data
        for ($i = 2; $i <= $sheet->getHighestRow(); $i++) {
            $sheet->getRowDimension($i)->setRowHeight(25);
        }

        // Column specific formatting
        $sheet->getStyle('E2:I' . $sheet->getHighestRow())->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        
        $sheet->getStyle('C2:C' . $sheet->getHighestRow())
            ->getNumberFormat()
            ->setFormatCode('dd/mm/yyyy');
        
        // Currency formatting
        $sheet->getStyle('F2:H' . $sheet->getHighestRow())
            ->getNumberFormat()
            ->setFormatCode('_("Rp"* #,##0_);_("Rp"* -#,##0_);_("Rp"* "-"??_);_(@_)');

        // Zebra striping
        for ($row = 2; $row <= $sheet->getHighestRow(); $row++) {
            if ($row % 2 == 0) {
                $sheet->getStyle('A' . $row . ':I' . $row)
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('F5F6FA');
            }
        }

        // Auto-size columns
        foreach (range('A', 'I') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $lastRow = $event->sheet->getHighestRow();
                $totalRow = $lastRow + 1;

                // Add total row
                $event->sheet->setCellValue('A' . $totalRow, 'TOTAL');
                $event->sheet->setCellValue('G' . $totalRow, '=SUM(G2:G' . $lastRow . ')');
                $event->sheet->setCellValue('H' . $totalRow, '=SUM(H2:H' . $lastRow . ')');

                // Style total row
                $event->sheet->getStyle('A' . $totalRow . ':I' . $totalRow)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 11,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'color' => ['argb' => 'E8F0FE'],
                    ],
                    'borders' => [
                        'top' => [
                            'borderStyle' => Border::BORDER_MEDIUM,
                            'color' => ['argb' => '2C3E50'],
                        ],
                        'bottom' => [
                            'borderStyle' => Border::BORDER_MEDIUM,
                            'color' => ['argb' => '2C3E50'],
                        ],
                    ],
                ]);

                // Add filters
                $event->sheet->setAutoFilter('A1:I1');
            },
        ];
    }

    public function columnFormats(): array
        {
            return [
                'C' => NumberFormat::FORMAT_DATE_DDMMYYYY,
                'D' => '_("Rp"* #,##0_);_("Rp"* -#,##0_);_("Rp"* "-"??_);_(@_)',
            ];
        }
}