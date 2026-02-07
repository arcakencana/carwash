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

class TransaksiSheet implements FromCollection, WithHeadings, WithTitle, WithEvents
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
        return DB::table('transaksi')
        ->whereBetween('tanggal', [$this->start, $this->end])
        ->where('status', 'sudah')
        ->select(
            'kode_transaksi',
            'no_polisi',
            'keterangan',
            'no_wa',
            'jenis_bayar',
            'total_harga'
        )
        ->get();
    }

    public function headings(): array
    {
        return [
            'Kode Transaksi',
            'No Pelat',
            'Keterangan',
            'No Whatsapp',
            'Jenis Bayar',
            'Total Bayar'
        ];
    }

    public function title(): string
    {
        return 'Transaksi';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                // ===== BASIC STYLE =====
                $event->sheet->getStyle('A1:F1')->getFont()->setBold(true);

                $lastDataRow = $event->sheet->getHighestRow();

                $event->sheet->getStyle("F2:F{$lastDataRow}")
                ->getNumberFormat()
                ->setFormatCode('"Rp" #,##0');

                foreach (range('A', 'F') as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                }

                // ===== HITUNG BARIS TERAKHIR =====
                $lastRow = $event->sheet->getHighestRow() + 2;

                // ===== SUMMARY TRANSAKSI =====
                $summary = DB::table('transaksi')
                ->whereBetween('tanggal', [$this->start, $this->end])
                ->where('status', 'sudah')
                ->selectRaw('
                    SUM(total_harga) as total_bayar,
                    SUM(CASE WHEN jenis_bayar = "cash" THEN total_harga ELSE 0 END) as cash,
                    SUM(CASE WHEN jenis_bayar = "qris" THEN total_harga ELSE 0 END) as qris,
                    SUM(CASE WHEN jenis_bayar = "debit" THEN total_harga ELSE 0 END) as debit
                    ')
                ->first();

                // ===== TOTAL PENGELUARAN =====
                $totalPengeluaran = DB::table('pengeluaran_harian')
                ->whereBetween('tanggal', [$this->start, $this->end])
                ->sum('nominal');

                // ===== LABA BERSIH =====
                $labaBersih = $summary->total_bayar - $totalPengeluaran;

                // ===== TULIS KE EXCEL =====
                $event->sheet->setCellValue("E{$lastRow}", 'TOTAL PENDAPATAN');
                $event->sheet->setCellValue("F{$lastRow}", $summary->total_bayar);

                $event->sheet->setCellValue("E" . ($lastRow + 1), 'CASH');
                $event->sheet->setCellValue("F" . ($lastRow + 1), $summary->cash);

                $event->sheet->setCellValue("E" . ($lastRow + 2), 'QRIS');
                $event->sheet->setCellValue("F" . ($lastRow + 2), $summary->qris);

                $event->sheet->setCellValue("E" . ($lastRow + 3), 'DEBIT');
                $event->sheet->setCellValue("F" . ($lastRow + 3), $summary->debit);

                // ===== PENGELUARAN =====
                $event->sheet->setCellValue("E" . ($lastRow + 5), 'TOTAL PENGELUARAN');
                $event->sheet->setCellValue("F" . ($lastRow + 5), $totalPengeluaran);

                // ===== LABA BERSIH =====
                $event->sheet->setCellValue("E" . ($lastRow + 6), 'LABA BERSIH');
                $event->sheet->setCellValue("F" . ($lastRow + 6), $labaBersih);

                $event->sheet->getStyle("E{$lastRow}:F" . ($lastRow + 6))
                ->getFont()->setBold(true);

                $event->sheet->getStyle("F{$lastRow}:F" . ($lastRow + 6))
                ->getNumberFormat()
                ->setFormatCode('"Rp" #,##0');

                // Warna khusus
                $event->sheet->getStyle("E" . ($lastRow + 5) . ":F" . ($lastRow + 5))
                ->getFont()->getColor()->setRGB('DC2626'); // merah pengeluaran

                $event->sheet->getStyle("E" . ($lastRow + 6) . ":F" . ($lastRow + 6))
                ->getFont()->getColor()->setRGB('16A34A'); // hijau laba


            }
        ];
    }
}
