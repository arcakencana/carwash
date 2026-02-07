<?php

namespace App\Exports\Sheets;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithTitle,
    WithEvents
};
use Maatwebsite\Excel\Events\AfterSheet;

class DetailPengeluaranSheet implements FromCollection, WithHeadings, WithTitle, WithEvents
{
    protected $start;
    protected $end;

    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end   = $end;
    }

    public function collection()
    {
        return DB::table('pengeluaran_harian')
        ->whereBetween('tanggal', [$this->start, $this->end])
        ->select(
            'tanggal',
            'keterangan',
            'nominal'
        )
        ->get();
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Keterangan',
            'Nominal'
        ];
    }


    public function title(): string
    {
        return 'Detail Pengeluaran';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                // Header bold
                $event->sheet->getStyle('A1:C1')->getFont()->setBold(true);

                $lastDataRow = $event->sheet->getHighestRow();
                $totalRow    = $lastDataRow + 1;

                // ===== FORMAT RUPIAH DATA =====
                $event->sheet->getStyle("C2:C{$lastDataRow}")
                ->getNumberFormat()
                ->setFormatCode('"Rp" #,##0');

                // ===== HITUNG TOTAL PENGELUARAN =====
                $totalPengeluaran = DB::table('pengeluaran_harian')
                ->whereBetween('tanggal', [$this->start, $this->end])
                ->sum('nominal');

                // ===== TULIS TOTAL =====
                $event->sheet->setCellValue("B{$totalRow}", 'TOTAL PENGELUARAN');
                $event->sheet->setCellValue("C{$totalRow}", $totalPengeluaran);

                // ===== STYLE TOTAL =====
                $event->sheet->getStyle("B{$totalRow}:C{$totalRow}")
                ->getFont()->setBold(true);

                $event->sheet->getStyle("C{$totalRow}")
                ->getNumberFormat()
                ->setFormatCode('"Rp" #,##0');

                // Garis atas biar rapi
                $event->sheet->getStyle("B{$totalRow}:C{$totalRow}")
                ->getBorders()->getTop()
                ->setBorderStyle(
                    \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                );

                // Auto size
                foreach (range('A', 'C') as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                }
            }
        ];
    }

}
