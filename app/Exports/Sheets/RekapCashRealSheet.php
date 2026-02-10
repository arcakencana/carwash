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

class RekapCashRealSheet implements FromCollection, WithHeadings, WithTitle, WithEvents
{
    protected string $start;
    protected string $end;

    public function __construct(string $start, string $end)
    {
        $this->start = $start;
        $this->end   = $end;
    }

    public function collection()
    {
        // 1️⃣ TOTAL UNTUNG DARI RINGKASAN ITEM
        $totalUntungItem = DB::table('transaksi_items as ti')
            ->join('transaksi as t', 't.id', '=', 'ti.transaksi_id')
            ->join('master_barang as mb', 'mb.id', '=', 'ti.master_barang_id')
            ->whereBetween('t.tanggal', [$this->start, $this->end])
            ->where('t.status', 'sudah')
            ->selectRaw('
                SUM(
                    (ti.qty * (ti.harga - mb.harga_modal)) - ti.diskon
                ) as total_untung
            ')
            ->value('total_untung') ?? 0;

        // 2️⃣ TOTAL BAYAR QRIS + DEBIT
        $totalNonCash = DB::table('transaksi')
            ->whereBetween('tanggal', [$this->start, $this->end])
            ->where('status', 'sudah')
            ->whereIn('jenis_bayar', ['qris', 'debit'])
            ->sum('total_harga');

        // 3️⃣ TOTAL PENGELUARAN
        $totalPengeluaran = DB::table('pengeluaran_harian')
            ->whereBetween('tanggal', [$this->start, $this->end])
            ->sum('nominal');

        // 4️⃣ TOTAL AKHIR (CASH REAL)
        $totalCashReal = $totalUntungItem - $totalNonCash - $totalPengeluaran;

        return collect([
            ['Total Untung Item', $totalUntungItem],
            ['Total Bayar QRIS + Debit', $totalNonCash],
            ['Total Pengeluaran', $totalPengeluaran],
            ['Sisa Cash Real', $totalCashReal],
        ]);
    }

    public function headings(): array
    {
        return [
            'Keterangan',
            'Nominal'
        ];
    }

    public function title(): string
    {
        return 'Rekap Cash Real';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet;

                // Header bold
                $sheet->getStyle('A1:B1')->getFont()->setBold(true);

                // Baris sisa cash bold
                $lastRow = $sheet->getHighestRow();
                $sheet->getStyle("A{$lastRow}:B{$lastRow}")
                    ->getFont()->setBold(true);

                // Format Rupiah
                $sheet->getStyle("B2:B{$lastRow}")
                    ->getNumberFormat()
                    ->setFormatCode('"Rp" #,##0');

                // Auto width
                foreach (['A','B'] as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            }
        ];
    }
}
