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

class DetailTransaksiSheet implements FromCollection, WithHeadings, WithTitle, WithEvents
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
        return DB::table('transaksi_items')
        ->join('transaksi', 'transaksi.id', '=', 'transaksi_items.transaksi_id')
        ->join('master_barang', 'master_barang.id', '=', 'transaksi_items.master_barang_id')
        ->whereBetween('transaksi.tanggal', [$this->start, $this->end])
        ->where('transaksi.status', 'sudah')
        ->select(
            'transaksi.kode_transaksi',
            'transaksi.tanggal',
            'transaksi.no_polisi',
            'master_barang.nama',
            'transaksi_items.qty',
            'transaksi_items.harga',
            'transaksi_items.diskon',
            'transaksi_items.subtotal'
        )
        ->get();
    }

    public function headings(): array
    {
        return [
            'Kode Transaksi',
            'Tanggal',
            'No Polisi',
            'Item',
            'Qty',
            'Harga',
            'Diskon',
            'Subtotal'
        ];
    }


    public function title(): string
    {
        return 'Detail Transaksi';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                // Header bold
                $event->sheet->getStyle('A1:H1')->getFont()->setBold(true);

                $lastDataRow = $event->sheet->getHighestRow();
                $totalRow    = $lastDataRow + 1;

                // ===== FORMAT RUPIAH =====
                $event->sheet->getStyle("F2:H{$lastDataRow}")
                ->getNumberFormat()
                ->setFormatCode('"Rp" #,##0');

                // ===== HITUNG TOTAL SUBTOTAL =====
                $totalSubtotal = DB::table('transaksi_items')
                ->join('transaksi', 'transaksi.id', '=', 'transaksi_items.transaksi_id')
                ->whereBetween('transaksi.tanggal', [$this->start, $this->end])
                ->where('transaksi.status', 'sudah')
                ->sum('transaksi_items.subtotal');

                // ===== TULIS TOTAL =====
                $event->sheet->setCellValue("G{$totalRow}", 'TOTAL');
                $event->sheet->setCellValue("H{$totalRow}", $totalSubtotal);

                // ===== STYLE TOTAL =====
                $event->sheet->getStyle("G{$totalRow}:H{$totalRow}")
                ->getFont()->setBold(true);

                $event->sheet->getStyle("H{$totalRow}")
                ->getNumberFormat()
                ->setFormatCode('"Rp" #,##0');

                // Garis atas
                $event->sheet->getStyle("G{$totalRow}:H{$totalRow}")
                ->getBorders()->getTop()
                ->setBorderStyle(
                    \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                );

                // Auto size kolom
                foreach (range('A', 'H') as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                }
            }
        ];
    }

}
